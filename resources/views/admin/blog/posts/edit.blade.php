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
    'meta_title' => '',
    'meta_description' => '',
];
$userOptions = '';
foreach ($users as $user) {
    $selected = ($item->user_id === $user->id) ? ' selected="selected"' : '';
    $userOptions .= "<option value='$user->id' selected='selected'>$user->name</option>";
}
$statusOptions = '';
foreach (\App\Models\Blog\Post::STATUS as $key => $status) {
    $selected = ($item->status === $key) ? ' selected="selected"' : '';
    $statusOptions .= "<option value='$key'$selected>$status</option>";
}

$pageName = 'Редактирование статьи';
$page = 'admin.blog.posts.';
?>

@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}: ({{ $item->id }}) {{ $item->title }}</span>
    @include('admin.includes._header_block')
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
                                <li class="nav-item basic">
                                    <a class="nav-link" href="#content" data-bs-toggle="tab" role="tab"
                                       aria-expanded="true" aria-controls="content">
                                        Текст статьи
                                    </a>
                                </li>
                                <li class="nav-item basic">
                                    <a class="nav-link" href="#review" data-bs-toggle="tab" role="tab"
                                       aria-expanded="true" aria-controls="review">
                                        Отзывы
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

                        <div id="basic" class="item-basic tab-pane fade show active" role="tabpanel"
                             aria-labelledby="basic">
                            <div class="box">
                                <div class="row justify-content-center">
                                    <div class="col-xl-6 block">
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Категория</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" required="required"
                                                        name="category_id">
                                                    {!! \App\Services\Blog\CategoryService::selectTree($categories, $item->category_id) !!}
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
                                        <div class="form-group row">
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
                                                       value="{{ old('published_at', $item->published_at) }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['published_at'] }}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="content" class="item-basic tab-pane fade" role="tabpanel"
                             aria-labelledby="content">
                            <div class="box">
                                <div class="form-group row">
                                    <label class="form-control-label justify-content-center">Аннотация</label>
                                    <div class="col-sm-12 help-text">{{ $help['excerpt'] }}</div>
                                    <textarea name="excerpt"
                                              class="form-control item-content">{{ old('excerpt', $item->excerpt) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label justify-content-center">Статья</label>
                                    <div class="col-sm-12 help-text">{{ $help['content'] }}</div>
                                    <textarea name="content"
                                              class="summernote form-control item-content">{{ old('content', $item->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div id="review" class="item-basic tab-pane fade" role="tabpanel" aria-labelledby="review">
                            <div class="box">
                                @include('admin.blog.posts._reviews')
                            </div>
                        </div>
                        <div id="other" class="item-basic tab-pane fade" role="tabpanel" aria-labelledby="basic">
                            <div class="box">
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">meta-title</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="meta_title"
                                               placeholder="title"
                                               value="{{ old('meta_title', $item->meta_title) }}">
                                    </div>
                                    <div class="col-sm-12 help-text">{{ $help['meta_title'] }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">meta-description</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="meta_description"
                                               placeholder="description"
                                               value="{{ old('meta_description', $item->meta_description) }}">
                                    </div>
                                    <div class="col-sm-12 help-text">{{ $help['meta_description'] }}</div>
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
@endsection
