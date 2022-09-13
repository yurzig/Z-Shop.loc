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
        switch ($action) {
            case 'edit':
                return redirect()->route('admin.blog.posts.edit', $item)->with(['success' => 'Успешно сохранено']);
                break;
            case 'new':
                return redirect()->route('admin.blog.posts.create')->with(['success' => 'Успешно сохранено']);
                break;
            default:
                return redirect()->route('admin.blog.posts.index')->with(['success' => 'Успешно сохранено']);
        }
    }
}
