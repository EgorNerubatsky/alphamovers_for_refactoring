@extends('erp.content')

@section('title') Edit user @endsection

@section('content')
    @include('erp.admin.users.form', compact('user'))
@endsection