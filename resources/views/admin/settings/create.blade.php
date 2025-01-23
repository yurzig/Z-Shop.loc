<?php
$help = [
    'slug' => 'Обязательное поле. Название настройки латиницей, должно быть уникальным.',
    'title' => 'Описание или правила заполнения настройки.',
    'setting_values' => 'Обязательное поле. Заполняются ключ-значение. Ключ(цифры, буквы) обязателен.',
];
$pageName = 'Новая настройка';
$page = 'admin.settings.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
    @include('admin.includes._header_block')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
    <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
          action="{{ route($page . 'store') }}" novalidate>
        @csrf
        @include('admin.includes._result_messages')

        <div class="col-lg-12 catalog-content">
            <div class="row">
                <div class="col-xl-12 item-navbar">
                    <div class="navbar-content">
                        <ul class="nav nav-tabs flex-row flex-wrap d-flex box" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" type="button"
                                        role="tab" data-bs-target="#basic" aria-controls="basic" aria-selected="true">
                                    Ввод данных
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-12 item-content tab-content">
                    <div id="basic" class="tab-pane fade show active" role="tabpanel" aria-labelledby="basic-tab">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-6">
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Наименование</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                       name="slug"
                                                       placeholder="Наименование настройки"
                                                       value="{{ old('slug') }}"
                                                       required="required">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Описание</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="title"
                                                   class="form-control"
                                                   value="{{ old('title') }}"
                                                   placeholder="Описание настройки">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['title'] }}</div>
                                    </div>
                                </div>
<template id="block-template">
    <div class="row block-element">
        <div class="col-md-4">
            <input type="text" name="setting_values[--id--][key]"
                   class="form-control"
                   required="required"
                   placeholder="Ключ">
        </div>
        <div class="col-md-7">
            <input type="text" name="setting_values[--id--][value]"
                   class="form-control"
                   required="required"
                   placeholder="Значение">
        </div>
        <div class="col-md-1">
            <div class="btn act-delete mt-1 fa option-delete" title="Удалить строку"></div>
        </div>
    </div>
</template>
                                <div class="col-xl-6">
                                    <div class="form-group row items-block">
                                        <label class="col-sm-12 fw-bold border-bottom mb-2">Настройка</label>
                                        <div class="col-sm-12 help-text">{{ $help['setting_values'] }}</div>
                                        <div class="row block-element">
                                            <div class="col-md-4">
                                                <input type="text" name="setting_values[1][key]"
                                                       class="form-control"
                                                       required="required"
                                                       placeholder="Ключ">
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="setting_values[1][value]"
                                                       class="form-control"
                                                       required="required"
                                                       placeholder="Значение">
                                            </div>
                                            <div class="col-md-1">
                                                <div class="btn act-delete mt-1 fa js-delete-block" title="Удалить строку"></div>
                                            </div>
                                        </div>
                                        <div class="btn btn-primary mt-2 ms-2 w-auto act-add fa js-add-block"
                                             data-tpl="#block-template"
                                             data-id="1"></div>
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
