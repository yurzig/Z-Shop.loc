<?php

namespace App\Services;

class SettingService {
    public static function actionAfterSaving ($item, string $action)
    {
        if (!$item) {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
        return match ($action) {
            'edit' => redirect()->route('admin.settings.edit', $item)->with(['success' => 'Успешно сохранено']),
            'new' => redirect()->route('admin.settings.create')->with(['success' => 'Успешно сохранено']),
            default => redirect()->route('admin.settings.index')->with(['success' => 'Успешно сохранено']),
        };
    }
}
