@extends('layouts.app')

@section('content')
<!-- ========== MOBILE APP CLIENT LANDING HERO ========== -->
<section class="lp-hero">
    <div class="lp-hero-inner container" style="padding-top: 1.5rem; padding-bottom: 2rem;">
        <!-- Left Column: Copy -->
        <div class="lp-hero-copy">
            <div class="lp-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1"/></svg>
                BCTVI HIGH SPEED BROADBAND
            </div>
            <h1 class="lp-hero-title">
                <span class="lp-red">BCTVI</span><br class="lp-hero-br">
                Reliable Internet Connection for Your Home
            </h1>
            <p class="lp-hero-sub">
                Enjoy fast, unlimited fiber broadband across Bantayan Island. Manage bookings, monitor technician installation schedules, and view billing statements seamlessly from your phone.
            </p>
            <div class="lp-hero-btns">
                @auth('client')
                    <a href="{{ route('client.book') }}" class="btn-step btn-submit" style="padding: 0.85rem 1.75rem; border-radius: 12px; text-decoration: none;" id="cta-book">
                        ⚡ Book Installation
                    </a>
                    <a href="{{ route('client.appointments') }}" class="btn-step btn-prev" style="padding: 0.85rem 1.5rem; border-radius: 12px; text-decoration: none;" id="cta-dash">
                        📋 View My Bookings
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-step btn-submit" style="padding: 0.85rem 1.75rem; border-radius: 12px; text-decoration: none;" id="cta-get-started">
                        Get Started &rarr;
                    </a>
                    <a href="#plans" class="btn-step btn-prev" style="padding: 0.85rem 1.5rem; border-radius: 12px; text-decoration: none;" id="cta-view-plans">
                        📶 Browse WiFi Plans
                    </a>
                @endauth
            </div>
        </div>

        <!-- Right Column: Hero Image -->
        <div class="lp-hero-visual">
            <div class="lp-hero-img-wrap" style="text-align: center;">
                <img src="{{ asset('assets/images/bctvi-logo.png') }}" alt="BCTVI Broadband Logo" class="lp-hero-img" id="hero-img" style="max-height: 280px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));">
            </div>
        </div>
    </div>

    <!-- Announcement & Quick Status Bar -->
    @auth('client')
        @php
            $activeAppt = \App\Models\Appointment::with('service')
                ->where('client_id', auth('client')->id())
                ->orderBy('created_at', 'desc')
                ->first();
        @endphp
        @if ($activeAppt)
            <div class="container" style="margin-top: 1rem; margin-bottom: 2rem;">
                <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff; border-radius: 16px; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.08);">
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.05em;">Your Latest Booking Status</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #ffffff; margin-top: 2px;">
                            {{ $activeAppt->service->service_name ?? 'WiFi Plan' }} &bull; Ref: {{ $activeAppt->booking_ref ?? ('#'.str_pad($activeAppt->id, 5, '0', STR_PAD_LEFT)) }}
                        </div>
                        <div style="font-size: 0.85rem; color: #cbd5e1; margin-top: 4px;">
                            Scheduled: <strong>{{ date('M d, Y', strtotime($activeAppt->preferred_date)) }} at {{ date('h:i A', strtotime($activeAppt->preferred_time)) }}</strong>
                        </div>
                    </div>
                    <div>
                        <span class="walkin-badge" style="background: {{ $activeAppt->status === 'approved' ? '#16a34a' : ($activeAppt->status === 'cancelled' ? '#dc2626' : '#ea580c') }}; padding: 0.4rem 1rem; font-size: 0.85rem;">
                            Status: {{ ucfirst($activeAppt->status) }}
                        </span>
                        <a href="{{ route('client.appointments') }}" class="btn-step btn-prev" style="margin-left: 0.5rem; padding: 0.4rem 0.85rem; font-size: 0.8rem; text-decoration: none;">Details &rarr;</a>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Feature Badges Bar -->
    <div class="lp-features-bar">
        <div class="container">
            <div class="lp-features-grid">
                <div class="lp-feature-item">
                    <div class="lp-feature-icon lp-icon-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <div>
                        <strong>High-Speed Fiber</strong>
                        <span>Up to 300 Mbps</span>
                    </div>
                </div>
                <div class="lp-feature-item">
                    <div class="lp-feature-icon lp-icon-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <strong>Fast Installation</strong>
                        <span>Pick date & time</span>
                    </div>
                </div>
                <div class="lp-feature-item">
                    <div class="lp-feature-icon lp-icon-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <strong>Reliable Support</strong>
                        <span>24/7 Local Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== PLANS SECTION ========== -->
<section class="lp-plans-section" id="plans">
    <div class="container">
        <div class="lp-section-label">SELECT BROADBAND PACKAGE</div>
        <h2 class="lp-section-title">Available BCTVI Internet Plans</h2>
        <div class="lp-section-divider"></div>

        <div class="lp-plans-grid">
            @forelse ($services as $index => $service)
                @php
                    $instFee = $service->installation_fee ?? 1000.00;
                    $speed = $service->speed ?? 'Fiber Fast';
                @endphp
                <div class="lp-plan-card lp-plan-popular" id="plan-{{ $service->id }}" style="border-radius: 16px;">
                    <div class="lp-plan-badge" style="background: #dc2626;">{{ $speed }}</div>
                    
                    <div class="lp-plan-speed">{{ $service->service_name }}</div>
                    <div class="lp-plan-type">BCTVI UNLIMITED FIBER</div>

                    <ul class="lp-plan-features">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            Speed: <strong>{{ $speed }}</strong>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            Installation Fee: <strong>₱{{ number_format($instFee, 2) }}</strong>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            Unlimited Data &amp; WiFi Modem Included
                        </li>
                    </ul>

                    <div class="lp-plan-price">
                        <span class="lp-price-currency">₱</span>{{ number_format($service->price, 0) }}<span class="lp-price-period">/mo</span>
                    </div>

                    @auth('client')
                        <a href="{{ route('client.book', ['service_id' => $service->id]) }}" class="btn-step btn-submit" style="display: block; text-align: center; text-decoration: none; border-radius: 10px; padding: 0.75rem;" id="book-plan-{{ $service->id }}">
                            Book Installation
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-step btn-submit" style="display: block; text-align: center; text-decoration: none; border-radius: 10px; padding: 0.75rem;" id="book-guest-{{ $service->id }}">
                            Book Installation
                        </a>
                    @endauth
                </div>
            @empty
                <div class="lp-no-plans">
                    <p>No active plans available at the moment. Please contact BCTVI office.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ========== MOBILE APP DOWNLOAD PROMO ========== -->
<section class="lp-download-section" id="download">
    <div class="container">
        <div class="lp-download-inner" style="border-radius: 20px;">
            <div class="lp-download-copy">
                <div class="lp-section-label">CLIENT APP</div>
                <h2 class="lp-section-title">BCTVI Client Companion App</h2>
                <div class="lp-section-divider" style="margin-left: 0;"></div>
                <p class="lp-section-sub" style="margin-left: 0; text-align: left;">
                    Book WiFi installation, monitor technician schedules, view monthly statements, and receive real-time updates directly on your Android phone.
                </p>
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route('download.apk') }}" class="btn-step btn-submit" style="padding: 0.85rem 1.75rem; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                        📥 Download Official Android APK
                    </a>
                </div>
            </div>
            <div class="lp-download-visual" style="text-align: center;">
                <img src="{{ asset('assets/images/bctvi-logo.png') }}" alt="BCTVI Mobile App" style="max-height: 220px; object-fit: contain;">
            </div>
        </div>
    </div>
</section>
@endsection
