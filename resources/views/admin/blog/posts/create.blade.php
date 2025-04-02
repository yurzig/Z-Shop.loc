<?php
$help = [
    'category_id' => 'Необходимо привязать статью к категории',
    'user_id' => 'Необходимо указать автора статьи',
    'title' => 'Заголовок статьи',
    'slug' => 'Url статьи(если не указать, то формируется автоматически)',
    'excerpt' => 'Краткое описание статьи',
    'content' => 'Текст статьи',
    'status' => 'Укажите статус статьи(по-умолчанию - черновик)',
    'tags' => 'Укажите теги связанные с этой статьей',
    'is_published' => 'Признак публикации статьи',
    'published_at' => 'Дата публикации статьи',
    'meta_title' => 'Заголовок статьи для SEO',
    'meta_description' => 'Краткое описание статьи для SEO',
];

$pageName = 'Новая статья';
$page = 'admin.posts.';
?>

@extends('layouts.admin')

@section('title', $pageName)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
    @vite('resources/css/admin/posts.css')
@endpush

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
                                                       class="form-control js-title"
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
                            <div id="sortableBlock" class="box list-group">
                                <div class="form-group row">
                                    <label class="form-control-label justify-content-center">Аннотация</label>
                                    <div class="col-sm-12 help-text">{{ $help['excerpt'] }}</div>
                                    <textarea name="excerpt"
                                              class="form-control item-content">{{ old('excerpt') }}</textarea>
                                </div>
                                <div class="add-block-to-post accordion"
                                     data-url="{{ route($page . 'add_block') }}"
                                     data-last-block="0">

                                    <button data-type="text-only" class="btn btn-default">Блок текста</button>
                                    <button data-type="img-and-text" class="btn btn-default">Картинка + текст</button>
                                    <button data-type="img-only" class="btn btn-default">Картинка</button>
                                    <button data-type="subtitle" class="btn btn-default">Подзаголовок</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="change-img-modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Рисунок</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="{{ asset('images/noimage.jpg') }}">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn md btn-default apply-btn" data-url="{{ route($page . 'add_img') }}">Сохранить</button>
                    <button type="button" class="cancel-btn btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/Sortable.min.js') }}" defer></script>
    <script src="{{ asset('js/cropper.js') }}" defer></script>
    @vite('resources/js/admin/posts.js')
@endpush