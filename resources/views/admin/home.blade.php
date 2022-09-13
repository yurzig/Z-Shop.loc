@extends('layouts.admin')

@section('title', 'Админ-панель')

@section('content')
    <h1>Admin</h1>
    @include('admin.includes._nav', ['page' => 'users'])

@endsection
