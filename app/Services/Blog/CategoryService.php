<?php

namespace App\Services\Blog;

class CategoryService {

    private static function menuRow(array $category, int $active_id) {
        $active = ($active_id === $category['id']) ? ' active' : '';
        $row = '<li>
                <div class="menu-tree-item d-flex justify-content-between' . $active . '">
                    <div>
                        <a class="btn fa act-add"
                            href="' . route('admin.blog.categories.add', $category['id']) . '"
                            title="Новая запись">
                        </a>
                        <a class="menu-tree-text"
                            href="' . route('admin.blog.categories.edit', $category['id']) . '"
                            title="Редактировать">' . $category['title'] . '</a>
                    </div>
                    <div>
                        <a class="btn fa act-delete js-delete"
                            href="' . route('admin.blog.categories.destroy', $category['id']) . '"
                            title="Удалить запись"></a>
                    </div>
                </div>';

        if (isset($category['children'])) {
            $row .= '<ul>' . self::menuItems($category['children'], $active_id) . '</ul>';
        }
        $row .= '</li>';
        return $row;
    }
    private static function selectRow(array $category, int $active_id, string $str) {
        $selected = ($active_id === $category['id']) ? ' selected="selected"' : '';
        if($category['parent'] == 0) {
            $row = '<option value="' . $category['id'] . '"' . $selected . '>' . $category['title'] . '</option>';
        } else {
            $row = '<option value="' . $category['id'] . '"' . $selected . '>' . $str . $category['title'] . '</option>';
        }

        if (isset($category['children'])) {
            $i = 1;
            for ($j = 0; $j < $i; $j++) {
                $str .= '&nbsp&nbsp';
            }
            $i++;
            $row .= self::SelectItems($category['children'], $active_id, $str);
        }
        return $row;
    }

    private static function menuItems(array $items, int $active_id) {
        $string = '';
        foreach ($items as $item) {
            $string .= self::menuRow($item, $active_id);
        }
        return $string;
    }

    private static function selectItems(array $items, int $active_id, string $str) {
        $string = '';
        $str = $str;
        foreach ($items as $item) {
            $string .= self::selectRow($item, $active_id, $str);
        }
        return $string;
    }
    public static function menuTree(array $categories, int $active_id)
    {
        $result = self::menuItems($categories, $active_id);
        return $result;
    }
    public static function selectTree(array $categories, int $active_id)
    {
        $result = self::selectItems($categories, $active_id, '');
        return $result;
    }
}



