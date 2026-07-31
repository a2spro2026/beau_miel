@extends('layouts.app')

@section('title', 'BEAUMIEL — Le meilleur de la nature')

@section('content')
{{-- ═══════════════ HERO BANNER ═══════════════ --}}
<section class="hero" aria-label="BEAUMIEL — Présentation">
    <div class="hero-media" aria-hidden="true">
        <img src="{{ asset('images/hero.png') }}" alt="" loading="eager">
        <div class="hero-glow"></div>
    </div>
    <div class="hero-veil" aria-hidden="true"></div>
    <div class="hero-stars" aria-hidden="true">
        <span class="star star-1"></span>
        <span class="star star-2"></span>
        <span class="star star-3"></span>
        <span class="star star-4"></span>
        <span class="star star-5"></span>
        <span class="star star-6"></span>
        <span class="star star-7"></span>
        <span class="star star-8"></span>
        <span class="star star-9"></span>
        <span class="star star-10"></span>
        <span class="star star-11"></span>
        <span class="star star-12"></span>
        <span class="star star-13"></span>
        <span class="star star-14"></span>
        <span class="star star-15"></span>
        <span class="star star-16"></span>
        <span class="star star-17"></span>
        <span class="star star-18"></span>
        <span class="star star-a"></span>
        <span class="star star-b"></span>
        <span class="star star-c"></span>
        <span class="star star-d"></span>
        <span class="star star-e"></span>
        <span class="star star-f"></span>
    </div>

    <div class="hero-frame">
        <div class="hero-copy">
            <div class="hero-brand">
                <img src="{{ asset('images/logo.svg') }}" alt="" class="hero-logo" width="72" height="72">
                <div class="hero-brand-text">
                    <p class="hero-brand-name">BEAUMIEL</p>
                    <p class="hero-brand-tag">Miel • Fruits secs • Dattes</p>
                    <span class="hero-brand-rule" aria-hidden="true">
                        <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 1.5 9.2 5.8 13.5 7 9.2 8.2 8 12.5 6.8 8.2 2.5 7l4.3-1.2L8 1.5Z"/></svg>
                    </span>
                </div>
            </div>

            <h1 class="hero-title">
                <span class="hero-title-line">Le meilleur de la nature,</span>
                <span class="hero-title-accent">pour votre bien-être</span>
            </h1>

            <ul class="hero-values" aria-label="Nos engagements">
                <li>
                    <svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M20 34c-6.5-5-11-10.2-11-15.8A6.2 6.2 0 0 1 20 13.5a6.2 6.2 0 0 1 11 4.7C31 23.8 26.5 29 20 34Z"/>
                        <path d="M16 20.5c1.2-2.4 3-4 4-4"/>
                    </svg>
                    <span>100% Naturel</span>
                </li>
                <li>
                    <svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M20 6 30 12v12L20 30 10 24V12L20 6Z"/>
                        <path d="M20 16 30 12M20 16 10 12M20 16v14"/>
                        <path d="m15 19.5 10-5M15 23.5l10-5"/>
                    </svg>
                    <span>Riche en nutriments</span>
                </li>
                <li>
                    <svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M20 33s-10-6.2-10-14a5.5 5.5 0 0 1 10-3.2A5.5 5.5 0 0 1 30 19c0 7.8-10 14-10 14Z"/>
                        <path d="M14.5 20.5h5.5l2-3 2.5 5 2-2H28"/>
                    </svg>
                    <span>Doux &amp; sain pour tous</span>
                </li>
                <li>
                    <svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M20 6.5 31 11.5v8c0 8-5.2 13.2-11 16-5.8-2.8-11-8-11-16v-8L20 6.5Z"/>
                        <path d="m14.5 20.5 4 4 7.5-8.5"/>
                    </svg>
                    <span>Qualité Premium</span>
                </li>
            </ul>

            <a href="#boutique" class="hero-cta">
                Découvrir nos produits
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════ PRODUITS ═══════════════ --}}
<section class="products" id="boutique" aria-labelledby="products-title">
    <div class="container">
        <header class="section-header">
            <div class="section-ornament" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 14.5 9.5 22 12l-7.5 2.5L12 22l-2.5-7.5L2 12l7.5-2.5L12 2Z"/></svg>
            </div>
            <h2 class="section-title" id="products-title">Nos produits</h2>
            <p class="section-subtitle">Des produits naturels sélectionnés avec soin pour votre satisfaction.</p>
        </header>

        <div class="products-grid">
            <a href="#miel" class="product-card">
                <img src="{{ asset('images/products/miel.jpg') }}" alt="Pot de miel naturel" loading="lazy">
                <div class="product-card-shade"></div>
                <div class="product-card-body">
                    <span class="hex-badge" aria-hidden="true">
                        <svg viewBox="0 0 64 64" fill="none">
                            <path d="M32 4L54.5 17V43L32 56L9.5 43V17L32 4Z" stroke="currentColor" stroke-width="2" fill="rgba(197,157,95,0.12)"/>
                            <path d="M24 24h16v18H24V24Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M22 24h20M28 20h8v4h-8V20Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M28 32h8M28 36h8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div class="product-card-footer">
                        <h3 class="product-name">Miel Naturel</h3>
                        <span class="product-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#fruits-secs" class="product-card">
                <img src="{{ asset('images/products/fruits-secs.jpg') }}" alt="Assortiment de fruits secs" loading="lazy">
                <div class="product-card-shade"></div>
                <div class="product-card-body">
                    <span class="hex-badge" aria-hidden="true">
                        <svg viewBox="0 0 64 64" fill="none">
                            <path d="M32 4L54.5 17V43L32 56L9.5 43V17L32 4Z" stroke="currentColor" stroke-width="2" fill="rgba(197,157,95,0.12)"/>
                            <path d="M32 42c-6-5-10-10-10-15a6 6 0 0 1 10-4.2A6 6 0 0 1 42 27c0 5-4 10-10 15Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M28 26c1-2 2.5-3.5 4-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div class="product-card-footer">
                        <h3 class="product-name">Fruits Secs</h3>
                        <span class="product-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#dattes" class="product-card">
                <img src="{{ asset('images/products/dattes.jpg') }}" alt="Bol de dattes premium" loading="lazy">
                <div class="product-card-shade"></div>
                <div class="product-card-body">
                    <span class="hex-badge" aria-hidden="true">
                        <svg viewBox="0 0 64 64" fill="none">
                            <path d="M32 4L54.5 17V43L32 56L9.5 43V17L32 4Z" stroke="currentColor" stroke-width="2" fill="rgba(197,157,95,0.12)"/>
                            <path d="M32 44V28" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M32 30c-6-2-10-7-10-12 4 1 8 4 10 8 2-4 6-7 10-8 0 5-4 10-10 12Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M26 42h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div class="product-card-footer">
                        <h3 class="product-name">Dattes</h3>
                        <span class="product-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection
