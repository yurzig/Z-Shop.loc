<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingCreateRequest;
use App\Http\Requests\SettingUpdateRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private $settingRepository;
    private $perPage;

    public function __construct()
    {
        $this->settingRepository = app(SettingRepository::class);
        $this->perPage = 25;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sort = session('settings_sort', ['id', 'asc']);
        $filter = session('settings_filter', []);
        $items = $this->settingRepository->getAll($sort, $filter, $this->perPage);
        $columns = session('settings_columns', ['id', 'slug', 'description']);

        return view('admin.settings.index', compact('items',
                                                       'columns',
                                                                 'filter',
                                                                 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SettingCreateRequest $request)
    {
        $data = $request->input();
        $data['editor'] = Auth::id();

        $item = (new Setting())->create($data);

        return SettingService::actionAfterSaving($item, $request->action);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->settingRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        return view('admin.settings.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingUpdateRequest $request, $id)
    {
        $item = $this->settingRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $data['editor'] = Auth::id();
        $result = $item->update($data);

        return SettingService::actionAfterSaving($result, $request->action);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->settingRepository->getEdit($id);
        $result = Setting::destroy($id);

        if ($result) {
            return redirect()
                ->route('admin.settings.index')
                ->with(['success' => "Удалена запись id[$id] - $item->title"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function columnsSave(Request $request)
    {
        session(['settings_columns' => $request->field]);
        return $this->index();
    }

    public function search(Request $request)
    {
        session(['settings_filter' => $request->filter]);
        return to_route('admin.settings.index');
    }

    public function sort(Request $request)
    {
        $direction = 'asc';
        if ($request->session()->has('settings_sort')) {
            $sort = session('settings_sort');
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }

        session(['settings_sort' => [$request->order, $direction]]);
        return to_route('admin.settings.index');
    }

    public function reset()
    {
        session(['settings_filter' => []]);
        return to_route('admin.settings.index');
    }
}
