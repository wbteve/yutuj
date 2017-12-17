<?php

namespace App\Http\Controllers;

use Exception;
use Intervention\Image\Facades\Image;

class ThumbController extends Controller
{
    public function __invoke($width, $height, $url)
    {
        try {
            $url = storage_path('app/public/' . base64_decode($url));
            return Image::cache(function ($image) use ($url, $width, $height) {
                $image->make($url)->fit($width, $height);
            }, 5, true)->response();
        } catch (Exception $e) {
            return Image::canvas(150, 150, '#DDD')->text('Image Not Found.', 35, 80, function ($font) {
                $font->color('#666666');
            })->response();
        }
    }
}
