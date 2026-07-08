<div class="container__form container--signin">
    <form action="{{ route('login') }}" method="post" class="form">
        @csrf
        <h2 class="form__title">Sign In</h2>
        <input type="email" name="email" required placeholder="Email" class="input" />
        <input type="password" name="password" required placeholder="Password" class="input" />
        <button class="btn" type="submit">Sign In</button>
    </form>
</div>



