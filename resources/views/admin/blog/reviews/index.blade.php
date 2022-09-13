<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',         'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Статья',          'dbName' => 'post_id',    'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Пользователь',    'dbName' => 'user_id',    'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Рейтинг',         'dbName' => 'rating',     'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Комментарий',     'dbName' => 'comment',    'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Ответ',           'dbName' => 'response',   'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Статус',          'dbName' => 'status',     'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Дата создания',   'dbName' => 'created_at', 'type' => 'date',   'op' => '=',    'class' => ''],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at', 'type' => 'date',   'op' => '=',    'class' => ''],
    ['name' => 'Редактор',        'dbName' => 'editor',     'type' => 'text',   'op' => 'like', 'class' => ''],
];
$status_items = [];
$status_options = '<option value="">Все</option>';
foreach (\App\Models\Blog\Review::STATUSES as $key => $statusItem) {
    $status_items[$key] = $statusItem;
    if (is_array($filter) && !empty($filter) && $filter['val']['status'] == $key) {
        $status_options .= "<option value='{$key}' selected='selected'>{$statusItem}</option>";
    } else {
        $status_options .= "<option value='{$key}'>{$statusItem}</option>";
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
$pageName = 'Отзывы';
$page = 'admin.blog.reviews.';

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
