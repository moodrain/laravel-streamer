<?php

namespace Moodrain\LaravelStreamer;

use Illuminate\Support\Facades\Request;

class LaravelStreamer {

    private $buffer;

    public function __construct(int $buffer) {
        $this->buffer = $buffer;
    }

    public function stream(string $file, Request $request = null) {
        $request = $request ?? request();
        $mime = mime_content_type($file);
        $size = filesize($file);
        $range = $request->header('Range');
        $start = $range ? explode('-', explode('=', $range)[1])[0] : 0;
        $contentLength = $length = $this->buffer;
        if($start + $length > $size) {
            $contentLength = $size - $start;
        }
        return response(file_get_contents($file, false, null, $start, $contentLength), 206)
            ->withHeaders([
                'Content-Type' => $mime,
                'Accept-Ranges' => 'bytes',
                'Content-Length' => $contentLength,
                'Content-Range' => 'bytes ' . $start . '-' . ($start + $contentLength - 1) . '/' . $size,
            ]);
    }

}