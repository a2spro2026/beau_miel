<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration — BEAUMIEL')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-app">
    <div class="admin-shell" id="adminShell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-brand">
                <img src="{{ asset('images/logo.svg') }}" alt="" width="42" height="42">
                <div>
                    <strong>BEAUMIEL</strong>
                    <span>Administration</span>
                </div>
            </div>

            <nav class="admin-side-nav" aria-label="Menu latéral">
                <p class="admin-side-label">Principal</p>
                <a href="{{ route('admin.dashboard') }}" class="admin-side-link @yield('nav_dashboard', '')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 13h6V4H4v9Zm10 7h6V4h-6v16ZM4 20h6v-5H4v5Z"/></svg>
                    Tableau de bord
                </a>
                <a href="{{ route('admin.products') }}" class="admin-side-link @yield('nav_products', '')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 8h16v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8Z"/><path d="M8 8V6a4 4 0 0 1 8 0v2"/></svg>
                    Produits
                </a>
                <a href="{{ route('admin.families') }}" class="admin-side-link @yield('nav_families', '')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 7h16v4H4V7Zm0 6h7v7H4v-7Zm9 0h7v7h-7v-7Z"/></svg>
                    Famille produits
                </a>
                <a href="#commandes" class="admin-side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M7 7h14l-1.5 9H8.5L7 7Zm0 0L6 4H3"/><circle cx="10" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/></svg>
                    Commandes
                </a>

                <p class="admin-side-label">Gestion</p>
                <div class="admin-side-group @yield('nav_eboutique', '')" data-side-group>
                    <button type="button" class="admin-side-link admin-side-parent" data-side-toggle aria-expanded="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.5L21 8H7"/></svg>
                        <span>E-Boutique</span>
                        @php($pendingInscriptions = \App\Models\InscriptionRequest::pending()->count())
                        @if ($pendingInscriptions > 0)
                            <span class="admin-side-badge" title="Demandes d’inscription">{{ $pendingInscriptions }}</span>
                        @endif
                        <svg class="admin-side-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div class="admin-side-subnav" hidden>
                        <a href="{{ route('admin.inscriptions') }}" class="admin-side-sublink @yield('nav_inscriptions', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg>
                            Nouveaux Inscrits
                            @if ($pendingInscriptions > 0)
                                <span class="admin-side-badge" title="Demandes d’inscription">{{ $pendingInscriptions }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.eboutique.partners') }}" class="admin-side-sublink @yield('nav_eboutique_partners', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Fiche Partenaire
                        </a>
                        <a href="{{ route('admin.eboutique.products') }}" class="admin-side-sublink @yield('nav_eboutique_products', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 8h16v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8Z"/><path d="M8 8V6a4 4 0 0 1 8 0v2"/></svg>
                            Produits
                        </a>
                        <a href="{{ route('admin.eboutique.sales') }}" class="admin-side-sublink @yield('nav_eboutique_sales', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 19V5"/><path d="M4 19h16"/><path d="m8 15 3-4 3 2 4-6"/></svg>
                            Balance Ventes
                        </a>
                    </div>
                </div>
                <a href="#partenaires" class="admin-side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Partenaires
                </a>
                <a href="#facturation" class="admin-side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z"/><path d="M14 3v6h6M9 13h6M9 17h4"/></svg>
                    Facturation
                </a>

                <p class="admin-side-label">Paramètres</p>
                <div class="admin-side-group @yield('nav_params', '')" data-side-group>
                    <button type="button" class="admin-side-link admin-side-parent" data-side-toggle aria-expanded="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9c.3.6.9 1 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>
                        <span>Paramètres</span>
                        <svg class="admin-side-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div class="admin-side-subnav" hidden>
                        <a href="{{ route('admin.categories') }}" class="admin-side-sublink @yield('nav_category', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 6h6v6H4V6Zm10 0h6v6h-6V6ZM4 16h6v6H4v-6Zm10 0h6v6h-6v-6Z"/></svg>
                            Catégorie
                        </a>
                        <a href="{{ route('admin.settings') }}" class="admin-side-sublink @yield('nav_settings', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M8 20h8M12 4v16"/></svg>
                            Habillage
                        </a>
                        <a href="{{ route('admin.company') }}" class="admin-side-sublink @yield('nav_company', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/></svg>
                            Fiche Société
                        </a>
                        <a href="{{ route('admin.commerciaux') }}" class="admin-side-sublink @yield('nav_commerciaux', '')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 7h18v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="m3 7 3.5-4h11L21 7"/></svg>
                            Commerciaux
                        </a>
                    </div>
                </div>
            </nav>

            <a href="{{ url('/') }}" class="admin-side-store">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/></svg>
                Voir la boutique
            </a>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <button type="button" class="admin-menu-btn" id="adminMenuBtn" aria-label="Ouvrir le menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>

                <div class="admin-topbar-title">
                    <p>Espace {{ $admin['label'] }}</p>
                    <h1>@yield('page_title', 'Tableau de bord')</h1>
                </div>

                <div class="admin-topbar-actions">
                    @php($pendingInscriptionsTop = \App\Models\InscriptionRequest::pending()->count())
                    <a href="{{ route('admin.inscriptions') }}" class="admin-notif {{ $pendingInscriptionsTop > 0 ? 'has-alert' : '' }}" title="Demandes d’inscription">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.9 1.9 0 0 0 3.4 0"/></svg>
                        @if ($pendingInscriptionsTop > 0)
                            <span class="admin-notif-dot">{{ $pendingInscriptionsTop }}</span>
                        @endif
                    </a>
                    <div class="admin-user-chip">
                        <span class="admin-user-avatar" aria-hidden="true">{{ strtoupper(substr($admin['label'], 0, 1)) }}</span>
                        <div>
                            <strong>{{ $admin['label'] }}</strong>
                            <span>{{ $admin['login'] }}</span>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="admin-logout">Déconnexion</button>
                    </form>
                </div>
            </header>

            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" hidden></div>

    <script>
        (() => {
            const shell = document.getElementById('adminShell');
            const btn = document.getElementById('adminMenuBtn');
            const backdrop = document.getElementById('adminSidebarBackdrop');

            const open = () => {
                shell?.classList.add('sidebar-open');
                if (backdrop) backdrop.hidden = false;
            };
            const close = () => {
                shell?.classList.remove('sidebar-open');
                if (backdrop) backdrop.hidden = true;
            };

            btn?.addEventListener('click', () => {
                shell?.classList.contains('sidebar-open') ? close() : open();
            });
            backdrop?.addEventListener('click', close);

            document.querySelectorAll('[data-side-group]').forEach((group) => {
                const toggle = group.querySelector('[data-side-toggle]');
                const subnav = group.querySelector('.admin-side-subnav');
                if (!toggle || !subnav) return;

                const setOpen = (openState) => {
                    group.classList.toggle('is-open', openState);
                    toggle.setAttribute('aria-expanded', openState ? 'true' : 'false');
                    subnav.hidden = !openState;
                };

                if (group.classList.contains('is-open') || group.querySelector('.admin-side-sublink.is-active')) {
                    setOpen(true);
                }

                toggle.addEventListener('click', () => {
                    setOpen(!group.classList.contains('is-open'));
                });
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
