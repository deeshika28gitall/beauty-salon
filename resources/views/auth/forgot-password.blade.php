@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')
@include('auth.partials.shell', ['mode' => 'forgot'])
@endsection
