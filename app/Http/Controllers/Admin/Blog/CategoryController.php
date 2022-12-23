<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CategoryCreateRequest;
use App\Http\Requests\Blog\CategoryUpdateRequest;
use App\Models\Blog\Category;
use App\Repositories\Blog\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getTree();

        return view('admin.blog.categories.index', compact('categories'));
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
        return to_route('admin.blog.categories.edit', $item)->with(['success' => 'Успешно сохранено']);
    }
    public function add($parent)
    {
        $categories = $this->categoryRepository->getTree();

        return view('admin.blog.categories.create', compact('categories','parent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->categoryRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $categories = $this->categoryRepository->getTree();

        return view('admin.blog.categories.edit', compact('item','categories'));
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
        $item = $this->categoryRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $result = $item->update($data);

        if (!$result) {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }
        return to_route('admin.blog.categories.edit', $item)->with(['success' => 'Успешно сохранено']);
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

        if ($result) {
            return redirect()
                ->route('admin.shop.categories.index')
                ->with(['success' => "Удалена запись id[$id] - $item->title"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
