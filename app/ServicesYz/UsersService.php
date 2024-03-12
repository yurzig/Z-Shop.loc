<?php

namespace App\ServicesYz;

use App\Models\Blog\PostCategory;
use App\Models\Blog\Post;
use App\Models\User;
use App\Models\User as Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UsersService
{
    /**
     * Получить список пользователей
     */
    public function getAll(array $sort, array $filter, ?int $perPage = null): object
    {
        $where = [];
        if($filter) {
            foreach ($filter['val'] as $key => $item) {
                if (!is_null($item)) {
                    $where[] = [$key, $filter['op'][$key], $filter['op'][$key] === 'like' ? "%$item%" : $item];
                }
            }
        }
        $result = User::where($where)
            ->orderBy($sort[0], $sort[1])
            ->paginate($perPage);

        return $result;
    }

    /**
     * Получить список пользователей для вывода в выпадающем списке
     */
    public function getForSelect()
    {

        return User::select('id', 'name')->toBase()->get();
    }
    /**
    * Получить пользователя по id
     */
    public function getUser(int $id): User
    {

        return User::findOrFail($id);
    }

//    /**
//        Сохранение категории поста
//     */
//    public function store(Request $request): RedirectResponse
//    {
//        $data = $request->input();
//        $this->saveValidate($data);
//
//        $category = (new PostCategory())->create($data);
//
//        if (!$category) {
//
//            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
//        }
//
//        return to_route('admin.blog.categories.edit', $category)->with(['success' => 'Успешно сохранено']);
//    }
//
//    /**
//        Обновить категорию поста
//     */
//    public function update(Request $request, PostCategory $category):RedirectResponse
//    {
//        if (empty($category)) {
//
//            return back()
//                ->withErrors(['msg' => "Запись id=[{$category->id}] не найдена"])
//                ->withInput();
//        }
//
//        $data = $request->all();
//
//        $this->saveValidate($data);
//
//        $result = $category->update($data);
//
//        if (!$result) {
//
//            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
//        }
//
//        return to_route('admin.blog.categories.edit', $category)->with(['success' => 'Успешно сохранено']);
//    }
//
//    /**
//        Удалить категорию поста
//     */
//    public function delete (PostCategory $category): RedirectResponse
//    {
//
//        $result = $category->delete();
//
//        if ($result) {
//
//            return redirect()
//                ->route('admin.blog.categories.index')
//                ->with(['success' => "Удалена запись id[$category->id] - $category->title"]);
//        }
//
//        return back()->withErrors(['msg' => 'Ошибка удаления']);
//    }
///**
//        Проверка перед удалением категории поста
//     */
////    public function beforeDelete( Post $post_category ): void
////    {
////        if (count(posts()->getByCategoryId( $post_category )) > 0)
////
////            abort(403, ' Удаление невозможно. У этой категории есть посты');
////
////
////    }
//
//
//    /**
//        Валидация
//     */
//    public function saveValidate( array $data ): void
//    {
//        Validator::make( $data, [
//            'title' => 'required|max:200',
//            'slug' => 'max:200',
//            'parent_id' => 'required|integer',
//        ])->validate();
//    }
//
//    /**
//     * Если поле слаг пустое, то заполняем его конвертацией заголовка
//     */
//    public function setSlug(PostCategory $category): String
//    {
//        if (!empty($category->slug)) {
//
//            return $category->slug;
//        }
//
//        $slug = Str::slug($category->title);
//        $slug_new = $slug;
//
//        $i = 0;
//        while (PostCategory::where('slug', $slug_new)->get()->count() > 0) {
//            $slug_new = $slug . '_' . ++$i;
//        }
//
//        return $slug_new;
//    }
}
