@extends('layouts.layout')
@section('title','Dashboard')
@section('content')
    <h1>Welcome to the customer dashboard {{ Auth::user()->name }}!</h1>
@endsection
