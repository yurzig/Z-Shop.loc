<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    private $perPage;

    public function __construct()
    {
        $this->perPage = 25;
    }

    /**
     * Список постов
     */
    public function index(): View
    {
        $items = posts()->getAll($this->perPage);

        return view('admin.blog.posts.index', compact('items'));
    }

    /**
     * Создание поста(форма)
     */
    public function create(): View
    {
//dd(get_class($this));
        return view('admin.blog.posts.create');
    }

    /**
     * Создание поста(сохранение)
     */
    public function store(Request $request): RedirectResponse
    {

        return posts()->store($request);
    }

    /**
     * Редактирование поста(форма)
     */
    public function edit(Post $post): View
    {
//dd($post);
        return view('admin.blog.posts.edit', compact('post'));
    }

    /**
     * Редактирование поста(сохранение)
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
//        dd($request);

        return posts()->update($request, $post);
    }

    /**
     * Удаление поста.
     */
    public function destroy(Post $post): RedirectResponse
    {

        return posts()->delete($post);
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function columns(Request $request): RedirectResponse
    {
        posts()->setColumns($request->fields);

        return to_route('admin.posts.index');
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
        posts()->resetFilters();

        return to_route('admin.posts.index');
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function sort(Request $request): RedirectResponse
    {
        posts()->setSort($request);

        return to_route('admin.posts.index');
    }

    /**
     * Добавление тега по запросу ajax
     */
    public function addTag(Request $request): JsonResponse
    {
        $result = postTags()->addTag($request->newTag);

        return response()->json($result);
    }

    /**
        Добавить блок текста
     */
    public function addBlock(Request $request):View
    {

        return posts()->addBlock($request);
    }

    /**
        Добавить картинку в блок
     */
    public function addImg( Request $request )
    {
        $folderPath = public_path('upload\\');
        $image_parts = explode(";base64,", $request->image);
//        dd($image_parts);
//        $image_type_aux = explode("image/", $image_parts[0]);
//        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.png';
        $imageFullPath = $folderPath.$imageName;
        file_put_contents($imageFullPath, $image_base64);

//        $saveFile = new Picture;
//        $saveFile->name = $imageName;
//        $saveFile->save();

        return response()->json(['success'=>'upload\\'.$imageName]);
    }
}
