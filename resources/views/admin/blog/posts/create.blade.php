<?php
$help = [
    'category_id' => 'Необходимо привязать статью к категории',
    'user_id' => 'Необходимо указать автора статьи',
    'title' => 'Заголовок статьи',
    'slug' => 'Url статьи(формируется автоматически)',
    'excerpt' => 'Краткое описание статьи',
    'content' => 'Текст статьи',
    'tags' => 'Укажите теги связанные с этой статьей',
    'is_published' => 'Признак публикации статьи',
    'published_at' => 'Дата публикации статьи',
];

$pageName = 'Новая статья';
$page = 'admin.posts.';
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
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="content-tab" data-bs-toggle="tab" type="button"
                                            role="tab" data-bs-target="#content" aria-controls="content"
                                            aria-selected="false">
                                        Текст статьи
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-12 item-content tab-content">

                        <div id="basic" class="tab-pane fade show active" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="box">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8 block">
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Категория</label>
                                            <div class="col-sm-8">
                                                <select name="category_id" class="form-select item-status"
                                                        required="required">
                                                    {!! postCategories()->selectTree(0) !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['category_id'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Автор</label>
                                            <div class="col-sm-8">
                                                <select name="user_id" class="form-select item-status select2"
                                                        required="required">
                                                    @foreach (users()->getForSelect() as $user)
                                                        <option value={{ $user->id }} @selected($user->id === Auth::id())>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['user_id'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Заголовок</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="title"
                                                       class="form-control"
                                                       value="{{ old('title') }}"
                                                       required="required"
                                                       placeholder="Заголовок статьи">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['title'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Url</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="slug"
                                                       class="form-control"
                                                       value="{{ old('slug') }}"
                                                       placeholder="Уникальный идентификатор">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Теги</label>
                                            <div class="col-sm-8">
                                                <select name="tags[]" class="form-select item-status select2"
                                                        multiple="multiple">
                                                    @foreach (postTags()->getForSelect() as $tag) {
                                                        <option value='{{ $tag->tag }}'>{{ $tag->tag }}</option>";
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['tags'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Статья опубликована</label>
                                            <div class="col-sm-8 form-check form-switch">
                                                <input type="hidden" name="is_published" value="0">
                                                <input type="checkbox" name="is_published"
                                                       class="form-control form-check-input"
                                                       value="1">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['is_published'] }}</div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Дата публикации</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="published_at"
                                                       class="form-control flatpickr-input"
                                                       value="{{ old('published_at') }}"
                                                       placeholder="Дата публикации статьи">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['published_at'] }}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="content" class="tab-pane fade" role="tabpanel" aria-labelledby="content-tab">
                            <div class="box">
                                <div class="form-group row">
                                    <label class="form-control-label justify-content-center">Аннотация</label>
                                    <div class="col-sm-12 help-text">{{ $help['excerpt'] }}</div>
                                    <textarea name="excerpt"
                                              class="form-control item-content">{{ old('excerpt') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label justify-content-center">Статья</label>
                                    <div class="col-sm-12 help-text">{{ $help['content'] }}</div>
                                    <textarea name="content" required="required"
                                              class="summernote form-control item-content">{{ old('content') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
