@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
@include('auth.partials.shell', ['mode' => 'reset', 'token' => $token ?? request()->route('token'), 'email' => $email ?? request('email')])
@endsection
