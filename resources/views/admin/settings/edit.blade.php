<?php
$help = [
    'slug' => 'Обязательное поле. Название настройки латиницей, должно быть уникальным.',
    'title' => 'Описание или правила заполнения настройки.',
    'setting_values' => 'Обязательное поле. Заполняются ключ-значение. Ключ(цифры, буквы) обязателен.',
];
$pageName = 'Редактирование настройки';
$page = 'admin.settings.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
<span>{{ $pageName }}: ({{ $setting->id }}) {{ $setting->slug }}</span>
@include('admin.includes._header_block')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
    <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
          action="{{ route($page . 'update', $setting) }}" novalidate>
        @csrf
        @method('PATCH')

        @include('admin.includes._result_messages')

        <div class="col-lg-12 catalog-content">
            <div class="row">

                <div class="col-xl-12 item-navbar">
                    <div class="navbar-content">
                        <ul class="nav nav-tabs flex-row flex-wrap d-flex box" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" type="button"
                                        role="tab" data-bs-target="#basic" aria-controls="basic" aria-selected="true">
                                    Основные данные
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="other-tab" data-bs-toggle="tab" type="button" role="tab"
                                        data-bs-target="#other" aria-controls="other" aria-selected="false">
                                    Прочие данные
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
                                            <input type="text" name="slug"
                                                   class="form-control"
                                                   value="{{ old('slug', $setting->slug) }}"
                                                   required="required"
                                                   placeholder="Наименование настройки">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Описание</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="title"
                                                   class="form-control"
                                                   value="{{ old('title', $setting->title) }}"
                                                   placeholder="Описание">
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
                                    <div class="form-group row mandatory items-block">
                                        <label class="col-sm-12 fw-bold border-bottom mb-2">Настройка</label>
                                        <div class="col-sm-12 help-text">{{ $help['setting_values'] }}</div>
                                        @php
                                            if (is_null($setting->setting_values) || !is_array($setting->setting_values))
                                                $setting->setting_values = [0 => ['key' => '', 'value' => '']]
                                        @endphp
                                        @foreach($setting->setting_values as $key => $arrayItem)
                                            <div class="row block-element">
                                                <div class="col-md-4">
                                                    <input type="text" name="setting_values[{{ $key }}][key]"
                                                           class="form-control"
                                                           value="{{ old('setting_values['.$key.'][key]', $arrayItem['key']) }}"
                                                           required="required" placeholder="Ключ">
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="setting_values[{{ $key }}][value]"
                                                           class="form-control"
                                                           value="{{ old('setting_values['.$key.'][value]', $arrayItem['value']) }}"
                                                           required="required" placeholder="Значение">
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
                    <div id="other" class="tab-pane fade" role="tabpanel" aria-labelledby="other-tab">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Дата создания</label>
                                        <div class="col-sm-8">
                                            {{ $setting->created_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Дата обновления</label>
                                        <div class="col-sm-8">
                                            {{ $setting->updated_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Редактор</label>
                                        <div class="col-sm-8">
                                            {{ $setting->editor}}
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
