<?php

namespace App\Http\Controllers;

use App\Support\PublicMedia;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function show(string $path): StreamedResponse
    {
        $path = PublicMedia::normalize($path);

        if ($path === null || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path, headers: [
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
