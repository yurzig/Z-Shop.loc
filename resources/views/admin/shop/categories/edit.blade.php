<?php
$help = [
    'title' => '',
    'slug' => '',
    'parent_id' => '',
    'meta_title' => '',
    'meta_description' => '',
    'tmpl_title' => '',
    'tmpl_description' => '',
];
$pageName = 'Редактирование категории';
$page = 'admin.shop.categories.';
?>

@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}: ({{ $item->id }}) {{ $item->title }}</span>
    <div class="item-actions my-1">
        <a class="btn btn-secondary js-help" role="button" data-bs-toggle="button" aria-pressed="false"
           title="Подсказки" href="#">?</a>
        <a class="btn btn-secondary act-cancel" title="Переход на список" href="{{ route($page . 'index') }}">Список</a>

        <div class="btn-group">
            <button type="submit" form="edit-form" class="btn btn-primary act-save" title="Сохранить запись">Сохранить
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
        <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
              action="{{ route($page . 'update', $item) }}">
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
                                       aria-expanded="true" aria-controls="basic">
                                        Основные данные
                                    </a>
                                </li>
                                <li class="nav-item description">
                                    <a class="nav-link" href="#description" data-bs-toggle="tab" role="tab"
                                       aria-expanded="true" aria-controls="description">
                                        Описание
                                    </a>
                                </li>
                                <li class="nav-item properties">
                                    <a class="nav-link" href="#properties" data-bs-toggle="tab" role="tab"
                                       aria-expanded="true" aria-controls="properties">
                                        Свойства товаров категории
                                    </a>
                                </li>
                                <li class="nav-item media">
                                    <a class="nav-link" href="#media" data-bs-toggle="tab" role="tab"
                                       aria-expanded="true" aria-controls="media">
                                        Изображения
                                    </a>
                                </li>
                                <li class="nav-item other">
                                    <a class="nav-link" href="#other" data-bs-toggle="tab" role="tab"
                                       aria-expanded="true" aria-controls="other">
                                        SEO и прочие данные
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-12 item-content tab-content">

                        <div id="basic" class="item-basic tab-pane fade active show" role="tabpanel" aria-labelledby="basic">
                            <div class="box">
                                <div class="row justify-content-center">
                                    <div class="col-xl-6 block">
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Название</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="title"
                                                       placeholder="Название категории"
                                                       value="{{ old('title', $item->title) }}"
                                                       required="required">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['title'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Url</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="slug"
                                                       placeholder="Уникальный идентификатор"
                                                       value="{{ old('slug', $item->slug) }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Родитель</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" name="parent_id">
                                                    <option value="0">1-й уровень</option>
                                                    {!! \App\Services\Shop\CategoryService::selectTree($categories, $item->parent_id) !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['parent_id'] }}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="description" class="item-basic tab-pane fade" role="tabpanel" aria-labelledby="description">
                            @include('admin.includes._texts')
{{--                            <div class="box">--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-xl-12 block">--}}
{{--                                        <div class="form-group row">--}}
{{--                                            Text--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <div id="properties" class="item-basic js-block-start tab-pane fade" role="tabpanel"
                             aria-labelledby="properties">
                            Свойства
{{--                            @include('admin.shop.categories._properties')--}}
                        </div>
                        <div id="media" class="item-media js-block-start tab-pane fade" role="tabpanel"
                             aria-labelledby="media">
                            Медиа
{{--                            @include('admin.shop.includes._medias')--}}
                        </div>
                        <div id="other" class="item-basic tab-pane fade show" role="tabpanel" aria-labelledby="other">
                            <div class="box">
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">meta-title</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="meta_title"
                                               placeholder="title"
                                               value="{{ old('meta_title', $item->meta_title) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">meta-description</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="meta_description"
                                               placeholder="description"
                                               value="{{ old('meta_description', $item->meta_description) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">title продукта</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="tmpl_title"
                                               placeholder="Шаблон title продукта"
                                               value="{{ old('tmpl_title', $item->tmpl_title) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">description продукта</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="tmpl_description"
                                               placeholder="Шаблон description продукта"
                                               value="{{ old('tmpl_description', $item->tmpl_description) }}">
                                    </div>
                                </div>

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

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal" id="listTextsModal" tabindex="-1" aria-labelledby="listTextsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="listTextsModalLabel">Тексты</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="list-items table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Тип</th>
                            <th scope="col">Название</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($texts as $itemText)
                            <tr>
                                <td>{{ \App\Models\Text::TYPES[$itemText->type] }}</td>
                                <td>{{ $itemText->title }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary js-add-text act-add fa"
                                            data-bs-dismiss="modal" aria-label="Close"
                                            data-tpl="#tpl-text" data-id="{{ $itemText->id }}"
                                            title="Добавить текст"></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
