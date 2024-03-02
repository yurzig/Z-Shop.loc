<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',         'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Статья',          'dbName' => 'post_id',    'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Пользователь',    'dbName' => 'user_id',    'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Рейтинг',         'dbName' => 'rating',     'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Комментарий',     'dbName' => 'comment',    'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Ответ',           'dbName' => 'response',   'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Статус',          'dbName' => 'status',     'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Дата создания',   'dbName' => 'created_at', 'type' => 'date',   'op' => '=',    'class' => ''],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at', 'type' => 'date',   'op' => '=',    'class' => ''],
    ['name' => 'Редактор',        'dbName' => 'editor',     'type' => 'text',   'op' => 'like', 'class' => ''],
];

$sort = postReviews()->getSort(['status', 'asc']);
$filter = postReviews()->getFilters();
$columns = postReviews()->getColumns(['post_id', 'user_id', 'rating', 'status', 'created_at']);

if (in_array('status',$columns)) {
    $status_items = [];
    $status_options = '<option value="">Все</option>';

    foreach (postReviews()->getStatuses() as $key => $statusItem) {
        $status_items[$key] = $statusItem;

        $selected = '';
        if (is_array($filter) && !empty($filter) && $filter['val']['status'] == $key) {
            $selected = " selected='selected'";
        }
        $status_options .= "<option value='{$key}'{$selected}>{$statusItem}</option>";
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
if (in_array('post_id',$columns)) {
    $post_id_items = [];
    $post_id_options = '<option value="">Все</option>';
    foreach (posts()->getForSelect() as $postItem) {
        $post_id_items[$postItem->id] = $postItem->title;

        $selected = '';
        if (is_array($filter) && !empty($filter) && $filter['val']['post_id'] == $postItem->id) {
            $selected = " selected='selected'";
        }
        $post_id_options .= "<option value='$postItem->id'$selected>$postItem->title</option>";
    }
}

$pageName = 'Отзывы';
$page = 'admin.post.reviews.';
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
