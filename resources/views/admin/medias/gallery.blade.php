<?php
// фильтр по объекту-подобъекту, по диапазону дат(месяц-год), по расположению
$pageName = 'Галерея';
$page = 'admin.medias.';

?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
@endsection

@section('content')
    @include('admin.includes._result_messages')
    @include('admin.includes.media._gallery')

@endsection
