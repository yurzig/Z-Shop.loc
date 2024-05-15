<?php

namespace App\ServicesYz;

use App\Models\Blog\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PostCategoriesService
{
    /**
        Получить список категорий в виде дерева методом Tommy Lacroix
     */
    public function getTree():array
    {
        $categories = PostCategory::select('id', 'title', 'parent_id')
            ->orderBy('sort')
            ->toBase()
            ->get();

        $dataSet = [];
        foreach ($categories as $row) {
            $dataSet[$row->id] = ['id' => $row->id, 'title' => $row->title, 'parent' => $row->parent_id];
        }

        $tree = [];
        foreach ($dataSet as $id => &$node) {
            if (!$node['parent']) {
                $tree[$id] = &$node;
            } else {
                $dataSet[$node['parent']]['children'][$id] = &$node;
            }
        }

        return $tree;
    }

    /**
        Сохранение категории поста
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->input();
        $data['editor'] = Auth::id();
        $this->saveValidate($data);

        $category = (new PostCategory())->create($data);

        if (!$category) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.blog.categories.edit', $category)->with(['success' => 'Успешно сохранено']);
    }

    /**
        Обновить категорию поста
     */
    public function update(Request $request, PostCategory $category):RedirectResponse
    {
        if (empty($category)) {

            return back()
                ->withErrors(['msg' => "Запись id=[{$category->id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $data['editor'] = Auth::id();

        $this->saveValidate($data);

        $result = $category->update($data);

        if (!$result) {

            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        }

        return to_route('admin.postblog.categories.edit', $category)->with(['success' => 'Успешно сохранено']);
    }

    /**
        Удалить категорию поста
     */
    public function delete (PostCategory $category): RedirectResponse
    {

        $result = $category->delete();

        if ($result) {

            return redirect()
                ->route('admin.post.categories.index')
                ->with(['success' => "Удалена запись id[$category->id] - $category->title"]);
        }

        return back()->withErrors(['msg' => 'Ошибка удаления']);
    }
/**
        Проверка перед удалением категории поста
     */
//    public function beforeDelete( Post $post_category ): void
//    {
//        if (count(posts()->getByCategoryId( $post_category )) > 0)
//
//            abort(403, ' Удаление невозможно. У этой категории есть посты');
//
//
//    }


    /**
        Валидация
     */
    public function saveValidate( array $data ): void
    {
        Validator::make( $data, [
            'title' => 'required|max:200',
            'slug' => 'max:200',
            'parent_id' => 'required|integer',
        ])->validate();
    }

    /**
     * Получить список категорий для вывода в выпадающем списке
     */
    public function getForSelect()
    {

        return PostCategory::select('id', 'title')->toBase()->get();
    }

    /**
     * Если поле слаг пустое, то заполняем его конвертацией заголовка
     */
    public function setSlug(PostCategory $category): String
    {
        if (!empty($category->slug)) {

            return $category->slug;
        }

        $slug = Str::slug($category->title);
        $slug_new = $slug;

        $i = 0;
        while (PostCategory::where('slug', $slug_new)->withTrashed()->get()->count() > 0) {
            $slug_new = $slug . '_' . ++$i;
        }

        return $slug_new;
    }

    /**
     * Получить дерево категорий для select
     */
    public function selectTree(int $active_id): string
    {

        return self::selectItems(postCategories()->getTree(), $active_id);
    }

    private static function selectItems(array $items, int $active_id, string $str='') {
        $string = '';
        foreach ($items as $item) {
            $string .= self::selectRow($item, $active_id, $str);
        }

        return $string;
    }

    private static function selectRow(array $category, int $active_id, string $str) {
        $selected = ($active_id === $category['id']) ? ' selected="selected"' : '';
//        if($category['parent'] == 0) {
//            $row = '<option value="' . $category['id'] . '"' . $selected . '>' . $category['title'] . '</option>';
//        } else {
            $row = '<option value="' . $category['id'] . '"' . $selected . '>' . $str . $category['title'] . '</option>';
//        }

        if (isset($category['children'])) {
            $str .= '&nbsp&nbsp';
            $row .= self::SelectItems($category['children'], $active_id, $str);
        }

        return $row;
    }
    /**
     * Получить дерево категорий для меню
     */
    public function menuTree(int $active_id): string
    {
        $level = 1;
        $string = '<ul class="menu-tree node" data-level="' . $level . '" data-id="0" data-url="' . route("admin.post.categories.sortable") . '">';

        $string .= self::menuItems(postCategories()->getTree(), $active_id, $level);

        $string .= '</ul>';

        return $string;
    }


    private static function menuItems(array $categories, int $active_id, int $level): string
    {
        $string = '';
        foreach ($categories as $category) {
            $string .= self::menuRow($category, $active_id, $level);
        }

        return $string;
    }

    private static function menuRow(array $category, int $active_id, int $level): string
    {
        $active = ($active_id === $category['id']) ? ' active' : '';
        $row = '<li class="menu-tree-item' . $active . '" data-id="' . $category['id'] . '" data-level="' . $level . '">
                <div class="menu-tree-line d-flex justify-content-between">
                    <div>
                        <a class="btn fa act-add"
                            href="' . route('admin.post.categories.add', $category['id']) . '"
                            title="Новая запись">
                        </a>
                        <a class="menu-tree-text"
                            href="' . route('admin.post.categories.edit', $category['id']) . '"
                            title="Редактировать">' . $category['title'] . '</a>
                    </div>
                    <div>
                        <a class="btn fa act-delete js-delete"
                            href="' . route('admin.post.categories.destroy', $category['id']) . '"
                            title="Удалить запись"></a>
                    </div>
                </div>';

        if (isset($category['children'])) {
            $level = ++$level;
            $row .= '<ul class="node" data-level="' . $level . '" data-id="' . $category['id'] . '">' . self::menuItems($category['children'], $active_id, $level) . '</ul>';
        }
        $row .= '</li>';

        return $row;
    }

    /**
        Сохранить сортировку блока категорий
     */
    public function setSortable(mixed $data): void
    {
        $parent_id = $data->node;
        $ids = explode(',', rtrim($data->ids, ','));

        foreach ($ids as $key => $id) {
            PostCategory::find($id)->update(['parent_id' => $parent_id, 'sort' => $key]);
        }
    }

}
