<?php

namespace App\Services\Shop;

//use App\Models\Shop\Product;
//use App\Models\Shop\PropertyList;
//use App\Repositories\ShopProductRepository;
//use App\Repositories\ShopPropertyListRepository;

class CategoryService {
    private static function menuRow(array $category, int $active_id) {
        $active = ($active_id === $category['id']) ? ' active' : '';
        $row = '<li>
                <div class="menu-tree-item d-flex justify-content-between' . $active . '">
                    <div>
                        <a class="btn fa act-add"
                            href="' . route('admin.shop.categories.add', $category['id']) . '"
                            title="Новая запись">
                        </a>
                        <a class="menu-tree-text"
                            href="' . route('admin.shop.categories.edit', $category['id']) . '"
                            title="Редактировать">' . $category['title'] . '</a>
                    </div>
                    <div>
                        <a class="btn fa act-delete js-delete"
                            href="' . route('admin.shop.categories.destroy', $category['id']) . '"
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

    public static function filterList(int $category_id)
    {
        $filtersData = [];
        $filters = app(ShopPropertyListRepository::class)->getFilters($category_id);
        if($filters) {
            $prices = app(ShopProductRepository::class)->getProductsByCategoryWithPrice($category_id);
            $max = 0; $min = 9999999;
            foreach ($prices as $price) {
                if(isset($price->price[0]['value'])) {
                    $value = (int)$price->price[0]['value'];
                    if ($min > $value) {
                        $min = $value;
                    }
                    if ($max < $value) {
                        $max = $value;
                    }
                }
            }
            $values = [ 'min' => $min, 'max' => $max];
            $filtersData[] = ['id' => 'price', 'title' => 'Цена', 'type' => 'text', 'values' => $values];
        }
        foreach ($filters as $filter) {
            $values = []; $tmp = [];
            if ($filter->type === PropertyList::LINEYNIY) {
                $max = 0; $min = 9999999;
                foreach ($filter->propertyValue as $propertyValue) {
                    $value = (int)$propertyValue['value'];
                    if ($min > $value) { $min = $value; }
                    if ($max < $value) { $max = $value; }
                }
                $values = [ 'min' => $min, 'max' => $max];
            } else if( $filter->type === PropertyList::SPISOK) {
                foreach ($filter->propertyValue as $value) {
                    if(in_array($value->value, $tmp)) { continue;}
                    $tmp[] = $value->value;
                    $values[] = ['option_id' => $value->value, 'title' => $value->propertyOption['title']];
                }
            }
            $filtersData[] = ['id' => $filter->id, 'title' => $filter->title, 'type' => $filter->type, 'values' => $values];
        }
        return $filtersData;
    }

    public static function filteredCards($items)
    {
        ob_start();
        foreach($items as $item) {
            ?>        <div class="card mb-3">
                <div class="card-body">
                    <?php   if(!empty($item->banner)) { ?>
                        <div class="banner-block">
                            <?php    foreach($item->banner as $banner) { ?>
                                <div class="banner-item">
                                    <?php echo \App\Models\Shop\Banner::TYPES[$banner->type] ?>
                                </div>
                            <?php    } ?>
                        </div>
                    <?php } ?>
                    <a href="<?= route('product', $item->slug) ?>">
                        <div style="width: 240px; height: 240px">
                            <?php        if(isset($item->media[0]->link)) { ?>
                                <img src="<?= imgMedium($item->media[0]->link) ?>" style="display: block; margin: 0 auto;" alt="">
                            <?php        } else {?>
                                <img src="/img/noimage.jpg" class="card-img-top" alt="" height="240px">
                            <?php        } ?>
                        </div>
                        <div class="card-title my-2 fs-6"><?= $item->title ?></div>
                    </a>
                    <div class="d-flex justify-content-between">
                        <div class="in-stock text-success">
                            <?php if($item->status == Product::V_NALICHII) { ?>
                            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                            <?php } else { ?>
                            <i class="fa fa-solid fa-circle-o"></i>
                            <?php }
                            echo Product::STATUS[$item->status]; ?>
                        </div>
                        <div class="rating-result">
            <?php   for($i = 1; $i <= 5; $i++) {
                        if($i <= $item->rating) { ?>
                            <span class="active"></span>
            <?php       } else { ?>
                            <span></span>
            <?php       }
                    }?>
                        </div>
                    </div>
                    <?php $dataPrice = priceCalculation($item->price); ?>

                    <div class="fs-4 fw-bold card-price">
                        <?= number_format($dataPrice['price'], 0, '', ' ') ?>₽

                        <span class="fs-5 fw-normal text-muted text-decoration-line-through"><?= $dataPrice['priceOld'] ?></span>
                        <?php    if($dataPrice['priceBanner']) { ?>
                            <div class="sticker sticker-price"><?= $dataPrice['priceBanner'] ?></div>
                        <?php    } ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button class="btn btn-basket js-compare" data-id="{{ $item->id }}" title="Добавить товар для сравнения">
                                <i class="fa fa-refresh fs-6" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="box-basket">
                            <input type="hidden" name="count" class="count-basket" value="1">
                            <button href="#" class="btn btn-basket js-basket" data-id="{{ $item->id }}">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                В корзину!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        $cards = ob_get_contents();
        ob_end_clean();
        return $cards;
    }

}
