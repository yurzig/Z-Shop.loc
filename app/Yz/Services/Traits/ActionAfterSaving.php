<?php

namespace App\Yz\Services\Traits;

use App\Models\Blog\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait ActionAfterSaving
{
    /**
     *   Действия после сохранения/обновления
     */
    public static function actionAfterSaving ($model, Request $request)
    {
        $model_name = str($model->getTable())->replace('_', '.', $model->getTable());

        return match ($request->action) {
            'edit' => to_route('admin.' . $model_name . '.edit', $model)->with(['success' => 'Успешно сохранено']),
            'new' => to_route('admin.' . $model_name . '.create')->with(['success' => 'Успешно сохранено']),
            default => to_route('admin.' . $model_name . '.index')->with(['success' => 'Успешно сохранено']),
        };
    }

}
