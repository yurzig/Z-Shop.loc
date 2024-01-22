<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\ReviewUpdateRequest;
use App\Http\Requests\Blog\ReviewCreateRequest;
use App\Models\Blog\Review;
use App\Repositories\Blog\PostRepository;
use App\Repositories\Blog\ReviewRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private $reviewRepository;
    private $postRepository;
    private $userRepository;
    private $perPage;

    public function __construct()
    {
        $this->reviewRepository = app(ReviewRepository::class);
        $this->postRepository = app(PostRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->perPage = 25;
    }

    /**
     * Список отзывов поста
     */
    public function index()
    {
        $items = postReviews()->getAll($this->perPage);

        return view('admin.blog.reviews.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $posts = $this->postRepository->getForSelect();
        $users = $this->userRepository->getForSelect();

        return view('admin.blog.reviews.create', compact('posts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReviewCreateRequest $request)
    {
        $data = $request->input();
        $data['editor'] = Auth::id();

        $item = (new Review())->create($data);

        if ($item) {
            return to_route('admin.blog.reviews.edit', $item)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->reviewRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $post = $this->postRepository->getEdit($item->post_id);
        $users = $this->userRepository->getForSelect();

        return view('admin.blog.reviews.edit', compact('item',
            'post',
            'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReviewUpdateRequest $request, $id)
    {
        $item = $this->reviewRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $data['editor'] = Auth::id();

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('admin.blog.reviews.edit', $item->id)
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
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->reviewRepository->getEdit($id);

        $result = Review::destroy($id);

        if ($result) {
            return redirect()
                ->route('admin.blog.reviews.index')
                ->with(['success' => "Удалена запись id[$id] - $item->title"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }

    /**
     * Сохранение в сессии списка видимых колонок.
     */
    public function columns(Request $request): RedirectResponse
    {
        postReviews()->setColumns($request->fields);

        return to_route('admin.blog.reviews.index');
    }

    /**
     * Сохранение в сессии примененных фильтров.
     */
    private function filter(Request $request): RedirectResponse
    {
        postReviews()->getFilters($request->filters);

        return to_route('admin.blog.reviews.index');
    }

    /**
     * Сброс и сохранение в сессии примененных фильтров.
     */
    public function filtersReset()
    {
        postReviews()->filtersReset();

        return to_route('admin.blog.reviews.index');
    }

    /**
     * Сохранение в сессии поля и направления сортировки.
     */
    public function sort(Request $request): RedirectResponse
    {
        postReviews()->setSort($request);

        return to_route('admin.blog.reviews.index');
    }

}
