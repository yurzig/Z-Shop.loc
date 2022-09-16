<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',         'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Тип',             'dbName' => 'type',       'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Наименование',    'dbName' => 'title',      'type' => 'text',   'op' => 'like', 'class' => ' class=js-title'],
    ['name' => 'Текст',           'dbName' => 'content',    'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Дата создания',   'dbName' => 'created_at', 'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at', 'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Редактор',        'dbName' => 'editor',     'type' => 'text',   'op' => '=',    'class' => ''],
];
$type_items = \App\Models\Text::TYPES;
$type_options = '<option value="">Все</option>';
foreach(\App\Models\Text::TYPES as $key => $textItem) {
    if(is_array($filter) && !empty($filter) && $filter['val']['type'] == $key) {
        $type_options .= "<option value='$key' selected='selected'>$textItem</option>";
    } else {
        $type_options .= "<option value='$key'>$textItem</option>";
    }
}
$pageName = 'Тексты';
$page = 'admin.texts.';
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
