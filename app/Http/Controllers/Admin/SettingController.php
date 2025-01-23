<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    private $perPage;

    public function __construct()
    {
        $this->perPage = 25;
    }

    /**
     * Список настроек
     */
    public function index(): View
    {
        $items = settings()->getAll($this->perPage);

        return view('admin.settings.index', compact('items'));
    }

    /**
     * Создание настройки (форма)
     */
    public function create(): View
    {

        return view('admin.settings.create');
    }

    /**
     * Создание настройки (сохранение)
     */
    public function store(Request $request): RedirectResponse
    {

        return settings()->store($request);
    }

    /**
     * Редактирование настройки (форма)
     */
    public function edit(Setting $setting): View
    {

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Редактирование настройки (сохранение)
     */
    public function update(Request $request, Setting $setting): RedirectResponse
    {

        return settings()->update($request, $setting);
    }

    /**
     * Удаление настройки
     */
    public function destroy(Setting $setting): RedirectResponse
    {

        return settings()->delete($setting);
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function columns(Request $request): RedirectResponse
    {
        settings()->setColumns($request->fields);

        return to_route('admin.settings.index');
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    public function filter(Request $request): RedirectResponse
    {
        posts()->setFilters($request->filters);

        return to_route('admin.posts.index');
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function resetFilters(): RedirectResponse
    {
        settings()->resetFilters();

        return to_route('admin.settings.index');
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function sort(Request $request): RedirectResponse
    {
        settings()->setSort($request);

        return to_route('admin.settings.index');
    }
}