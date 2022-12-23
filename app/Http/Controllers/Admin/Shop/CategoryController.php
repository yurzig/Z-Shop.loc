<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\TextController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\CategoryCreateRequest;
use App\Http\Requests\Shop\CategoryUpdateRequest;
use App\Models\Shop\Category;
use App\Repositories\SettingRepository;
use App\Repositories\Shop\CategoryRepository;
use App\Repositories\TextRepository;
use Illuminate\Support\Facades\Storage;

//use App\Repositories\MediaRepository;
//use App\Repositories\ShopPropertyListRepository;
//use App\Repositories\ShopPropertyOptionRepository;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $settingRepository;
//    private $propertyListRepository;
//    private $propertyOptionRepository;
//    private $mediaRepository;
    private $textRepository;

    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
        $this->settingRepository = app(SettingRepository::class);
//        $this->shopPropertyListRepository = app(ShopPropertyListRepository::class);
//        $this->shopPropertyOptionRepository = app(ShopPropertyOptionRepository::class);
//        $this->mediaRepository = app(MediaRepository::class);
        $this->textRepository = app(TextRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getTree();

        return view('admin.shop.categories.index', compact('categories'));
    }

    public function add($parent)
    {
        $categories = $this->categoryRepository->getTree();

        return view('admin.shop.categories.create', compact('categories','parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryCreateRequest $request)
    {
        $data = $request->input();
        $item = (new Category())->create($data);

        if (!$item) {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }
        return to_route('admin.shop.categories.edit', $item)->with(['success' => 'Успешно сохранено']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->categoryRepository->getRow($id);
        if (empty($item)) {
            abort(404);
        }
//        dd(__METHOD__, $item, $item->medias,$item->medias[0]->pivot->placement);
        $types = $this->settingRepository->getSetting('text-types');
        $placements = $this->settingRepository->getSetting('media-placements');
        $texts = $this->textRepository->getForSelect();
        $categories = $this->categoryRepository->getTree();
//        $properties = $this->shopPropertyListRepository->getByCategory($id);
//        $options = $this->shopPropertyOptionRepository->getByCategory($id);
//        $medias = $this->mediaRepository->getByObject($id, 'category');
//dd(__METHOD__, storage_path(), public_path(), Storage::files(storage_path()), Storage::files(public_path()));
        return view('admin.shop.categories.edit', compact('item',
            'types',
            'placements',
            'texts',
            'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
//        dd($request, $request->medi);
//        if ($request->prop) {
//            app(PropertyListController::class)->updatingList($request->prop, $id);
//        }

        $item = $this->categoryRepository->getRow($id);
        if (empty($item)) {
            return back()->withErrors(['msg' => "Запись id=[{$id}] не найдена"])->withInput();
        }

        if ($request->input('text')) {
            app(TextController::class)->textsUpdating($item, $request->input('text'));
        }
        if ($request->input('media')) {
            app(MediaController::class)->mediasUpdating($item, $request, 'category');
        }


        $data = $request->all();
        $result = $item->update($data);

        if (!$result) {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.shop.categories.edit', $item)->with(['success' => 'Успешно сохранено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->categoryRepository->getEdit($id);

        $result = Category::destroy($id);

        if (!$result) {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }

        return to_route('admin.shop.categories.index')
            ->with(['success' => "Удалена запись id[$id] - $item->title"]);
    }

}
