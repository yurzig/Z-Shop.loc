<?php
$help = [
    'slug' => 'Обязательное поле. Название настройки латиницей, должно быть уникальным.',
    'description' => 'Описание или правила заполнения настройки.',
    'setting' => 'Обязательное поле. Заполняются ключ-значение. Ключ(цифры, буквы) обязателен.',
];
$pageName = 'Редактирование настройки';
$page = 'admin.settings.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
<span>{{ $pageName }}: ({{ $item->id }}) {{ $item->slug }}</span>
@include('admin.includes._header_block')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
    <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data" action="{{ route($page . 'update', $item) }}">
        @csrf
        @method('PATCH')

        @include('admin.includes._result_messages')

        <div class="col-lg-12 catalog-content">
            <div class="row">

                <div class="col-xl-12 item-navbar">
                    <div class="navbar-content">
                        <ul class="nav nav-tabs flex-row flex-wrap d-flex box" role="tablist">
                            <li class="nav-item basic">
                                <a class="nav-link active" href="#basic" data-bs-toggle="tab" role="tab"
                                   aria-expanded="true" aria-controls="basic" tabindex="1">
                                    Основные данные
                                </a>
                            </li>
                            <li class="nav-item other">
                                <a class="nav-link" href="#other" data-bs-toggle="tab" role="tab"
                                   aria-expanded="true" aria-controls="basic" tabindex="1">
                                    Прочие данные
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-12 item-content tab-content">
                    <div id="basic" class="item-basic tab-pane fade show active" role="tabpanel" aria-labelledby="basic">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-6">

                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Наименование</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                   name="slug"
                                                   placeholder="Наименование настройки"
                                                   value="{{ old('slug', $item->slug) }}"
                                                   required="required">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Описание</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                   name="description"
                                                   placeholder="Описание"
                                                   value="{{ old('description', $item->description) }}">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['description'] }}</div>
                                    </div>

                                </div>
<template id="block-template">
    <div class="row block-element">
        <div class="col-md-4">
            <input type="text" name="setting[--id--][key]" class="form-control" placeholder="Ключ">
        </div>
        <div class="col-md-7">
            <input type="text" name="setting[--id--][value]" class="form-control" placeholder="Значение">
        </div>
        <div class="col-md-1">
            <div class="btn act-delete mt-1 fa option-delete" title="Удалить строку"></div>
        </div>
    </div>
</template>

                                <div class="col-xl-6">
                                    <div class="form-group row mandatory items-block">
                                        <label class="col-sm-12 fw-bold border-bottom mb-2">Настройка</label>
                                        <div class="col-sm-12 help-text">{{ $help['setting'] }}</div>
                                        @empty($item->setting)
                                            @php $item->setting = [0 => ['key' => '', 'value' => '']] @endphp
                                        @endempty
                                        @foreach($item->setting as $key => $arrayItem)
                                            <div class="row block-element">
                                                <div class="col-md-4">
                                                    <input type="text" name="setting[{{ $key }}][key]" class="form-control" value="{{ old('setting['.$key.'][key]', $arrayItem['key']) }}" placeholder="Ключ">
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="setting[{{ $key }}][value]" class="form-control" value="{{ old('setting['.$key.'][value]', $arrayItem['value']) }}" placeholder="Значение">
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="btn act-delete mt-1 fa js-delete-block" title="Удалить строку"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="btn btn-primary mt-2 ms-2 w-auto act-add fa js-add-block"
                                             data-tpl="#block-template"
                                             data-id="{{ $key }}"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="other" class="item-basic tab-pane fade show" role="tabpanel" aria-labelledby="basic">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Дата создания</label>
                                        <div class="col-sm-8">
                                            {{ $item->created_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Дата обновления</label>
                                        <div class="col-sm-8">
                                            {{ $item->updated_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Редактор</label>
                                        <div class="col-sm-8">
                                            {{ $item->editor}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection
