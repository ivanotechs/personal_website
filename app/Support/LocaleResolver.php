<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LocaleResolver
{
    public const ALL = ['en', 'de', 'fr'];

    private const GERMAN = ['DE', 'AT', 'LI'];

    private const FRENCH = [
        'FR', 'MC', 'LU', 'CM', 'SN', 'CI', 'ML', 'BF', 'NE', 'TG', 'BJ', 'GA', 'CG', 'CD',
        'MG', 'HT', 'GN', 'TD', 'CF', 'DJ', 'KM', 'RW', 'BI', 'SC',
    ];

    public function resolve(Request $request): string
    {
        $country = $this->countryCode($request);

        if (in_array($country, ['BE', 'CH', 'CA'], true)) {
            return $this->fromHeader($request) ?? match ($country) {
                'BE' => 'fr',
                'CH' => 'de',
                default => 'en',
            };
        }

        if (in_array($country, self::GERMAN, true)) {
            return 'de';
        }

        if (in_array($country, self::FRENCH, true)) {
            return 'fr';
        }

        return $this->fromHeader($request) ?? 'en';
    }

    private function fromHeader(Request $request): ?string
    {
        $preferred = $request->getPreferredLanguage(['en', 'de', 'fr']);

        return in_array($preferred, self::ALL, true) ? $preferred : null;
    }

    private function countryCode(Request $request): ?string
    {
        $header = strtoupper((string) $request->headers->get('CF-IPCountry'));

        if (preg_match('/^[A-Z]{2}$/', $header) && $header !== 'XX') {
            return $header;
        }

        $ip = (string) $request->ip();

        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return null;
        }

        $cached = Cache::remember('geo-country:'.$ip, now()->addDay(), function () use ($ip) {
            try {
                $response = Http::timeout(1)->acceptJson()->get('http://ip-api.com/json/'.$ip, [
                    'fields' => 'status,countryCode',
                ]);

                if ($response->ok() && $response->json('status') === 'success') {
                    return strtoupper((string) $response->json('countryCode'));
                }
            } catch (\Throwable) {
                return '';
            }

            return '';
        });

        return $cached !== '' ? $cached : null;
    }
}
