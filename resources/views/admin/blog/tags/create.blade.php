<?php
$help = [
    'id' => '',
    'tag' => '',
];

$pageName = 'Новый тег';
$page = 'admin.post.tags.';
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
                                                   value="{{ old('tag') }}">
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
