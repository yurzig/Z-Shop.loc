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
use Illuminate\Http\Request;
use App\Repositories\Blog\PostRepository;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        posts()->test();
        $sort = session('posts_sort', ['id', 'asc']);
        $filter = session('posts_filter', []);
        $items = $this->postRepository->getAll($sort, $filter, $this->perPage);
        $categories = $this->categoryRepository->getForSelect();
        $columns = session('posts_columns', ['id', 'category_id', 'user_id', 'title']);
        $users = $this->userRepository->getForSelect();

        return view('admin.blog.posts.index', compact('items',
            'categories',
            'columns',
            'filter',
            'sort',
            'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getTree();
        $users = $this->userRepository->getForSelect();

        return view('admin.blog.posts.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new Post())->create($data);

        return PostService::actionAfterSaving($item, $request->action);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
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
