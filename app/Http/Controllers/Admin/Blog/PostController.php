<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\PostCreateRequest;
use App\Http\Requests\Blog\PostUpdateRequest;
use App\Models\Blog\Post;
use App\Repositories\Blog\CategoryRepository;
use App\Repositories\Blog\ReviewRepository;
use App\Repositories\UserRepository;
use App\Services\Blog\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Repositories\Blog\PostRepository;
use Illuminate\View\View;

class PostController extends Controller
{
    private $postRepository;
    private $categoryRepository;
    private $userRepository;
    private $reviewRepository;
    private $perPage;

    public function __construct()
    {
        $this->postRepository = app(PostRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->reviewRepository = app(ReviewRepository::class);
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
    public function edit($id): View
    {
        $item = $this->postRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $categories = $this->categoryRepository->getTree();
        $users = $this->userRepository->getForSelect();
        $reviews = $this->reviewRepository->getByPost($id);

        return view('admin.blog.posts.edit', compact('item',
            'categories',
            'users',
            'reviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $item = $this->postRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $result = $item->update($data);

        return PostService::actionAfterSaving($result, $request->action);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->postRepository->getEdit($id);

        $result = Post::destroy($id);

        if ($result) {
            return redirect()
                ->route('admin.blog.posts.index')
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
        session(['posts_columns' => $request->field]);
        return $this->index();
    }

    public function search(Request $request)
    {
        session(['posts_filter' => $request->filter]);
        return to_route('admin.blog.posts.index');
    }

    public function sort(Request $request)
    {
        $direction = 'asc';
        if ($request->session()->has('posts_sort')) {
            $sort = session('posts_sort');
            if ($sort[0] === $request->order) {
                $direction = $sort[1] === 'asc' ? 'desc' : 'asc';
            }
        }

        session(['posts_sort' => [$request->order, $direction]]);
        return to_route('admin.blog.posts.index');
    }

    public function reset()
    {
        session(['posts_filter' => []]);
        return to_route('admin.blog.posts.index');
    }
}
