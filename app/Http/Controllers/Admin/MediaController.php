<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MediaCreateRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Models\Media;
use App\Repositories\MediaRepository;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MediaController extends Controller
{
    private $mediaRepository;
    private $settingRepository;
    private $perPage;

    public function __construct()
    {
        $this->mediaRepository = app(MediaRepository::class);
        $this->settingRepository = app(SettingRepository::class);
        $this->perPage = 25;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index2()
    {
        $sort = session('media-sort', ['id', 'asc']);
        $filter = session('media-filter', []);
        $items = $this->mediaRepository->getAll($sort, $filter, $this->perPage);
//        dd($items);
        $columns = session('media-columns', ['id', 'title', 'link']);
        $placements = $this->settingRepository->getSetting('media-placements');

        return view('admin.medias.index', compact('items',
            'columns',
            'filter',
            'sort',
            'placements'));
    }
    public function index()
    {
        $items = $this->mediaRepository->getGallery($this->perPage);
        $placements = $this->settingRepository->getSetting('media-placements');

        return view('admin.medias.gallery', compact('items', 'placements'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MediaCreateRequest $request)
    {
        $data = $request->input();
        $data['editor'] = Auth::user()->email;

        if($request->has('imagefile')){
            $data['link'] = $this->saveImage($request->file('imagefile'), $data['object']);
        }
        $item = (new Media())->create($data);

        $fileOld = session()->pull('media-file');
        if ($fileOld) {
            Storage::delete($fileOld);
        }
        if ($item) {
            return to_route('admin.media.edit', $item)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    public function saveImage($image, $path){
        if($image != null) {
            $parts = pathinfo($image->getClientOriginalName());
            $name = Str::slug($parts['filename']) . '.' . $parts['extension'];
            $i = 0;
            while (Storage::exists($path . '/' . $name)) {
                $name = ++$i . '_' . $image->getClientOriginalName();
            }
            $image_path = $image->storeAs($path, $name);
            return 'storage/' . $image_path;
        } else {
            return null;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->mediaRepository->getRow($id);
        if (empty($item)) {
            abort(404);
        }
        $placements = $this->settingRepository->getSetting('media-placements');

        return view('admin.medias.edit', compact('item', 'placements'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MediaUpdateRequest $request, $id)
    {
        $item = $this->mediaRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $data['editor'] = Auth::user()->email;

        if($request->has('imagefile')){
            Storage::delete($item->link);

            $data['link'] = $this->saveImage($request->file('imagefile'), $data['object']);
        }

        $result = $item->update($data);

        $fileOld = session()->pull('media-file');
        if ($fileOld) {
            Storage::delete($fileOld);
        }

        if ($result) {
            return redirect()
                ->route('admin.media.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->mediaRepository->getEdit($id);

        $result = Media::destroy($id);

        if ($result) {
            return redirect()
                ->route('admin.media.index')
                ->with(['success' => "Удалена запись id[$id] - $item->title"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
    public function mediasUpdating($item, $request, $object, $subobject=null)
    {
        $ids = [];
        foreach ($request->input('media') as $key => $mediaItem) {
            if (is_null($mediaItem['id'])) {
                $validatedData = $request->validate([
                    'media' . $key => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ]);

                $imageFile = $request->file('media' . $key);

                $path = (is_null($subobject)) ? $object : $object . '/' . $subobject;
                $imageFile->store($path);
//                dd(__METHOD__, $path, $name, $imageFile->hashName());
                $mediaItem['object'] = $object;
                $mediaItem['subobject'] = $subobject;
                $mediaItem['link'] = $imageFile->hashName();

                $mediaNew = $item->medias()->create($mediaItem,['placement' => $mediaItem['placement']]);
                $ids[] = $mediaNew->id;
            } else {
                $ids[] = $mediaItem['id'];
            }
        }
        $item->medias()->sync($ids);
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function columnsSave(Request $request)
    {
        session(['media-columns' => $request->field]);
        return $this->index();
    }

    public function sort(Request $request)
    {
        $direction = 'asc';
        if ($request->session()->has('media-sort')) {
            $sort = session('media-sort');
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }
        session(['media-sort' => [$request->order, $direction]]);
        return $this->index();
    }

    private function search(Request $request)
    {
        session(['media-filter' => $request->filter]);
        return $this->index();
    }

    public function formList(Request $request)
    {
        switch($request->action) {
            case 'search':
                return $this->search($request);
            case 'reset':
                session(['media-filter' => []]);
                break;
        }
        return $this->index();
    }

}
