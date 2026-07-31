<header class="site-header">
    <div class="container header-shell">
        <div class="header-inner">
            <div class="header-left">
                <a href="{{ url('/') }}" class="brand" aria-label="BEAUMIEL — Accueil">
                    <img src="{{ asset('images/logo.svg') }}" alt="" class="brand-mark" width="40" height="40">
                    <span class="brand-text">
                        <span class="brand-name">BEAUMIEL</span>
                        <span class="brand-tagline">Miel • Fruits secs • Dattes</span>
                    </span>
                </a>

                <nav class="nav-panel" aria-label="Navigation principale">
                    <ul class="nav-menu" id="navMenu">
                        <li>
                            <a href="{{ url('/') }}" class="nav-link active">
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/></svg>
                                </span>
                                <span class="nav-label">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#partenaires" class="nav-link">
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </span>
                                <span class="nav-label">Partenaires</span>
                            </a>
                        </li>
                        <li>
                            <a href="#commerciaux" class="nav-link">
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 7h18v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="M3 7 6.5 3h11L21 7"/><path d="M9 12h6"/></svg>
                                </span>
                                <span class="nav-label">Commerciaux</span>
                            </a>
                        </li>
                        <li>
                            <a href="#boutique" class="nav-link">
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.5L21 8H7"/></svg>
                                </span>
                                <span class="nav-label">E-Boutique</span>
                            </a>
                        </li>
                        <li>
                            <a href="#administration" class="nav-link" id="adminNavLink" data-admin-open>
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9c.3.6.9 1 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>
                                </span>
                                <span class="nav-label">Administration</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-actions">
                <a href="#localisation" class="avatar-thumb" aria-label="Localisation">
                    <img src="{{ asset('images/avatar.jpg') }}" alt="">
                </a>
                <a href="#compte" class="avatar-user" aria-label="Mon compte">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.5-3.5 4.2-5 8-5s6.5 1.5 8 5"/></svg>
                </a>
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Ouvrir le menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>
