<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',         'type' => 'text', 'op' => '=',    'class' => ''],
    ['name' => 'Тег',             'dbName' => 'tag',        'type' => 'text', 'op' => '=',    'class' => ''],
    ['name' => 'Дата создания',   'dbName' => 'created_at', 'type' => 'date', 'op' => '=',    'class' => ''],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at', 'type' => 'date', 'op' => '=',    'class' => ''],
];

$sort = postTags()->getSort(['id', 'asc']);
$filter = postTags()->getFilters();
$columns = postTags()->getColumns(['id', 'tag', 'created_at']);

$pageName = 'Теги';
$page = 'admin.post.tags.';
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
