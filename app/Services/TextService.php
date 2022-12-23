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
            'edit' => to_route('admin.texts.edit', $item)->with(['success' => 'Успешно сохранено']),
            'new' => to_route('admin.texts.create')->with(['success' => 'Успешно сохранено']),
            default => to_route('admin.texts.index')->with(['success' => 'Успешно сохранено']),
        };
    }
}
