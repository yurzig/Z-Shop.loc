<?php
$help = [
    'title' => '',
    'content' => '',
    'type' => '',
];
$typeOptions = '';
foreach (\App\Models\Text::TYPES as $key => $type) {
    $typeOptions .= "<option value='$key'>$type</option>";
}

$pageName = 'Новый текст';
$page = 'admin.texts.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
    @include('admin.includes._header_block')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
    <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data" action="{{ route($page . 'store') }}">
        @csrf
        @include('admin.includes._result_messages')

        <div class="col-lg-12 catalog-content">
            <div class="row">
                <div class="col-xl-12 item-navbar">
                    <div class="navbar-content">
                        <ul class="nav nav-tabs flex-row flex-wrap d-flex box" role="tablist">
                            <li class="nav-item basic">
                                <a class="nav-link active" href="#basic" data-bs-toggle="tab" role="tab"
                                    aria-expanded="true" aria-controls="basic" tabindex="1">
                                    Ввод данных
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-12 item-content tab-content">
                    <div id="basic" class="item-basic tab-pane fade show active" role="tabpanel" aria-labelledby="basic">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Наименование</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                       name="title"
                                                       placeholder="Наименование текста"
                                                       value="{{ old('title') }}"
                                                       required="required">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['title'] }}</div>
                                    </div>
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Тип</label>
                                        <div class="col-sm-3">
                                            <select class="form-select item-status" name="type">
                                                {!! $typeOptions !!}
                                            </select>
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['type'] }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-12">

                                    <div class="form-group row">
                                        <label class="col-sm-12 form-control-label text-center">Текст</label>
                                        <div class="col-sm-12 help-text">{{ $help['content'] }}</div>
                                        <div class="col-sm-12">
                                            <textarea name="content" class="form-control item-content summernote">{{ old('content') }}</textarea>
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
