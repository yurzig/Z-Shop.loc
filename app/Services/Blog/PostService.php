<?php

namespace App\Services\Blog;

class PostService {
    public static function actionAfterSaving ($item, $action)
    {
        if (!$item) {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
        return match ($action) {
            'edit' => redirect()->route('admin.blog.posts.edit', $item)->with(['success' => 'Успешно сохранено']),
            'new' => redirect()->route('admin.blog.posts.create')->with(['success' => 'Успешно сохранено']),
            default => redirect()->route('admin.blog.posts.index')->with(['success' => 'Успешно сохранено']),
        };
    }
}
