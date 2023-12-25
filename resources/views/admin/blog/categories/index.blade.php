<?php
$pageName = 'Категории статей';
?>

@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-2">
        <div class="col-lg-4 box">
            <ul class="menu-tree">
                {!! postCategories()->menuTree(0) !!}
            </ul>
        </div>
        <div class="col-lg-8 ps-2"></div>
    </div>
    @include('admin.includes._modal_delete')
@endsection
