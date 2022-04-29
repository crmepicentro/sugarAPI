@extends('errors.minimal')

{{--@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))--}}

@section('title')
    {{ $title ?? __('Not Found') }}
@endsection

@section('code')
    {{ $code ?? '404' }}
@endsection

@section('message')
    {{ @$message ?? __('Not Found') }}
@endsection
