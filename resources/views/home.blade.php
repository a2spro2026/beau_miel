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
        <div class="hero-layout">
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

            <aside class="hero-video-panel">
                <div class="hero-video-frame {{ $videoPlayer ? 'has-video' : '' }}">
                    <div class="hero-video-glow" aria-hidden="true"></div>
                    @if ($videoPlayer && in_array($videoPlayer['type'], ['youtube', 'vimeo'], true))
                        <iframe
                            class="hero-video-embed"
                            src="{{ $videoPlayer['src'] }}"
                            title="{{ $settings['titre'] }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                        ></iframe>
                    @else
                        <video
                            class="hero-video"
                            id="heroVideo"
                            controls
                            playsinline
                            preload="metadata"
                            poster="{{ $habillageSrc }}"
                            @if ($videoPlayer) src="{{ $videoPlayer['src'] }}" @endif
                        >
                        </video>
                    @endif
                    <div class="hero-video-placeholder" aria-label="{{ $settings['titre'] }}" style="--habillage: url('{{ $habillageSrc }}')">
                        <span class="hero-video-play" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l11-6.5L8 5.5Z"/></svg>
                        </span>
                        <span class="hero-video-caption">
                            <strong>{{ $settings['titre'] }}</strong>
                            <em>{{ $settings['description'] }}</em>
                        </span>
                    </div>
                </div>
            </aside>
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
            <p class="section-subtitle">Cliquez sur une photo pour voir les autres produits de la même catégorie.</p>
        </header>

        <div class="products-grid">
            @forelse ($products as $product)
                <a
                    href="{{ route('shop.product', $product) }}"
                    class="product-card product-card-btn {{ $product->isAvailable() ? 'is-dispo' : 'is-rupture' }}"
                    aria-label="Voir {{ $product->titre }}"
                >
                    <img src="{{ $product->photoUrl() }}" alt="{{ $product->titre }}" loading="lazy">
                    <div class="product-card-shade"></div>
                    <span class="product-stock-badge {{ $product->isAvailable() ? 'badge-dispo' : 'badge-rupture' }}">{{ $product->stockLabel() }}</span>
                    @if ($whatsappUrl)
                        <span
                            class="product-whatsapp"
                            role="link"
                            tabindex="0"
                            title="WhatsApp {{ $whatsappDisplay }}"
                            aria-label="WhatsApp {{ $whatsappDisplay }}"
                            data-wa="{{ $whatsappUrl }}"
                            onclick="event.preventDefault(); event.stopPropagation(); window.open(this.dataset.wa, '_blank', 'noopener,noreferrer');"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M17.5 14.4c-.3-.1-1.6-.8-1.8-.9-.2-.1-.4-.1-.6.1-.2.3-.7.9-.8 1-.2.1-.3.2-.6.1-.3-.1-1.2-.4-2.3-1.5-1-.9-1.5-2-1.7-2.3-.2-.3 0-.4.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5 0-.1-.6-1.5-.8-2-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.3-.9.9-.9 2.1s.9 2.4 1 2.6c.1.2 1.8 2.8 4.4 3.9 1.6.7 2.1.7 2.8.6.4-.1 1.6-.6 1.8-1.3.2-.6.2-1.2.1-1.3-.1-.1-.3-.2-.6-.3ZM12.1 21.9h-.1c-1.8 0-3.6-.5-5.1-1.4l-.4-.2-3.8 1 1-3.7-.2-.4A9.9 9.9 0 0 1 2 12C2 6.5 6.5 2 12 2s10 4.5 10 10-4.5 9.9-9.9 9.9Zm0-17.9C7.6 4 4 7.6 4 12c0 1.6.4 3.1 1.2 4.4l.2.3-.6 2.3 2.4-.6.3.2A7.9 7.9 0 0 0 12 20c4.4 0 8-3.6 8-8s-3.6-8-7.9-8Z"/></svg>
                        </span>
                    @endif
                    <div class="product-card-body">
                        <div class="product-card-footer product-card-footer-rich">
                            <div>
                                <h3 class="product-name">{{ $product->titre }}</h3>
                                @if ($product->designation)
                                    <p class="product-desc">{{ \Illuminate\Support\Str::limit($product->designation, 90) }}</p>
                                @endif
                            </div>
                            <span class="product-arrow" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="products-empty-public">Ajoutez des produits depuis l’administration (Gestion des produits).</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
