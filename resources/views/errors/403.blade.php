@extends('layouts.error')

@section('title', $exception->getStatusCode().' | '.$exception->getMessage())

@section('content')

    <div class="error-code">{{ $exception->getStatusCode() }}</div>
    <div class="error-message">{{ !empty($exception->getMessage())?$exception->getMessage():'BẠN KHÔNG CÓ QUYỀN THỰC HIỆN TÁC VỤ NÀY' }}</div>
@endsection