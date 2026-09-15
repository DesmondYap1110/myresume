@push('title')
Login
@endpush

<x-template1.admin.master.master-layout>
    <style>
        .login-stack { display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 400px; }
        .login-logo { margin-bottom: 28px; text-align: center; }
        .login-logo img { width: 260px; max-width: 70vw; height: auto; filter: drop-shadow(0 4px 18px rgba(0, 0, 0, .6)); }
        .login .wrapper.wrapper-login .login-stack .container-login { width: 100%; }
        @media (max-width: 576px) {
            .login-logo { margin-bottom: 18px; }
            .login-logo img { width: 180px; }
        }
    </style>

    <div class="login-stack">
    <div class="login-logo animated fadeIn">
        <img src="{{ asset('assets/admin/img/kaiadmin/logo_login.png') }}" alt="my resume">
    </div>
    <div class="container container-login animated fadeIn" style="display: block;">
        <h3 class="text-center">Sign In</h3>
        <div class="login-form">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="form-sub">
                    <div class="form-floating form-floating-custom mb-3">
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="form-floating form-floating-custom mb-3">
                        <input id="password" name="password" type="password" class="form-control" placeholder="password" required>
                        <label for="password">Password</label>
                        <div class="show-password">
                        <i class="icon-eye"></i>
                        </div>
                    </div>
                </div>
                <div class="form-action mb-3">
                    <button type="submit" class="btn btn-primary w-100 btn-login">Sign In</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</x-template1.admin.master.master-layout>
