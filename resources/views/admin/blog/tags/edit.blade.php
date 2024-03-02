<?php
$help = [
    '$tag' => '',
];

$pageName = 'Редактирование тега';
$page = 'admin.post.tags.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}: ({{ $tag->id }}) - {{ $tag->tag }}</span>
    @include('admin.includes._header_block')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
    <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
          action="{{ route($page . 'update', $tag) }}" novalidate>
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
                        </ul>
                    </div>
                </div>

                <div class="col-xl-12 item-content tab-content">

                    <div id="basic" class="tab-pane fade show active" role="tabpanel" aria-labelledby="basic-tab">
                        <div class="box">
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Тег</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                   name="tag"
                                                   placeholder="Тег"
                                                   value="{{ old('tag', $tag->tag) }}">
                                        </div>
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
                                            {{ $tag->created_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Дата обновления</label>
                                        <div class="col-sm-8">
                                            {{ $tag->updated_at }}
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
