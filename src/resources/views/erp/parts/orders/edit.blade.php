@extends('erp.content')

@section('title') Редагування замовлення @endsection

@section('content')
    @if(Auth::user()->is_manager || Auth::user()->is_executive)
    @include('erp.parts.orders.edit_form')
    @elseif(Auth::user()->is_logist)
    @include('erp.parts.orders.edit_form_logist')
    @elseif(Auth::user()->is_accountant)
    @include('erp.parts.orders.edit_form_accountant')

    @endif
@endsection

