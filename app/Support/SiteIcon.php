<?php

namespace App\Support;

use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SiteIcon
{
    public function store(Project $project): ?string
    {
        $page = $this->pageUrl($project->url ?: $project->github_url);

        if ($page === null) {
            return null;
        }

        $image = $this->discover($page);

        if ($image === null) {
            return null;
        }

        $binary = $image['binary'];
        $extension = $image['extension'];
        $path = 'projects/'.$project->slug.'.'.$extension;

        Storage::disk('public')->put($path, $binary);
        $project->forceFill([
            'icon_path' => $path,
            'icon_light' => (bool) ($image['light'] ?? false),
        ])->save();

        return $path;
    }

    private function pageUrl(mixed $page): ?string
    {
        if (! is_string($page)) {
            return null;
        }

        $page = trim($page);

        if ($page === '') {
            return null;
        }

        if (! preg_match('#^https?://#i', $page)) {
            $page = 'https://'.ltrim($page, '/');
        }

        return filter_var($page, FILTER_VALIDATE_URL) ? $page : null;
    }

    /**
     * @return array{binary: string, extension: string}|null
     */
    private function discover(string $pageUrl): ?array
    {
        try {
            $response = Http::timeout(12)
                ->withHeaders($this->headers())
                ->get($pageUrl);
        } catch (\Throwable) {
            return $this->download($this->origin($pageUrl).'/favicon.ico');
        }

        if (! $response->successful()) {
            return $this->download($this->origin($pageUrl).'/favicon.ico');
        }

        $finalUrl = (string) ($response->effectiveUri() ?: $pageUrl);
        $candidates = $this->candidates($response->body(), $finalUrl);

        foreach ($candidates as $candidate) {
            $image = $this->download($candidate);

            if ($image !== null) {
                return $image;
            }
        }

        return $this->download($this->origin($finalUrl).'/favicon.ico');
    }

    /**
     * @return list<string>
     */
    private function candidates(string $html, string $base): array
    {
        $found = [];

        if (str_contains($base, 'play.google.com') && preg_match('#https://play-lh\.googleusercontent\.com/[A-Za-z0-9_-]+#', $html, $play)) {
            $found[] = ['score' => 500, 'href' => $play[0].'=w256-h256'];
        }

        if (preg_match_all('/<link\b[^>]*>/i', $html, $tags)) {
            foreach ($tags[0] as $tag) {
                if (! preg_match('/\brel=["\']([^"\']+)["\']/i', $tag, $rel)) {
                    continue;
                }

                $relation = strtolower($rel[1]);

                if (! str_contains($relation, 'icon')) {
                    continue;
                }

                if (! preg_match('/\bhref=["\']([^"\']+)["\']/i', $tag, $href)) {
                    continue;
                }

                $size = 0;

                if (preg_match('/\bsizes=["\'](\d+)x/i', $tag, $sizes)) {
                    $size = (int) $sizes[1];
                }

                $score = (str_contains($relation, 'apple') ? 300 : 150) + $size;
                $found[] = ['score' => $score, 'href' => html_entity_decode($href[1], ENT_QUOTES)];
            }
        }

        if (preg_match('/<meta\b[^>]*(?:property|name)=["\']og:image["\'][^>]*>/i', $html, $meta)
            || preg_match('/<meta\b[^>]*content=["\'][^"\']+["\'][^>]*(?:property|name)=["\']og:image["\'][^>]*>/i', $html, $meta)) {
            if (preg_match('/\bcontent=["\']([^"\']+)["\']/i', $meta[0], $content)) {
                $found[] = ['score' => 40, 'href' => html_entity_decode($content[1], ENT_QUOTES)];
            }
        }

        if (preg_match_all('/<img\b[^>]*>/i', $html, $images)) {
            foreach ($images[0] as $tag) {
                if (! preg_match('/\b(?:src|data-src)=["\']([^"\']+)["\']/i', $tag, $src)) {
                    continue;
                }

                $blob = strtolower($tag);

                if (! str_contains($blob, 'logo')) {
                    continue;
                }

                $href = html_entity_decode($src[1], ENT_QUOTES);
                $found[] = [
                    'score' => str_contains($blob, 'white') ? 80 : 260,
                    'href' => $href,
                ];

                if (preg_match('#logo-white\.[a-z0-9]+#i', $href)) {
                    foreach (['logo.png', 'logo-dark.png', 'logo-black.png', 'logo-color.png'] as $name) {
                        $found[] = [
                            'score' => 270,
                            'href' => preg_replace('#logo-white\.[a-z0-9]+#i', $name, $href),
                        ];
                    }
                }
            }
        }

        usort($found, fn (array $a, array $b): int => $b['score'] <=> $a['score']);

        $urls = [];

        foreach ($found as $item) {
            $absolute = $this->absolute($item['href'], $base);

            if ($absolute !== '' && ! in_array($absolute, $urls, true)) {
                $urls[] = $absolute;
            }
        }

        return $urls;
    }

    /**
     * @return array{binary: string, extension: string}|null
     */
    private function download(string $url): ?array
    {
        if (str_starts_with($url, 'data:image/')) {
            return $this->fromDataUri($url);
        }

        if (! preg_match('#^https?://#i', $url)) {
            return null;
        }

        try {
            $response = Http::timeout(12)->withHeaders($this->headers())->get($url);
        } catch (\Throwable) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        $binary = $response->body();

        if ($binary === '' || strlen($binary) > 2_000_000) {
            return null;
        }

        $extension = $this->extension($binary, (string) $response->header('Content-Type'), $url);

        if ($extension === null) {
            return null;
        }

        return [
            'binary' => $binary,
            'extension' => $extension,
            'light' => $this->lightArtwork($binary, $extension) || str_contains(strtolower($url), 'logo-white'),
        ];
    }

    /**
     * @return array{binary: string, extension: string}|null
     */
    private function fromDataUri(string $uri): ?array
    {
        if (! preg_match('#^data:(image/[a-z0-9.+-]+);base64,(.+)$#i', $uri, $match)) {
            return null;
        }

        $binary = base64_decode($match[2], true);

        if ($binary === false || $binary === '' || strlen($binary) > 2_000_000) {
            return null;
        }

        $extension = $this->extension($binary, $match[1], '');

        return $extension ? ['binary' => $binary, 'extension' => $extension, 'light' => str_contains($uri, 'logo-white')] : null;
    }

    private function extension(string $binary, string $mime, string $url): ?string
    {
        $mime = strtolower(strtok($mime, ';') ?: '');
        $head = substr($binary, 0, 300);

        if (str_starts_with($head, "\x89PNG") || str_contains($mime, 'png')) {
            return 'png';
        }

        if (str_starts_with($head, "\xFF\xD8\xFF") || str_contains($mime, 'jpeg')) {
            return 'jpg';
        }

        if (str_starts_with($head, 'GIF8') || str_contains($mime, 'gif')) {
            return 'gif';
        }

        if (str_starts_with($head, 'RIFF') || str_contains($mime, 'webp')) {
            return 'webp';
        }

        if (str_contains($head, '<svg') || str_contains($mime, 'svg')) {
            return 'svg';
        }

        if (str_starts_with($head, "\x00\x00\x01\x00") || str_contains($mime, 'icon') || str_ends_with(strtolower(parse_url($url, PHP_URL_PATH) ?: ''), '.ico')) {
            return 'ico';
        }

        return null;
    }

    private function absolute(string $href, string $base): string
    {
        $href = trim($href);

        if ($href === '' || str_starts_with($href, 'data:')) {
            return str_starts_with($href, 'data:image/') ? $href : '';
        }

        if (preg_match('#^https?://#i', $href)) {
            return $href;
        }

        $origin = $this->origin($base);

        if (str_starts_with($href, '//')) {
            $scheme = parse_url($base, PHP_URL_SCHEME) ?: 'https';

            return $scheme.':'.$href;
        }

        if (str_starts_with($href, '/')) {
            return $origin.$href;
        }

        $path = parse_url($base, PHP_URL_PATH) ?: '/';
        $directory = rtrim(str_replace('\\', '/', dirname($path)), '/');

        return $origin.$directory.'/'.$href;
    }

    private function origin(string $url): string
    {
        $parts = parse_url($url);
        $origin = ($parts['scheme'] ?? 'https').'://'.($parts['host'] ?? '');

        if (isset($parts['port'])) {
            $origin .= ':'.$parts['port'];
        }

        return $origin;
    }

    private function lightArtwork(string $binary, string $extension): bool
    {
        if (! function_exists('imagecreatefromstring') || in_array($extension, ['svg', 'ico'], true)) {
            return false;
        }

        $image = @imagecreatefromstring($binary);

        if ($image === false) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $total = $width * $height;
        $step = max(1, intdiv($total, 400));
        $samples = 0;
        $sum = 0;

        for ($index = 0; $index < $total; $index += $step) {
            $color = imagecolorat($image, $index % $width, intdiv($index, $width));
            $alpha = ($color >> 24) & 0x7F;

            if ($alpha > 100) {
                continue;
            }

            $sum += (0.2126 * (($color >> 16) & 0xFF)) + (0.7152 * (($color >> 8) & 0xFF)) + (0.0722 * ($color & 0xFF));
            $samples++;
        }

        imagedestroy($image);

        return $samples > 0 && ($sum / $samples) > 185;
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [
            'User-Agent' => 'Mozilla/5.0 (compatible; IvanotechsIcon/1.0)',
            'Accept' => 'text/html,application/xhtml+xml,image/avif,image/webp,image/png,image/*,*/*;q=0.8',
        ];
    }
}
