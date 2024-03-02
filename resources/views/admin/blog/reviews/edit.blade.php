<?php
$help = [
    'post_id' => '',
    'user_id' => '',
    'rating' => '',
    'comment' => '',
    'response' => '',
    'status' => '',
];

$pageName = 'Редактирование отзыва';
$page = 'admin.post.reviews.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}: ({{ $review->id }}) для статьи - {{ $review->post->title }}</span>
    @include('admin.includes._header_block')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
    <form id="edit-form" class="item w-100" method="POST" enctype="multipart/form-data"
          action="{{ route($page . 'update', $review) }}" novalidate>
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
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Статья</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="post_id" value="{{ $review->post_id }}">
                                            <input class="form-control" readonly type="text" value="{{ $review->post->title }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mandatory">
                                        <label class="col-sm-4 form-control-label">Пользователь</label>
                                        <div class="col-sm-8">
                                            <select class="form-select select2"
                                                    required="required"
                                                    name="user_id"
                                                    data-placeholder="Пользователь оставивший отзыв">
                                                @foreach (users()->getForSelect() as $user)
                                                    <option value={{ $user->id }} @selected($review->user_id === $user->id)>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Рейтинг</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                   name="rating"
                                                   placeholder="Рейтинг товара(1-5)"
                                                   value="{{ old('rating', $review->rating) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Комментарий</label>
                                        <div class="col-sm-8">
                                            <textarea name="comment" class="form-control item-content" style="height: 100px">{{ old('comment', $review->comment) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Ответ</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                   name="response"
                                                   placeholder="Ответ на комментарий"
                                                   value="{{ old('response', $review->response) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Статус</label>
                                        <div class="col-sm-8">
                                            <select class="form-select item-status" required="required" name="status">
                                                @foreach (postReviews()->getStatuses() as $key => $status) {
                                                <option value='{{ $key }}' @selected($review->status === $key)>{{ $status }}</option>";
                                                @endforeach
                                            </select>
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
                                            {{ $review->created_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xl-6 block">
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Дата обновления</label>
                                        <div class="col-sm-8">
                                            {{ $review->updated_at }}
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
