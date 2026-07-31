@extends('layouts.app')

@section('content')
<!-- ========== HERO SECTION ========== -->
<section class="lp-hero">
    <div class="lp-hero-inner container">
        <!-- Left Column: Copy -->
        <div class="lp-hero-copy">
            <div class="lp-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1"/></svg>
                FAST &bull; RELIABLE &bull; UNLIMITED
            </div>
            <h1 class="lp-hero-title">
                <span class="lp-red">CCTN</span><br class="lp-hero-br">
                FIBER WIFI<br class="lp-hero-br">
                INSTALLATION &amp; BOOKING
            </h1>
            <p class="lp-hero-sub">
                Experience blazing-fast, reliable unlimited fiber internet. Book your WiFi installation appointment online in minutes!
            </p>
            <div class="lp-hero-btns">
                @auth('client')
                    <a href="{{ route('client.book') }}" class="lp-btn-primary" id="cta-book">
                        Book Appointment &rarr;
                    </a>
                    <a href="{{ route('client.dashboard') }}" class="lp-btn-outline" id="cta-dash">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                        My Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="lp-btn-primary" id="cta-get-started">
                        Get Started &rarr;
                    </a>
                    <a href="#plans" class="lp-btn-outline" id="cta-view-plans">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
                        View Plans
                    </a>
                @endauth
            </div>
        </div>

        <!-- Right Column: Hero Image -->
        <div class="lp-hero-visual">
            <div class="lp-hero-img-wrap">
                <img src="{{ asset('assets/images/hero-router.png') }}" alt="CCTN Fiber WiFi Router" class="lp-hero-img" id="hero-img">
            </div>
        </div>
    </div>

    <!-- Feature badges bar -->
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
                        <strong>Rapid Installation</strong>
                        <span>Book date & time</span>
                    </div>
                </div>
                <div class="lp-feature-item">
                    <div class="lp-feature-icon lp-icon-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <strong>100% Reliable</strong>
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
        <div class="lp-section-label">CHOOSE YOUR PLAN</div>
        <h2 class="lp-section-title">Our Fiber WiFi Broadband Plans</h2>
        <div class="lp-section-divider"></div>

        <div class="lp-plans-grid">
            @forelse ($services as $index => $service)
                @php
                    $plan_labels = ['BASIC', 'POPULAR', 'PREMIUM', 'FAMILY BUNDLE'];
                    $plan_styles = ['basic', 'popular', 'premium', 'bundle'];
                    $label = $plan_labels[$index % count($plan_labels)];
                    $pstyle = $plan_styles[$index % count($plan_styles)];
                    $popular = ($pstyle === 'popular');
                @endphp
                <div class="lp-plan-card lp-plan-{{ $pstyle }}{{ $popular ? ' lp-plan-featured' : '' }}" id="plan-{{ $service->id }}">
                    <div class="lp-plan-badge">{{ $label }}</div>
                    <div class="lp-plan-icon">
                        @if ($pstyle === 'bundle')
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.2"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"/><polyline points="17 2 12 7 7 2"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.2"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1"/></svg>
                        @endif
                    </div>

                    <div class="lp-plan-speed">{{ $service->service_name }}</div>
                    <div class="lp-plan-type">ULTRA-FAST FIBER WIFI</div>

                    <ul class="lp-plan-features">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            High-Speed Fiber Internet
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            Unlimited Data (No Capping)
                        </li>
                        @if ($service->description)
                            @foreach (array_slice(array_filter(explode("\n", $service->description)), 0, 3) as $dl)
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    {{ trim($dl) }}
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="lp-plan-price">
                        <span class="lp-price-currency">₱</span>{{ number_format($service->price, 0) }}<span class="lp-price-period">/mo</span>
                    </div>

                    @auth('client')
                        <a href="{{ route('client.book', ['service_id' => $service->id]) }}" class="lp-plan-btn" id="book-plan-{{ $service->id }}">
                            Book Now
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="lp-plan-btn" id="book-guest-{{ $service->id }}">
                            Get Started
                        </a>
                    @endauth
                </div>
            @empty
                <div class="lp-no-plans">
                    <p>No active plans available at the moment. Please contact us for more information.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ========== MOBILE DOWNLOAD SECTION ========== -->
