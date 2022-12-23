@extends('layouts.admin')

@section('title', 'Ввод изображения')

@section('content')
    <div class="admin">

        @include('admin._nav', ['page' => 'media'])
        <main class="main-content">
            <form class="item container-fluid" method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('admin.media.store') }}">
                @csrf

                <nav class="main-navbar">
                    <h1 class="navbar-brand">
                        <span class="navbar-title">Картинка</span>
                        <span class="navbar-label">Новая</span>
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
                                            Ввод данных
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
                                            <div class="btn btn-card-header act-move fa" title="Переместить"></div>
                                            <div class="btn btn-card-header act-delete fa" title="Удалить этот блок"></div>
                                        </div>
                                    </div>
                                    <div id="item-media-group-data" class="card-block collapse row show" aria-labelledby="item-media-group-item" role="tabpanel">
                                        <div class="col-xl-6">

                                            <div class="form-group media-preview">
{{--                                                <input class="d-none" type="file" name="media[0][preview]">--}}
                                                <input class="fileupload js-img" type="file" name="imagefile">
{{--                                                <input class="item-url" type="hidden" name="media[0][media.url]" value="">--}}
                                                <img src="" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row mandatory">
                                                <label class="col-sm-4 form-control-label">Объект</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select item-status" required="required" name="object">
                                                        <option value="product">Товар</option>
                                                        <option value="category">Категория</option>
                                                        <option value="post">Статья</option>
                                                        <option value="slider">Слайдер</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mandatory">
                                                <label class="col-sm-4 form-control-label">id объекта</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                           name="ref_id"
                                                           placeholder="id Объекта"
                                                           value="{{ old('ref_id') }}"
                                                           required="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Название</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                           name="title"
                                                           placeholder="Название картинки"
                                                           value="{{ old('title') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Расположение</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select item-status" required="required" name="placement">
                                                        <option value="first">Первая картинка</option>
                                                        <option value="second">Вторая картинка</option>
                                                        <option value="gallery">Галерея</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 form-control-label">Номер п/п</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                           name="sort"
                                                           placeholder="Сортировка"
                                                           value="{{ old('sort') }}">
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
