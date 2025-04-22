@extends('layout.app')

@section('title', {{ $titulo }})

@section('content')

    <h1>{{ $titulo }}</h1>

    {!! $conteudo !!}

@endsection
