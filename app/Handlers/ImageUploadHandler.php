<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    /**
     * 上传图片
     *
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     * @param  string  $filename
     * @param  string  $dirname
     * @param  string  $path
     * @param  string  $driver
     * @param  int  $max_width
     * @return \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null
     */
    public function save($request, $filename, $dirname, $path, $driver, $max_width = 416)
    {
        // 保存图片
        $filepath = $request->file($filename)->store($path, $driver);
        // 裁剪图片
        $image = Image::make($dirname . '/' . $filepath);
        $image->fit($max_width);
        $image->save();

        return $filepath;
    }
}
