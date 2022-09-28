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
use Illuminate\Support\Facades\Validator;
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
    public function index()
    {
        $sort = session('media-sort', ['id', 'asc']);
        $filter = session('media-filter', []);
        $items = $this->mediaRepository->getAll($sort, $filter, $this->perPage);
        $columns = session('media-columns', ['id', 'ref_id', 'object', 'title', 'link']);

        return view('admin.media.index', compact('items',
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
            return redirect()->route('admin.media.edit', $item)
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
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->mediaRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        return view('admin.media.edit', compact('item'));
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

    public function updatingList($medias, $ref_id, $object) {
        foreach ($medias as $key => $media) {
            if ($key === 'delete') {
                foreach ($media as $id => $value) {
                    Media::destroy($id);
                }
            } else if (array_key_exists('id', $media) && $media['id'] != '') {
                $item = $this->mediaRepository->getEdit($media['id']);

                $data = [
                    'title' => $media['title'],
                    'placement' => $media['placement'],
                    'status' => $media['status'],
                    'editor' => Auth::user()->email,
                ];

                if(isset($media['imagefile'])) {
                    Storage::delete($item->link);
                    $data['link'] = $this->saveImage($media['imagefile'], $object);
                }

                $item->update($data);
            } else {
                $data = [
                    'ref_id' => $ref_id,
                    'object' => $object,
                    'title' => $media['title'],
                    'placement' => $media['placement'],
                    'status' => $media['status'],
                    'editor' => Auth::user()->email,
                ];
                if(isset($media['imagefile'])){
                    $data['link'] = $this->saveImage($media['imagefile'], $object);
                }

                (new Media())->create($data);
            }
        }
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
    public function uploadImg(Request $request)
    {
        $fileOld = session('media-file');
        if ($fileOld) {
            Storage::delete($fileOld);
        }
        $data = array();
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            $data['success'] = 0;
            $data['message'] = $validator->errors()->first('file');// Error response
            return response()->json($data);
        }

        if($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move('storage/tmp', $filename);

            $filepath = url('storage/tmp/' . $filename);
            session(['media-file' => 'tmp/' . $filename]);

            $data['success'] = 1;
            $data['filepath'] = $filepath;
            $data['fileold'] = $fileOld;

        }else{
            $data['success'] = 2;
            $data['message'] = 'Файл не загружен.';
        }
        return response()->json($data);
    }

}
