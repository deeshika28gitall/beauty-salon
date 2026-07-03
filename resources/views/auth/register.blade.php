@extends('layouts.auth')
@section('title', 'Register')
@section('content')
@include('auth.partials.shell', ['mode' => 'register'])
@endsection
