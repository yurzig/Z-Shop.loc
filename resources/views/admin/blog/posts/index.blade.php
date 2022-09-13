<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',           'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Id категории',    'dbName' => 'category_id',  'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Id пользователя', 'dbName' => 'user_id',      'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Наименование',    'dbName' => 'title',        'type' => 'text',   'op' => 'like', 'class' => ' class="js-title"'],
    ['name' => 'Url',             'dbName' => 'slug',         'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Аннотация',       'dbName' => 'excerpt',      'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Текст статьи',    'dbName' => 'content',      'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Статус',          'dbName' => 'status',       'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Дата публикации', 'dbName' => 'published_at', 'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Дата создания',   'dbName' => 'created_at',   'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at',   'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
];

$category_id_items = [];
$category_id_options = '<option value="">Все</option>';
foreach($categories as $categoryItem) {
    $category_id_items[$categoryItem->id] = $categoryItem->title;
    if(is_array($filter) && !empty($filter) && $filter['val']['category_id'] == $categoryItem->id) {
        $category_id_options .= "<option value='$categoryItem->id' selected='selected'>$categoryItem->title</option>";
    } else {
        $category_id_options .= "<option value='$categoryItem->id'>$categoryItem->title</option>";
    }
}
$user_id_items = [];
$user_id_options = '<option value="">Все</option>';
foreach($users as $userItem) {
    $user_id_items[$userItem->id] = $userItem->name;
    if(is_array($filter) && !empty($filter) && $filter['val']['user_id'] == $userItem->id) {
        $user_id_options .= "<option value='$userItem->id' selected='selected'>$userItem->name</option>";
    } else {
        $user_id_options .= "<option value='$userItem->id'>$userItem->name</option>";
    }
}
$pageName = 'Статьи';
$page = 'admin.blog.posts.';
?>
@extends('layouts.admin')

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
