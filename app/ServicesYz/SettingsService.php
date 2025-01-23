<?php

namespace App\ServicesYz;

use App\Models\Setting;
use App\Yz\Services\Traits\ActionAfterSaving;
use App\Yz\Services\Traits\ACTIONS;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Yz\Services\Service;
use Illuminate\Validation\Rule;

class SettingsService extends Service
{
    use ACTIONS, ActionAfterSaving;

    /**
     * Получить список настроек
     */
    public function getAll(?int $perPage = null): object
    {
        $filter = self::getFilters();
        $sort = self::getSort(['id', 'asc']);

        $query = Setting::query();
        if($filter) {
            foreach ($filter['val'] as $key => $item) {
                if (!is_null($item)) {
                    $query->where($key, $filter['op'][$key], $filter['op'][$key] === 'like' ? "%$item%" : $item);
                }
            }
        }
        $result = $query
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage);

        return $result;
    }

    /**
        Сохранение настройки
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->input();

        $data['editor'] = Auth::id();

        $this->saveValidate($data);

        $setting = (new Setting())->create($data);

        if (!$setting) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return $this->actionAfterSaving($setting, $request);
    }

    /**
        Обновить настройку
     */
    public function update(Request $request, Setting $setting):RedirectResponse
    {
        if (empty($setting)) {

            return back()
                ->withErrors(['msg' => "Запись id=[{$setting->id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        $data['editor'] = Auth::id();

        $this->saveValidate($data, $setting);

        $result = $setting->update($data);

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return $this->actionAfterSaving($setting, $request);
    }

    /**
        Удалить настройку
     */
    public function delete (Setting $setting): RedirectResponse
    {
        $item = $setting;

        $result = $setting->delete();

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with(['success' => "Удалена запись id[$item->id] - $item->title"]);
    }

    /**
        Валидация
     */
    public function saveValidate( array $data, Setting $setting = null ): void
    {
        Validator::make( $data, [
            'slug' => ['required',
                      // если модель создана, то не проверяем на уникальность
                      Rule::unique('settings')->ignore($setting),
                      'max:50'],
            'title' => 'nullable|max:200',
            'setting_values' => 'required',
        ])->validate();
    }

    /*
    Получить настройку по названию и ключу
    */
    public function getBySlug(string $slug, string $key = null): mixed
    {
        $setting = Setting::where('slug', $slug)->first();
        
        if (is_null($setting) || !is_array($setting->setting_values)) {

            return '';
        }

        // Преобразуем двумерный массив в одномерный ассоциативный
        $result = Arr::mapWithKeys($setting->setting_values, function (array $item, int $key) {

            return [$item['key'] => $item['value']];
        });

        // Если не задано конкретное свойство, то возвращаем массив
        if (is_null($key)) {

            return $result;
        }

        // Если запрос на конкретное свойство и оно существует
        if (array_key_exists($key, $result)) {

            return $result[$key];
        }

        return '';
    }

}
