<?php
$help = [
    'category_id' => '',
    'user_id' => '',
    'title' => '',
    'slug' => '',
    'excerpt' => '',
    'content' => '',
    'status' => '',
    'published_at' => '',
];
$userOptions = '';
$user_id = Auth::id();
foreach ($users as $user) {
    $selected = ($user->id === $user_id) ? ' selected="selected"' : '';
    $userOptions .= "<option value='$user->id'$selected>$user->name</option>";
}
$statusOptions = '';
foreach (\App\Models\Blog\Post::STATUS as $key => $status) {
    $statusOptions .= "<option value='$key'>$status</option>";
}

$pageName = 'Новая статья';
$page = 'admin.blog.posts.';
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

                        <div id="basic" class="tab-pane fade show active" role="tabpanel"
                             aria-labelledby="basic-tab">
                            <div class="box">
                                <div class="row justify-content-center">
                                    <div class="col-xl-6 block">
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Категория</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" name="category_id"
                                                        required="required">
                                                    {!! \App\Services\Blog\CategoryService::selectTree($categories, 0) !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['category_id'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Автор</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" required="required"
                                                        name="user_id">
                                                    {!! $userOptions !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['user_id'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Заголовок</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"
                                                       name="title"
                                                       placeholder="Заголовок статьи"
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
                                            <label class="col-sm-4 form-control-label">Статус</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" required="required"
                                                        name="status">
                                                    {!! $statusOptions !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['status'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Дата публикации</label>
                                            <div class="col-sm-8">
                                                <input class="form-control flatpickr-input" type="text"
                                                       name="published_at"
                                                       placeholder="Дата публикации статьи"
                                                       value="{{ old('published_at') }}">
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