<section class="lp-download-section" id="download">
    <div class="container">
        <div class="lp-download-inner">
            <div class="lp-download-copy">
                <div class="lp-section-label">GO MOBILE</div>
                <h2 class="lp-section-title">Download Our Android Application</h2>
                <div class="lp-section-divider" style="margin-left: 0;"></div>
                <p class="lp-section-sub" style="margin-left: 0; text-align: left;">
                    Manage your bookings, view your billing accounts, pay bills, and coordinate technician installations on the go with our official CCTN mobile companion app.
                </p>
                <div class="lp-download-features">
                    <div class="lp-dl-feat-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Real-time Installation Booking</span>
                    </div>
                    <div class="lp-dl-feat-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Billing Status & Payment History</span>
                    </div>
                    <div class="lp-dl-feat-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>24/7 Technician Dispatch Requests</span>
                    </div>
                </div>
                <div style="margin-top: 2rem;">
                    <a href="{{ asset('downloads/cctn-app.apk') }}" class="lp-btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;" download>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Android App (APK)
                    </a>
                </div>
            </div>
            <div class="lp-download-visual">
                <!-- Phone mockup container -->
                <div class="phone-mockup">
                    <div class="phone-screen">
                        <div class="phone-status-bar">
                            <span>9:41 AM</span>
                            <span>⚡ 100%</span>
                        </div>
                        <div class="phone-app-header">
                            <img src="{{ asset('assets/images/cctn-logo.png') }}" alt="CCTN Logo" style="height: 24px; filter: brightness(0) invert(1);">
                            <span style="font-weight: 800; font-size: 0.9rem; color: #fff;">CCTN Mobile</span>
                        </div>
                        <div class="phone-app-body">
                            <div style="background: rgba(220,38,38,0.06); border-radius: 8px; padding: 0.75rem; text-align: center; border: 1px solid rgba(220,38,38,0.12); margin-bottom: 0.75rem;">
                                <strong style="color: #dc2626; font-size: 0.75rem; display: block;">FIBER STATUS</strong>
                                <span style="font-size: 0.7rem; color: #15803d; font-weight: 700;">🟢 Connected (Active)</span>
                            </div>
                            <div class="mock-card">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #0f172a;">Current Plan</span>
                                    <span style="font-size: 0.65rem; font-weight: 800; color: #dc2626; background: rgba(220,38,38,0.08); padding: 2px 6px; border-radius: 20px;">10 Mbps</span>
                                </div>
                                <div style="font-size: 0.65rem; color: #64748b; margin-top: 0.25rem;">Next Payment: Aug 15</div>
                            </div>
                            <div class="mock-card">
                                <span style="font-size: 0.75rem; font-weight: 700; display: block; margin-bottom: 0.35rem; color: #0f172a;">Quick Actions</span>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.35rem;">
                                    <div style="background: #0f172a; color: #fff; text-align: center; padding: 0.35rem; border-radius: 4px; font-size: 0.62rem; font-weight: 700;">Pay Bills</div>
                                    <div style="background: #dc2626; color: #fff; text-align: center; padding: 0.35rem; border-radius: 4px; font-size: 0.62rem; font-weight: 700;">Support</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== TROUBLESHOOT SECTION ========== -->
<section class="lp-trouble-section">
    <div class="container">
        <div class="lp-section-label">NEED HELP?</div>
        <h2 class="lp-section-title">WiFi Troubleshooting &amp; Self-Help Guide</h2>
        <div class="lp-section-divider"></div>
        <p class="lp-section-sub">Experiencing slow speeds or a red LOS light? Try these quick steps before requesting a technician dispatch.</p>

        <div class="lp-trouble-grid">
            <div class="lp-trouble-card" id="trouble-step1">
                <div class="lp-trouble-step">Step 1</div>
                <h3>Modem Power Cycle</h3>
                <p>Unplug your fiber modem's power adapter from the outlet. Wait for exactly <strong>30 seconds</strong> to allow the internal memory to clear, then plug it back in. This forces the device to reconnect and re-authenticate with the central office.</p>
                <div class="lp-trouble-note">⏱ Resolves 80% of speed and connection drops</div>
            </div>
            <div class="lp-trouble-card" id="trouble-step2">
                <div class="lp-trouble-step lp-step-gold">Step 2</div>
                <h3>Check Modem Indicator Lights</h3>
                <p>Look at the front of your modem. If the <strong>LOS light is blinking Red</strong>, it indicates a physical fiber link disruption. If the <strong>PON light is blinking green or off</strong>, the modem is attempting to sync.</p>
                <div class="lp-trouble-note">💡 Red LOS light requires field technician repair</div>
            </div>
            <div class="lp-trouble-card" id="trouble-step3">
                <div class="lp-trouble-step lp-step-green">Step 3</div>
                <h3>Schedule a Technician Dispatch</h3>
                <p>If power cycling does not restore your connection and the LOS light remains red, book a free <strong>WiFi Troubleshooting &amp; Technical Repair Visit</strong> through our client scheduling engine.</p>
                <div class="lp-trouble-action">
                    @auth('client')
                        <a href="{{ route('client.book', ['service_id' => $troubleId]) }}" class="lp-btn-primary" id="cta-book-trouble">Book Troubleshooting Now</a>
                    @else
                        <a href="{{ route('login') }}" class="lp-btn-outline" id="cta-login-trouble">Log In to Book Visit</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CONTACT BANNER ========== -->
<section class="lp-contact-banner">
    <div class="container">
        <div class="lp-contact-inner">
            <div>
                <h3 class="lp-contact-title">CINE CEBU BANTAYAN ISLAND OFFICE</h3>
                <p class="lp-contact-info">
                    <strong>Location:</strong> Juana Osmenia St. Binaobao, Bantayan, Cebu<br>
                    <strong>Office Hours:</strong> 8:00 AM – 5:00 PM (Monday – Saturday)
                </p>
            </div>
            <div class="lp-contact-right">
                <div class="lp-contact-label">For Inquiries Contact Us:</div>
                <div class="lp-contact-phone">📞 +63 999 998 8209</div>
                <div class="lp-contact-fb">Facebook: <a href="https://facebook.com/CineCebuBantayan" target="_blank" rel="noopener">Cine Cebu Bantayan Island</a></div>
            </div>
        </div>
    </div>
</section>
@endsection
