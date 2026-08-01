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
                    <a href="{{ route('download.apk') }}" class="lp-btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;" download>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Android App (APK)
                    </a>
                </div>
            </div>
            <div class="lp-download-visual">
                <!-- Glowing background decoration -->
                <div class="lp-visual-glow-orb"></div>
                <!-- Phone mockup container -->
                <div class="phone-mockup">
                    <!-- Glass Reflection Overlay -->
                    <div class="phone-glare"></div>
                    <!-- Camera Notch (Dynamic Island Style) -->
                    <div class="phone-notch"></div>
                    
                    <div class="phone-screen">
                        <!-- Status Bar -->
                        <div class="phone-status-bar">
                            <span class="phone-time">9:41 AM</span>
                            <span class="phone-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h.01"/><path d="M8.5 16.5a5 5 0 0 1 7 0"/><path d="M5 13a10 10 0 0 1 14 0"/><path d="M1.5 9.5a15 15 0 0 1 21 0"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 6v16h-4V6h4zm-5.5 4v12h-4V10h4zM12 14v8H8v-8h4zM6.5 17v5h-4v-5h4z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="16" height="10" rx="2" ry="2"/><line x1="22" y1="11" x2="22" y2="13"/></svg>
                            </span>
                        </div>
                        <!-- App Header -->
                        <div class="phone-app-header">
                            <img src="{{ asset('assets/images/cctn-logo.png') }}" alt="CCTN Logo" style="height: 20px; filter: brightness(0) invert(1);">
                            <span style="font-weight: 800; font-size: 0.85rem; color: #fff; letter-spacing: 0.5px;">CCTN Mobile</span>
                        </div>
                        <!-- App Body -->
                        <div class="phone-app-body">
                            <!-- Network Status Card -->
                            <div class="mock-status-pill">
                                <span class="pulse-indicator"></span>
                                <span style="font-size: 0.68rem; color: #1e293b; font-weight: 700;">Fiber Connection: Active</span>
                            </div>

                            <!-- Subscription Card -->
                            <div class="mock-card mock-plan-card">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                                    <div>
                                        <span class="mock-label">CURRENT PLAN</span>
                                        <h4 class="mock-plan-title">Standard Fiber</h4>
                                    </div>
                                    <span class="mock-plan-badge">10 Mbps</span>
                                </div>
                                <div class="mock-progress-bar">
                                    <div class="mock-progress-fill" style="width: 78%;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.58rem; color: #64748b; margin-top: 0.25rem;">
                                    <span>Usage: 78 GB / Unlimited</span>
                                    <span style="font-weight: 700; color: #dc2626;">Pay: Aug 15</span>
                                </div>
                            </div>

                            <!-- Quick Action Grid -->
                            <div class="mock-card" style="padding: 0.65rem 0.75rem;">
                                <span class="mock-label" style="display: block; margin-bottom: 0.45rem;">QUICK ACTIONS</span>
                                <div class="mock-actions-grid">
                                    <div class="mock-action-btn action-pay">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"/><line x1="12" y1="17" x2="12" y2="17"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                        <span>Pay Bills</span>
                                    </div>
                                    <div class="mock-action-btn action-support">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                        <span>Support</span>
                                    </div>
                                    <div class="mock-action-btn action-speed">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" y="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                        <span>Speed Test</span>
                                    </div>
                                    <div class="mock-action-btn action-install">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        <span>Bookings</span>
                                    </div>
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
