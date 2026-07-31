<header class="site-header">
    <div class="container header-shell">
        <div class="header-inner">
            <div class="header-left">
                <a href="{{ url('/') }}" class="brand" aria-label="BEAUMIEL — Accueil">
                    <span class="brand-mark-wrap" aria-hidden="true">
                        <span class="brand-mark-glow"></span>
                        <img src="{{ asset('images/logo.svg') }}" alt="" class="brand-mark" width="40" height="40">
                    </span>
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
                                <span class="nav-label">Accueil</span>
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
                            <a href="#boutique" class="nav-link">
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.5L21 8H7"/></svg>
                                </span>
                                <span class="nav-label">E-Boutique</span>
                            </a>
                        </li>
                        <li>
                            <button type="button" class="nav-link nav-link-login" data-inscription-open aria-label="Se connecter" title="Se connecter">
                                <span class="nav-link-glow" aria-hidden="true"></span>
                                <span class="nav-icon-wrap">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 7.5-2"/><circle cx="12" cy="16" r="1.2" fill="currentColor" stroke="none"/></svg>
                                </span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-actions">
                <a href="#localisation" class="avatar-chip avatar-thumb" aria-label="Localisation">
                    <span class="avatar-ring" aria-hidden="true"></span>
                    <span class="avatar-media">
                        <img src="{{ asset('images/avatar.jpg') }}" alt="">
                    </span>
                    <span class="avatar-meta">
                        <span class="avatar-meta-label">Magasin</span>
                        <span class="avatar-meta-value">Localisation</span>
                    </span>
                </a>
                <a href="#compte" class="avatar-chip avatar-user" aria-label="Mon compte">
                    <span class="avatar-ring" aria-hidden="true"></span>
                    <span class="avatar-media avatar-media-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.5-3.5 4.2-5 8-5s6.5 1.5 8 5"/></svg>
                    </span>
                    <span class="avatar-meta">
                        <span class="avatar-meta-label">Compte</span>
                        <span class="avatar-meta-value">Profil</span>
                    </span>
                </a>
                <button type="button" class="avatar-chip avatar-admin" id="adminNavLink" data-admin-open aria-label="Administration">
                    <span class="avatar-ring" aria-hidden="true"></span>
                    <span class="avatar-media avatar-media-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9c.3.6.9 1 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>
                    </span>
                    <span class="avatar-meta">
                        <span class="avatar-meta-label">Espace</span>
                        <span class="avatar-meta-value">Admin</span>
                    </span>
                </button>
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Ouvrir le menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>
