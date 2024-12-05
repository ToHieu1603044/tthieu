{{-- resources/views/admin/products/index.blade.php --}}
@extends('main')

@section('content')

@if (session()->has('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session()->has('errors'))
<div class="alert alert-danger">{{ session('success') }}</div>
@endif
<x-table-crud 
:headers="$tableCrud['headers']" 
:list="$tableCrud['list']" 
:actions="$tableCrud['actions']" 
:routes="$tableCrud['routes']" />

{{$tableCrud['list']->links()}}

@endsection