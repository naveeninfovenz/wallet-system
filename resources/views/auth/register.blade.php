	<!-- Sign Up -->
	<div class="container__form container--signup">
		<form action="{{route('register')}}" method="post" class="form">
            @csrf
			<h2 class="form__title">Sign Up</h2>
			<input type="text" required placeholder="User" name="name" class="input" />
			<input type="email" required placeholder="Email" name="email" class="input" />
			<input type="password" required placeholder="Password" name="password" class="input" />
			<button type="submit" class="btn">Sign Up</button>
		</form>
	</div>