<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BEAUMIEL — Miel naturel, fruits secs et dattes de qualité premium. Le meilleur de la nature pour votre bien-être.">
    <title>@yield('title', 'BEAUMIEL — Miel • Fruits secs • Dattes')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.admin-modal')

    <script>
        document.getElementById('menuToggle')?.addEventListener('click', () => {
            document.querySelector('.nav-panel')?.classList.toggle('open');
            document.getElementById('navMenu')?.classList.toggle('open');
        });

        (() => {
            const modal = document.getElementById('adminModal');
            const loginInput = document.getElementById('adminLogin');
            const passwordInput = document.getElementById('adminPassword');
            const form = document.getElementById('adminLoginForm');
            const togglePass = document.getElementById('adminTogglePass');

            const credentials = {
                manager: { login: 'admin@beaumiel.com', password: 'password' },
                commercial: { login: 'commercial@beaumiel.com', password: 'password' },
                facturation: { login: 'facturation@beaumiel.com', password: 'password' },
            };

            const openModal = () => {
                if (!modal) return;
                modal.hidden = false;
                requestAnimationFrame(() => modal.classList.add('is-open'));
                document.body.classList.add('admin-modal-open');
                document.querySelector('.nav-panel')?.classList.remove('open');
                document.getElementById('navMenu')?.classList.remove('open');
                const current = form?.querySelector('input[name="statut"]:checked')?.value || 'manager';
                applyStatut(current);
                setTimeout(() => loginInput?.focus(), 180);
            };

            const closeModal = () => {
                if (!modal) return;
                modal.classList.remove('is-open');
                document.body.classList.remove('admin-modal-open');
                setTimeout(() => { modal.hidden = true; }, 280);
            };

            const applyStatut = (statut) => {
                const data = credentials[statut] || { login: '', password: '' };
                if (loginInput) loginInput.value = data.login;
                if (passwordInput) passwordInput.value = data.password;
            };

            document.querySelectorAll('[data-admin-open]').forEach((el) => {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    openModal();
                });
            });

            document.querySelectorAll('[data-admin-close]').forEach((el) => {
                el.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal && !modal.hidden) closeModal();
            });

            document.querySelectorAll('input[name="statut"]').forEach((input) => {
                input.addEventListener('change', () => {
                    if (input.checked) applyStatut(input.value);
                });
            });

            togglePass?.addEventListener('click', () => {
                if (!passwordInput) return;
                const show = passwordInput.type === 'password';
                passwordInput.type = show ? 'text' : 'password';
                togglePass.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
            });

            @if ($errors->has('login') || session('admin_open'))
                openModal();
            @endif
        })();
    </script>
</body>
</html>
