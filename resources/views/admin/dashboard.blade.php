@extends('layouts.layout')
@section('title','Admin Dashboard')
@section('content')
    <h1>Welcome to the admin dashboard {{ Auth::user()->name }}!</h1>
@endsection
