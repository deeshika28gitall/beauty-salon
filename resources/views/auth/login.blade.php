@extends('layouts.auth')
@section('title', 'Login')
@section('content')
@include('auth.partials.shell', ['mode' => 'login'])
@endsection
