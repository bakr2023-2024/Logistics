<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/sketchy/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                @if (Auth::user())
                    @auth('admin')
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.customers.index') ? 'active' : '' }}"
                                    href="{{ route('admin.customers.index') }}">Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.admins.index') ? 'active' : '' }}"
                                    href="{{ route('admin.admins.index') }}">Admins</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.shipments.index') ? 'active' : '' }}"
                                    href="{{ route('admin.shipments.index') }}">Shipments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.tickets.index') ? 'active' : '' }}"
                                    href="{{ route('admin.tickets.index') }}">Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.logs.index') ? 'active' : '' }}"
                                    href="{{ route('admin.logs.index') }}">Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.report.index') ? 'active' : '' }}"
                                    href="{{ route('admin.report.index') }}">Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.admins.show') ? 'active' : '' }}"
                                    href="{{ route('admin.admins.show', Auth::user()->id) }}">Profile</a>
                            </li>
                            <li class="nav-item">
                                <form method="post" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button class="nav-link btn btn-sm" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    @endauth
                    @auth('web')
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('shipments.index') ? 'active' : '' }}"
                                    href="{{ route('shipments.index') }}">Shipments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('tickets.index') ? 'active' : '' }}"
                                    href="{{ route('tickets.index') }}">Contact us</a>
                            </li>
                            @if (Auth::user())
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('customers.show') ? 'active' : '' }}"
                                        href="{{ route('customers.show', Auth::user()) }}">Profile</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="nav-link btn btn-sm btn-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    @endauth
                @else
                    @guest
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false">Login</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.login') }}">Admin</a>
                                    <a class="dropdown-item" href="{{ route('login') }}">Customer</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false">Register</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.register') }}">Admin</a>
                                    <a class="dropdown-item" href="{{ route('register') }}">Customer</a>
                                </div>
                            </li>
                        </ul>
                    @endguest
                @endif
            </div>
        </div>
    </nav>
    <div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function togglePassword(event) {
            event.preventDefault();
            const passwordField = event.target.closest('.input-group').querySelector('input');
            const icon = event.target.querySelector('i');
            const newType = passwordField.type === 'password' ? 'text' : 'password';

            passwordField.type = newType;
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
    </script>
</body>

</html>
