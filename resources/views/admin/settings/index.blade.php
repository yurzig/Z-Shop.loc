<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',             'type' => 'text', 'op' => '=',    'class' => ''],
    ['name' => 'Наименование',    'dbName' => 'slug',           'type' => 'text', 'op' => 'like', 'class' => ' class=js-title'],
    ['name' => 'Описание',        'dbName' => 'title',          'type' => 'text', 'op' => 'like', 'class' => ''],
    ['name' => 'Настройка',       'dbName' => 'setting_values', 'type' => 'text', 'op' => 'like', 'class' => ''],
    ['name' => 'Дата создания',   'dbName' => 'created_at',     'type' => 'date', 'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at',     'type' => 'date', 'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Редактор',        'dbName' => 'editor',         'type' => 'text', 'op' => 'like', 'class' => ''],
];

$sort = settings()->getSort(['id', 'asc']);
$filter = settings()->getFilters();
$columns = settings()->getColumns(['id', 'slug', 'title']);

$pageName = 'Настройки';
$page = 'admin.settings.';
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