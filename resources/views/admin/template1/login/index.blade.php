@push('title')
Login
@endpush

<x-template1.admin.master.master-layout>
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
</x-template1.admin.master.master-layout>
