<?php
$help = [
    'post_id' => '',
    'user_id' => '',
    'rating' => '',
    'comment' => '',
    'response' => '',
    'status' => '',
];

$postOptions = '';
foreach($posts as $post) {
    $postOptions .= "<option value={$post->id}>{$post->title}</option>";
}
$userOptions = '';
foreach ($users as $user) {
    $userOptions .= "<option value='$user->id'>$user->name</option>";
}
$statusOptions = '';
foreach (\App\Models\Blog\Review::STATUSES as $key => $status) {
    $statusOptions .= "<option value='$key'>$status</option>";
}
$pageName = 'Новый отзыв';
$page = 'admin.blog.reviews.';
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
                                <a class="nav-link active" href="#basic" data-bs-toggle="tab" role="tab" aria-expanded="true" aria-controls="basic">
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
                                <div class="col-xl-6 block">
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Статья</label>
                                        <div class="col-sm-8">
                                            <select class="form-select item-status" required="required" name="post_id">
                                                {!! $postOptions !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Пользователь</label>
                                        <div class="col-sm-8">
                                            <select class="form-select item-status" required="required" name="user_id">
                                                {!! $userOptions !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Рейтинг</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number"
                                                   name="rating"
                                                   placeholder="Рейтинг товара(1-5)"
                                                   min="1" max="5"
                                                   value="{{ old('rating') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Комментарий</label>
                                        <div class="col-sm-8">
                                            <textarea name="comment" class="form-control item-content">{{ old('comment') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Ответ</label>
                                        <div class="col-sm-8">
                                            <input class="form-control flatpickr-input" type="text"
                                                   name="response"
                                                   placeholder="Ответ на комментарий"
                                                   value="{{ old('response') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Статус</label>
                                        <div class="col-sm-8">
                                            <select class="form-select item-status" required="required" name="status">
                                                {!! $statusOptions !!}
                                            </select>
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
