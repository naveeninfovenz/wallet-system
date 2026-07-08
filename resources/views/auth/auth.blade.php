@extends('layouts.header')
@section('title','Login')
@section('content')

<div class="container">
    @include('auth.login')
    @include('auth.register')
	<div class="container__overlay">
		<div class="overlay">
			<div class="overlay__panel overlay--left">
				<button class="btn" id="signIn">Sign In</button>
			</div>
			<div class="overlay__panel overlay--right">
				<button class="btn" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
@endsection