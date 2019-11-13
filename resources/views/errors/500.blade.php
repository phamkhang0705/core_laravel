@extends('layouts.error')

@section('title', $exception->getStatusCode().' | '.$exception->getMessage())

@section('content')

    <div class="error-code">{{ $exception->getStatusCode() }}</div>
    <div class="error-message">{{ $exception->getMessage() }}</div>

@endsection