@extends('layouts.header')
@section('title','Dashboard')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <div class="main-content mt-5">
        <section id="expenses" class="card fade-in">
        
        </section>
    </div>
</div>
@endsection