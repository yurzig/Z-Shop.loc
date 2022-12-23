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
            'edit' => to_route('admin.settings.edit', $item)->with(['success' => 'Успешно сохранено']),
            'new' => to_route('admin.settings.create')->with(['success' => 'Успешно сохранено']),
            default => to_route('admin.settings.index')->with(['success' => 'Успешно сохранено']),
        };
    }
}
