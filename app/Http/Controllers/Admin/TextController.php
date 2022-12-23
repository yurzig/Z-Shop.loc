<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TextCreateRequest;
use App\Http\Requests\TextUpdateRequest;
use App\Models\Text;
use App\Repositories\SettingRepository;
use App\Repositories\TextRepository;
use App\Services\TextService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextController extends Controller
{
    private $textRepository;
    private $settingRepository;
    private $perPage;

    public function __construct()
    {
        $this->textRepository = app(TextRepository::class);
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
        $sort = session('texts_sort', ['id', 'asc']);
        $filter = session('texts_filter', []);
        $items = $this->textRepository->getAll($sort, $filter, $this->perPage);
        $columns = session('texts_columns', ['id', 'type', 'title']);
        $types = $this->settingRepository->getSetting('text-types');

        return view('admin.texts.index', compact('items',
                                                       'columns',
                                                                 'filter',
                                                                 'sort',
                                                                 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $types = $this->settingRepository->getSetting('text-types');

        return view('admin.texts.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TextCreateRequest $request)
    {
        $data = $request->input();
        $data['editor'] = Auth::id();

        $item = (new Text())->create($data);

        if (!$item) {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                         ->withInput();
        }

        return TextService::actionAfterSaving($item, $request->action);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->textRepository->getRow($id);
        if (empty($item)) {
            abort(404);
        }
        $objects = $this->textRepository->getUsage($id);
        $types = $this->settingRepository->getSetting('text-types');

        return view('admin.texts.edit', compact('item',
            'objects',
            'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TextUpdateRequest $request, $id)
    {
        $item = $this->textRepository->getRow($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $data['editor'] = Auth::id();
        $result = $item->update($data);

        return TextService::actionAfterSaving($result, $request->action);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->textRepository->getRow($id);
        $result = Text::destroy($id);

        if (!$result) {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

        return to_route('admin.text.index')
                ->with(['success' => "Удалена запись id[$id] - $item->title"]);
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function columnsSave(Request $request)
    {
        session(['texts_columns' => $request->field]);
        return to_route('admin.texts.index');
    }

    public function search(Request $request)
    {
        session(['texts_filter' => $request->filter]);
        return to_route('admin.texts.index');
    }

    public function sort(Request $request)
    {
        $direction = 'asc';
        if ($request->session()->has('texts_sort')) {
            $sort = session('texts_sort');
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }

        session(['texts_sort' => [$request->order, $direction]]);

        return to_route('admin.texts.index');
    }

    public function reset()
    {
        session(['texts_filter' => []]);
        return to_route('admin.texts.index');
    }

    public function textsUpdating($item, $textItems)
    {
        $ids = [];
        foreach ($textItems as $textItem) {
            if (is_null($textItem['id'])) {
                $textItem['editor'] = Auth::id();
                $textNew = $item->texts()->create($textItem);
                $ids[] = $textNew->id;
            } else {
                $ids[] = $textItem['id'];
            }
        }
        $item->texts()->sync($ids);

        return true;
    }
    public function ajaxGetRow(Request $request)
    {
        $types = $this->settingRepository->getSetting('text-types');
        $text = $this->textRepository->getRow($request->input('id'));
        $text->type = $types[$text->type];

        return response()->json($text);
    }
}
