<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Загружает изображение, которое было добавлено в wysiwyg-редакторе и
     * возвращает ссылку на него, чтобы в редакторе вставить <img src="…"/>
     */
    public function upload(Request $request) {
        $data = [];
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            $data['success'] = 0;
            $data['message'] = $validator->errors()->first('file');// Error response
            return response()->json($data);
        }

        $path = $request->file('image')->store('upload');
        $filepath = Storage::disk('public')->url($path);

        $data['success'] = 1;
        $data['filepath'] = $filepath;
        return response()->json($data);
    }

    /**
     * Удаляет изображение, которое было удалено в wysiwyg-редакторе
     */
//    public function remove(Request $request) {
//        $path = parse_url($request->remove, PHP_URL_PATH);
//        $path = str_replace('/storage/', '', $path);
//        Storage::disk('public')->delete($path);
//    }

}
