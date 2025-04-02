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

$pageName = 'Редактирование статьи';
$page = 'admin.posts.';
?>

@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
    @vite('resources/css/admin/posts.css')
@endpush

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}: ({{ $post->id }}) {{ $post->title }}</span>
    @include('admin.includes._header_block')
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
        <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
              action="{{ route($page . 'update', $post) }}" novalidate>
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
                                    <button class="nav-link" id="content-tab" data-bs-toggle="tab" type="button" role="tab"
                                            data-bs-target="#content" aria-controls="content" aria-selected="false">
                                        Текст статьи
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" type="button" role="tab"
                                            data-bs-target="#review" aria-controls="review" aria-selected="false">
                                        Отзывы
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="other-tab" data-bs-toggle="tab" type="button" role="tab"
                                            data-bs-target="#other" aria-controls="other" aria-selected="false">
                                        SEO и прочие данные
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
                                    <div class="col-xl-8 block">
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Категория</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status" required="required"
                                                        name="category_id">
                                                    {!! postCategories()->selectTree($post->category_id) !!}
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['category_id'] }}</div>
                                        </div>
                                        <div class="form-group row mandatory">
                                            <label class="col-sm-4 form-control-label">Автор</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status select2" required="required"
                                                        name="user_id">
                                                    @foreach (users()->getForSelect() as $user)
                                                        <option value={{ $user->id }} @selected($post->user_id === $user->id)>{{ $user->name }}</option>
                                                    @endforeach
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
                                                       value="{{ old('title', $post->title) }}"
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
                                                       value="{{ old('slug', $post->slug) }}">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['slug'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Теги</label>
                                            <div class="col-sm-8">
                                                <select class="form-select item-status select2-tag"
                                                        name="tags[]" multiple="multiple" data-url="{{ route($page . 'add_tag') }}" >
                                                    @foreach (postTags()->getForSelect() as $tag) {
                                                        <option value='{{ $tag->tag }}' @isset( $post->tags ) @selected( in_array($tag->tag, $post->tags ) )@endisset>{{ $tag->tag }}</option>";
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['tags'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Статья опубликована</label>
                                            <div class="col-sm-8 form-check form-switch">
                                                <input type="hidden" name="is_published" value="0">
                                                <input class="form-control form-check-input" type="checkbox"
                                                       name="is_published"
                                                       @checked($post->is_published)
                                                       value="1">
                                            </div>
                                            <div class="col-sm-12 help-text">{{ $help['is_published'] }}</div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Дата публикации</label>
                                            <div class="col-sm-8">
                                                <input class="form-control flatpickr-input" type="text"
                                                       name="published_at"
                                                       placeholder="Дата публикации статьи"
                                                       value="{{ old('published_at', $post->published_at) }}">
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
                                              class="form-control item-content">{{ old('excerpt', $post->excerpt) }}</textarea>
                                </div>
                                @if(count($post->content) > 1)
                                <div class="form-group collapsed">
                                    <button class="collapsed-btn btn-secondary" type="button">Развернуть блоки</button>
                                </div>
                                @endif
                                @php $lastId = 0; @endphp
                                @foreach($post->content as $block)
                                    @php $lastId = $block['blockId'] > $lastId ? $block['blockId'] : $lastId  @endphp
                                    @switch($block['type'])
                                        @case('img-and-text')
                                            @include('admin.blog.posts._block-img-and-text',['blockId' => $block['blockId']])
                                        @break
                                        @case('img-only')
                                            @include('admin.blog.posts._block-img',['blockId' => $block['blockId']])
                                        @break
                                        @case('text-only')
                                            @include('admin.blog.posts._block-text',['blockId' => $block['blockId']])
                                        @break
                                        @case('subtitle')
                                            @include('admin.blog.posts._block-subtitle',['blockId' => $block['blockId']])
                                        @break
                                    @endswitch
                                @endforeach
                                <div class="add-block-to-post accordion"
                                     data-url="{{ route($page . 'add_block') }}"
                                     data-last-block="{{ $lastId }}">

                                    <button data-type="text-only" class="btn btn-default">Блок текста</button>
                                    <button data-type="img-and-text" class="btn btn-default">Картинка + текст</button>
                                    <button data-type="img-only" class="btn btn-default">Картинка</button>
                                    <button data-type="subtitle" class="btn btn-default">Подзаголовок</button>
                                </div>
                            </div>
                        </div>
                        <div id="review" class="tab-pane fade" role="tabpanel" aria-labelledby="review-tab">
                            <div class="box">
                                @include('admin.blog.posts._reviews')
                            </div>
                        </div>
                        <div id="other" class="tab-pane fade" role="tabpanel" aria-labelledby="other-tab">
                            <div class="box">
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">meta-title</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="meta_title"
                                               placeholder="title"
                                               value="{{ old('meta_title', $post->meta_title) }}">
                                    </div>
                                    <div class="col-sm-12 help-text">{{ $help['meta_title'] }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">meta-description</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text"
                                               name="meta_description"
                                               placeholder="description"
                                               value="{{ old('meta_description', $post->meta_description) }}">
                                    </div>
                                    <div class="col-sm-12 help-text">{{ $help['meta_description'] }}</div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">Дата создания</label>
                                    <div class="col-sm-8">
                                        {{ $post->created_at }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 form-control-label">Дата обновления</label>
                                    <div class="col-sm-8">
                                        {{ $post->updated_at }}
                                    </div>
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
