<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BlogImageController extends Controller
{
    /**
     * Serve blog images from storage (for backward compatibility with old paths).
     */
    public function show(string $path): StreamedResponse|\Illuminate\Http\Response
    {
        $path = str_replace(['../', '..\\'], '', $path);

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $mime = Storage::disk('public')->mimeType($path);
        $stream = Storage::disk('public')->readStream($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
