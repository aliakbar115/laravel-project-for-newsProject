<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function uploadImages($file)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $imagePath = "upload/images/{$year}/{$month}/";  // "upload/images/2021/11/"
        $filename = $file->getClientOriginalName(); // "faranesh.jpg"
        $file = $file->move(public_path($imagePath), $filename);
        $sizes = ["300", "600", "900"];
        // $file->getRealPath()   "E:\siteFaranesh\public\upload\images\2021\11\faranesh.jpg"  آدرس کامل
        $url['images'] = $this->resize($file->getRealPath(), $sizes, $imagePath, $filename);

        $url['thumb'] = $url['images'][$sizes[0]];

        return $url;
    }

    protected function resize($path, $sizes, $imagePath, $filename)
    {
        //composer require intervention/image   استفاده از پکیج
        $images['original'] = $imagePath . $filename; // کیفیت اورجینال عکس
        foreach ($sizes as $size) {
            $images[$size] = $imagePath . "{$size}_" . $filename;
            Image::make($path)->resize($size, //http://image.intervention.io/api/resize بر اساس
                null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path($images[$size])); // http://image.intervention.io/api/save
        }
        return $images;
    }
}
