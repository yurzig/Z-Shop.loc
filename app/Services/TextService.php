<?php

namespace App\Services;

class TextService {
    public static function actionAfterSaving ($item, string $action)
    {
        if (!$item) {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
        return match ($action) {
            'edit' => redirect()->route('admin.texts.edit', $item)->with(['success' => 'Успешно сохранено']),
            'new' => redirect()->route('admin.texts.create')->with(['success' => 'Успешно сохранено']),
            default => redirect()->route('admin.texts.index')->with(['success' => 'Успешно сохранено']),
        };
    }
}
