@extends('Layout.app')

@section('content')

<div class="content-header">
    <h1>Dashboard</h1>
</div>

<div class="content">
    <p>Selamat datang {{ auth()->user()->nama }}</p>
</div>

@endsection
