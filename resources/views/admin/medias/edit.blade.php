<?php
//$parent = '';
//foreach($categories as $category) {
//    if($item->parent_id === $category->id) {
//        $parent .= "<option value='$category->id' selected='selected'>$category->title</option>";
//    } else {
//        $parent .= "<option value='$category->id'>$category->title</option>";
//    }
//}
?>
@extends('layouts.admin')

@section('title', 'Редактирование изображения')

@section('content')
    <div class="admin">

        @include('admin._nav', ['page' => 'media'])
        <main class="main-content">
            <form class="item container-fluid" method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('admin.media.update', $item) }}">
                @csrf
                @method('PATCH')

                <nav class="main-navbar">
                    <h1 class="navbar-brand">
                        <span class="navbar-title">Изображение</span>
                        <span class="navbar-id">{{ $item->id }}</span>
                        <span class="navbar-label">{{ $item->title }}</span>
                    </h1>
                    <div class="item-actions">
                        <a class="btn btn-secondary act-cancel"
                           title="Переход на список"
                           href="{{ route('admin.media.index') }}">
                            Отмена
                        </a>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary act-save"
                                    title="Сохранить запись">
                                Сохранить
                            </button>
                        </div>

                    </div>
                </nav>
                @include('admin.includes.result_messages')

                <div class="col-lg-12 catalog-content">
                    <div class="row">

                        <div class="col-xl-12 item-navbar">
                            <div class="navbar-content">
                                <ul class="nav nav-tabs flex-row flex-wrap d-flex box" role="tablist">
                                    <li class="nav-item basic">
                                        <a class="nav-link active" href="#basic" data-bs-toggle="tab" role="tab" aria-expanded="true" aria-controls="basic" tabindex="1">
                                            Основные данные
                                        </a>
                                    </li>
                                    <li class="nav-item other">
                                        <a class="nav-link" href="#other" data-bs-toggle="tab" role="tab" aria-expanded="true" aria-controls="basic" tabindex="1">
                                            Прочие данные
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-12 item-content tab-content">

                            <div id="basic" class="item-media tab-pane fade show active" role="tabpanel" aria-labelledby="basic">
                                <div class="group-item card">
                                    <div class="card-header header">
                                        <div class="card-tools-start">
                                            <div class="btn btn-card-header act-show fa show" title="Скрыть/Показать"
                                                 data-bs-target="#item-media-group-data"
                                                 data-bs-toggle="collapse"
                                                 aria-controls="item-media-group-data"
                                                 aria-expanded="false"></div>
                                        </div>
                                        <span class="item-label header-label">Заголовок картинки</span>
                                        <div class="card-tools-end">
{{--                                            <div class="btn btn-card-header act-move fa" title="Переместить"></div>--}}
{{--                                            <div class="btn btn-card-header act-delete fa" title="Удалить этот блок"></div>--}}
                                        </div>
                                    </div>
                                    <div id="item-media-group-data" class="card-block collapse row show" aria-labelledby="item-media-group-item" role="tabpanel">
                                        <div class="col-xl-6">

                                            <div class="form-group media-preview">
                                                <input class="fileupload js-img" type="file" name="imagefile">
                                                <img src="{{ asset($item->link) }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row mandatory">
                                                <label class="col-sm-4 form-control-label">Объект</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select item-status" required="required" name="object">
                                                        <option value="product"{{ $item->object === 'product' ? ' selected' : ''}}>Товар</option>
                                                        <option value="category"{{ $item->object === 'category' ? ' selected' : ''}}>Категория</option>
                                                        <option value="post"{{ $item->object === 'post' ? ' selected' : ''}}>Статья</option>
                                                        <option value="slider"{{ $item->object === 'slider' ? ' selected' : ''}}>Слайдер</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mandatory">
                                                <label class="col-sm-4 form-control-label">id объекта</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                           name="ref_id"
                                                           placeholder="id Объекта"
                                                           value="{{ old('ref_id', $item->ref_id) }}"
                                                           required="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Название</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                           name="title"
                                                           placeholder="Название картинки"
                                                           value="{{ old('title', $item->title) }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Расположение</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select item-status" required="required" name="placement">
                                                        <option value="first"{{ $item->placement === 'first' ? ' selected' : ''}}>Первая картинка</option>
                                                        <option value="second"{{ $item->placement === 'second' ? ' selected' : ''}}>Вторая картинка</option>
                                                        <option value="gallery"{{ $item->placement === 'gallery' ? ' selected' : ''}}>Галерея</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Номер п/п</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                           name="sort"
                                                           placeholder="Сортировка"
                                                           value="{{ old('sort', $item->sort) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="other" class="item-basic tab-pane fade show" role="tabpanel" aria-labelledby="basic">
                                <div class="box">
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
        </main>
    </div>
    @include('admin.media._upload_img')
@endsection
