<?php
$help = [
    'title' => '',
    'content' => '',
    'type' => '',
];
$pageName = 'Редактирование текста';
$page = 'admin.texts.';
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
          action="{{ route($page . 'update', $item) }}" novalidate>
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
                                <button class="nav-link" id="other-tab" data-bs-toggle="tab" type="button" role="tab"
                                        data-bs-target="#other" aria-controls="other" aria-selected="false">
                                    Прочие данные
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="usage-tab" data-bs-toggle="tab" type="button" role="tab"
                                        data-bs-target="#usage" aria-controls="usage" aria-selected="false">
                                    Использование
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-12 item-content tab-content">
                    <div class="tab-pane fade active show" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-6">

                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Тип</label>
                                        <div class="col-sm-8">
                                            {{ $types[$item->type] }}
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['type'] }}</div>
                                    </div>
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Наименование</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                   name="title"
                                                   placeholder="Наименование текста"
                                                   value="{{ old('title', $item->title) }}"
                                                   required="required">
                                        </div>
                                        <div class="col-sm-12 help-text">{{ $help['title'] }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <div class="col-sm-12 help-text">{{ $help['content'] }}</div>
                                        <textarea name="content" required="required"
                                                  class="form-control item-content summernote"
                                        >{{ old('content', $item->content) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
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
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Редактор</label>
                                        <div class="col-sm-8">
                                            {{ $item->editor}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="usage" role="tabpanel" aria-labelledby="usage-tab">
                        <div class="box">
                            <table class="list-items table table-hover table-striped">
                                <thead class="list-header">
                                <tr>
                                    <th>Таблица</th>
                                    <th>id</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($objects as $object)
                                    <tr>
                                        <td>{{ $object->textable_type }}</td>
                                        <td>
                                            <a href="{{ route(\App\Models\Text::ROUTES[$object->textable_type],$object->textable_id) }}"
                                            title="ссылка на объект">
                                                {{ $object->textable_id }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection
