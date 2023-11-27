<?php
$help = [
    'title' => '',
    'slug' => '',
    'parent_id' => '',
];
$pageName = 'Категория статьи';
$page = 'admin.blog.categories.';
?>

@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}: ({{ $category->id }}) {{ $category->title }}</span>
    <div class="item-actions my-1">
        <a class="btn btn-secondary js-help" role="button" data-bs-toggle="button" aria-pressed="false"
           title="Подсказки" href="#">?</a>
        <div class="btn-group">
            <button type="submit" form="edit-form" class="btn btn-primary act-save" title="Сохранить запись">Сохранить
            </button>
        </div>
    </div>
@endsection

@section('content')
    @include('admin.includes._result_messages')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-2">
        <div class="col-lg-4 box">
            <ul class="menu-tree">
                {!! \App\Services\Blog\CategoryService::menuTree($categories, $category->id) !!}
            </ul>
        </div>
        <div class="col-lg-8 ps-2">
            <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
                  action="{{ route($page . 'update', $category) }}" novalidate>
                @csrf
                @method('PATCH')


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

                            <div id="basic" class="tab-pane fade show active" role="tabpanel"
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
                                                           value="{{ old('title', $category->title) }}"
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
                                                           value="{{ old('slug', $category->slug) }}">
                                                </div>
                                                <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                            </div>
                                            <div class="form-group row mandatory">
                                                <label class="col-sm-4 form-control-label">Родитель</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" required="required" name="parent_id">
                                                        <option value="0">1-й уровень</option>
                                                        {!! \App\Services\Blog\CategoryService::selectTree($categories, $category->parent_id) !!}
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 help-text">{{ $help['parent_id'] }}</div>
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
                                                    {{ $category->created_at }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-6 block">
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Дата обновления</label>
                                                <div class="col-sm-8">
                                                    {{ $category->updated_at }}
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
    </div>
    @include('admin.includes._modal_delete')
@endsection
