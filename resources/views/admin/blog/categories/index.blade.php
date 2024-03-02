<?php
$pageName = 'Категории статей';
?>

@extends('layouts.admin')

@push('styles')
    @vite('resources/css/admin/post_categories.css')
@endpush

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-2">
        <div class="col-lg-4 box">
            <a class="btn btn-info"
               href="{{ route('admin.post.categories.add', 0) }}">
                Ввод
            </a>
            {!! postCategories()->menuTree(0) !!}
        </div>

        <div class="col-lg-8 ps-2"></div>
    </div>
    @include('admin.includes._modal_delete')
@endsection
@push('scripts')
    <script src="{{ asset('js/Sortable.min.js') }}" defer></script>
    @vite('resources/js/admin/post_categories.js')
@endpush
