@extends('erp.content')

@section('title') Edit user @endsection

@section('content')
    @include('erp.parts.admin.form', compact('user'))
@endsection