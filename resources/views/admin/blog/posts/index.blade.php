<?php
$fields = [
    ['name' => 'Id',               'dbName' => 'id',               'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Категория',        'dbName' => 'category_id',      'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Автор',            'dbName' => 'user_id',          'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Наименование',     'dbName' => 'title',            'type' => 'text',   'op' => 'like', 'class' => ' class=js-title'],
    ['name' => 'Url',              'dbName' => 'slug',             'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Аннотация',        'dbName' => 'excerpt',          'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Текст статьи',     'dbName' => 'content',          'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Опубликована',     'dbName' => 'is_published',     'type' => 'switch', 'op' => '=',    'class' => ''],
    ['name' => 'meta title',       'dbName' => 'meta_title',       'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'meta description', 'dbName' => 'meta_description', 'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Дата публикации',  'dbName' => 'published_at',     'type' => 'date',   'op' => '=',    'class' => ' class=flatpickr-input'],
    ['name' => 'Дата создания',    'dbName' => 'created_at',       'type' => 'date',   'op' => '=',    'class' => ' class=flatpickr-input'],
    ['name' => 'Дата обновления',  'dbName' => 'updated_at',       'type' => 'date',   'op' => '=',    'class' => ' class=flatpickr-input'],
];

$sort = posts()->getSort(['id', 'asc']);
$filter = posts()->getFilters();
$columns = posts()->getColumns(['id', 'category_id', 'user_id', 'title', 'is_published', 'published_at']);

if (in_array('category_id',$columns)) {
    $category_id_items = [];
    $category_id_options = '<option value="">Все</option>';
    foreach (postCategories()->getForSelect() as $categoryItem) {
        $category_id_items[$categoryItem->id] = $categoryItem->title;

        $selected = '';
        if (is_array($filter) && !empty($filter) && $filter['val']['category_id'] == $categoryItem->id) {
            $selected = " selected='selected'";
        }
        $category_id_options .= "<option value='$categoryItem->id'$selected>$categoryItem->title</option>";
    }
}

if (in_array('user_id',$columns)) {
    $user_id_items = [];
    $user_id_options = '<option value="">Все</option>';
    foreach (users()->getForSelect() as $userItem) {
        $user_id_items[$userItem->id] = $userItem->name;

        $selected = '';
        if (is_array($filter) && !empty($filter) && $filter['val']['user_id'] == $userItem->id) {
            $selected = " selected='selected'";
        }
        $user_id_options .= "<option value='$userItem->id'$selected>$userItem->name</option>";
    }
}

if (in_array('is_published',$columns)) {
    $is_published_options = '<option value="">Все</option>';

    $selected = ((is_array($filter) && !empty($filter) && $filter['val']['is_published'] === '1')) ? " selected='selected'" : '';
    $is_published_options .= "<option value='1'$selected>Да</option>";

    $selected = ((is_array($filter) && !empty($filter) && $filter['val']['is_published'] === '0')) ? " selected='selected'" : '';
    $is_published_options .= "<option value='0'$selected>Нет</option>";

}

$pageName = 'Статьи';
$page = 'admin.posts.';
?>
@extends('layouts.admin')

@push('styles')
{{--    @vite('resources/css/test.css')--}}
@endpush

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
@endsection

@section('content')
    @include('admin.includes._result_messages')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
        @include('admin.includes._list', ['page' => $page])
    </div>
    @if($items->total() > $items->count())
        <div class="list-page d-flex justify-content-center">
            {{ $items->onEachSide(2)->links() }}
        </div>
    @endif

    <!-- Modal -->
    @include('admin.includes._modal_columns', ['action' => route($page . 'columns')])
    @include('admin.includes._modal_delete')
@endsection

@push('scripts')
@endpush
