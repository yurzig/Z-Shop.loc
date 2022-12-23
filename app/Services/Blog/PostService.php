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
            'edit' => to_route('admin.blog.posts.edit', $item)->with(['success' => 'Успешно сохранено']),
            'new' => to_route('admin.blog.posts.create')->with(['success' => 'Успешно сохранено']),
            default => to_route('admin.blog.posts.index')->with(['success' => 'Успешно сохранено']),
        };
    }
}
