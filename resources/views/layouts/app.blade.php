<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#dc2626">
    <title>@yield('title', 'CCTN Bantayan Booking & Appointment')</title>
    <meta name="description" content="Book appointments and broadcasting services online for Cine Cebu Television Network - Bantayan Branch.">
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    @stack('styles')
</head>
<body>

    <header class="lp-header">
        <div class="container lp-navbar">
            <a href="{{ route('home') }}" class="lp-logo">
                <img src="{{ asset('assets/images/cctn-logo.png') }}" alt="CCTN Logo" class="lp-logo-img">
                <div class="lp-logo-text">
                    <span class="lp-logo-name">CCTN</span>
                    <span class="lp-logo-sub">Bantayan</span>
                </div>
            </a>

            <ul class="lp-nav-links" id="lp-nav-menu">
                <li><a href="{{ route('home') }}" class="lp-nav-link {{ request()->routeIs('home') ? 'lp-nav-active' : '' }}">Home</a></li>

                @auth('client')
                    <li><a href="{{ route('client.dashboard') }}" class="lp-nav-link {{ request()->routeIs('client.dashboard') ? 'lp-nav-active' : '' }}">My Dashboard</a></li>
                    <li><a href="{{ route('client.appointments') }}" class="lp-nav-link {{ request()->routeIs('client.appointments') ? 'lp-nav-active' : '' }}">My Bookings</a></li>
                    <li><a href="{{ route('client.billing') }}" class="lp-nav-link {{ request()->routeIs('client.billing') ? 'lp-nav-active' : '' }}">Billing</a></li>
                    <li>
                        <span class="lp-nav-user">
                            <img src="{{ auth('client')->user()->profile_photo ? asset(auth('client')->user()->profile_photo) : asset('assets/img/default-avatar.svg') }}" alt="Avatar" class="lp-nav-avatar">
                            {{ auth('client')->user()->firstname }}
                        </span>
                    </li>
                    <li><a href="{{ route('client.book') }}" class="lp-btn-nav-book">Book Now</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="lp-btn-nav-logout" style="border:none; cursor:pointer;">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="lp-nav-link {{ request()->routeIs('login') ? 'lp-nav-active' : '' }}">Login</a></li>
                    <li><a href="{{ route('register') }}" class="lp-nav-link {{ request()->routeIs('register') ? 'lp-nav-active' : '' }}">Register</a></li>
                    <li>
                        <a href="{{ route('admin.login') }}" class="lp-btn-admin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Admin Portal
                        </a>
                    </li>
                @endauth
            </ul>

            <button class="lp-hamburger" id="lp-hamburger" aria-label="Toggle menu" onclick="document.getElementById('lp-nav-menu').classList.toggle('lp-nav-open')">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <main class="lp-main-wrap">
        @if (session('success_message'))
            <div class="alert alert-success fade-in">{{ session('success_message') }}</div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-danger fade-in">{{ session('error_message') }}</div>
        @endif
        @if (session('redirect_message'))
            <div class="alert alert-warning fade-in">{{ session('redirect_message') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger fade-in">
                <ul style="margin:0; padding-left:1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer style="background: #0f172a; padding: 2rem; text-align: center; color: #94a3b8; font-size: 0.9rem; margin-top: 3rem;">
        <p>&copy; {{ date('Y') }} CCTN Bantayan. All Rights Reserved.</p>
    </footer>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
