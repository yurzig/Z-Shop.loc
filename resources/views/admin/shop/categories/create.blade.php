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
$pageName = 'Новая категория';
$page = 'admin.shop.categories.';
?>

@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
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

                        <div id="basic" class="item-basic tab-pane fade show active" role="tabpanel"
                             aria-labelledby="basic-tab">
                            <div class="box">
                                <div class="row justify-content-center">
                                    <div class="col-xl-6 block">
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Название</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="title"
                                                       placeholder="Название категории"
                                                       value="{{ old('title') }}"
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
                                                       value="{{ old('slug') }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Родитель</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" name="parent_id"
                                                        required="required">
                                                    <option value="0">1-й уровень</option>
                                                    {!! \App\Services\Shop\CategoryService::selectTree($categories, $parent) !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['parent_id'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">meta-title</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="meta_title"
                                                       placeholder="meta-title"
                                                       value="{{ old('meta_title') }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['meta_title'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">meta-description</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="meta_description"
                                                       placeholder="meta-description"
                                                       value="{{ old('meta_description') }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['meta_description'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">title продукта</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="tmpl_title"
                                                       placeholder="Шаблон title продукта"
                                                       value="{{ old('tmpl_title') }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['tmpl_title'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">description продукта</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="tmpl_description"
                                                       placeholder="Шаблон description продукта"
                                                       value="{{ old('tmpl_description') }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['tmpl_description'] }}</div>
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
