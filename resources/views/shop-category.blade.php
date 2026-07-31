@extends('layouts.app')

@section('title', $product->titre.' — BEAUMIEL')

@section('content')
<section class="family-page" aria-labelledby="shopCategoryTitle">
    <div class="container family-page-inner">
        <header class="family-page-head">
            <a href="{{ url('/#boutique') }}" class="family-back">← Retour boutique</a>
            <div class="family-page-hero">
                <img src="{{ $product->photoUrl() }}" alt="{{ $product->titre }}" class="family-page-cover">
                <div>
                    <p class="section-ornament-text">Catégorie {{ $categoryLabel }}</p>
                    <h1 class="section-title" id="shopCategoryTitle">{{ $product->titre }}</h1>
                    @if ($product->description)
                        <p class="section-subtitle">{{ $product->description }}</p>
                    @else
                        <p class="section-subtitle">Autres produits de la même catégorie.</p>
                    @endif
                </div>
            </div>
        </header>

        <div class="shop-page-body">
            <div class="shop-measures">
                <p class="shop-col-title">Produits de la catégorie</p>
                <div id="shopItemsList" class="shop-items-list">
                    @foreach ($siblings as $item)
                        <article class="shop-item {{ $item->id === $product->id ? 'is-current' : '' }}">
                            <img src="{{ $item->photoUrl() }}" alt="{{ $item->titre }}">
                            <div class="shop-item-info">
                                <strong>{{ $item->titre }}</strong>
                                <span>{{ $item->designation ?: $categoryLabel }}</span>
                                <span class="shop-item-price">{{ number_format((float) $item->prix_vente, 2, '.', '') }}</span>
                            </div>
                            <button
                                type="button"
                                class="shop-cart-btn"
                                data-add="{{ $item->id }}"
                                title="Ajouter au panier"
                                aria-label="Ajouter {{ $item->titre }} au panier"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.5L21 8H7"/></svg>
                            </button>
                        </article>
                    @endforeach
                </div>
            </div>

            <aside class="shop-ticket" aria-label="Ticket commande">
                <p class="shop-col-title">Ticket</p>
                <div id="shopTicketLines" class="shop-ticket-lines">
                    <p class="shop-ticket-empty">Sélectionnez des produits via l’icône panier.</p>
                </div>
                <div class="shop-ticket-totals">
                    <div><span>Sous-total</span><strong id="shopSubtotal">0.00</strong></div>
                    <div><span>Livraison</span><strong id="shopDelivery">0.00</strong></div>
                    <div class="shop-ticket-total"><span>Total</span><strong id="shopTotal">0.00</strong></div>
                </div>
                @if ($whatsappUrl)
                    <a id="shopWhatsappOrder" class="shop-order-btn" href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer">Commander via WhatsApp</a>
                @endif
            </aside>
        </div>
    </div>
</section>

<script>
    (() => {
        const items = @json($items);
        const byId = Object.fromEntries(items.map((i) => [String(i.id), i]));
        const delivery = Number(@json($fraisLivraison ?? 30)) || 0;
        const waBase = @json($whatsappUrl);
        const cart = new Map();

        const ticket = document.getElementById('shopTicketLines');
        const subEl = document.getElementById('shopSubtotal');
        const delEl = document.getElementById('shopDelivery');
        const totEl = document.getElementById('shopTotal');
        const waBtn = document.getElementById('shopWhatsappOrder');
        const money = (n) => Number(n || 0).toFixed(2);

        const renderTicket = () => {
            if (!ticket) return;
            ticket.innerHTML = '';
            let sub = 0;
            cart.forEach((line) => {
                const lineTotal = line.qte * line.prix_u;
                sub += lineTotal;
                const row = document.createElement('div');
                row.className = 'shop-ticket-line';
                row.innerHTML = `
                    <div class="shop-ticket-line-main">
                        <strong>${line.titre}</strong>
                        <span>${line.mesure}</span>
                    </div>
                    <div class="shop-ticket-line-meta">
                        <span>Qté ${line.qte}</span>
                        <span>P/U ${money(line.prix_u)}</span>
                        <span>Sous-tot. ${money(lineTotal)}</span>
                    </div>
                    <div class="shop-ticket-qty">
                        <button type="button" data-dec="${line.id}">−</button>
                        <button type="button" data-inc="${line.id}">+</button>
                        <button type="button" data-rm="${line.id}" class="is-danger">×</button>
                    </div>`;
                ticket.appendChild(row);
            });
            if (cart.size === 0) {
                ticket.innerHTML = '<p class="shop-ticket-empty">Sélectionnez des produits via l’icône panier.</p>';
            }
            const total = sub + (cart.size ? delivery : 0);
            if (subEl) subEl.textContent = money(sub);
            if (delEl) delEl.textContent = money(cart.size ? delivery : 0);
            if (totEl) totEl.textContent = money(total);

            if (waBtn && waBase) {
                let msg = 'Bonjour BEAUMIEL, je souhaite commander :%0A';
                cart.forEach((line) => {
                    msg += `- ${line.titre} (${line.mesure}) x${line.qte} = ${money(line.qte * line.prix_u)}%0A`;
                });
                msg += `%0ASous-total: ${money(sub)}%0ALivraison: ${money(cart.size ? delivery : 0)}%0ATotal: ${money(total)}`;
                waBtn.href = waBase.includes('?') ? `${waBase}&text=${msg}` : `${waBase}?text=${msg}`;
            }
        };

        document.getElementById('shopItemsList')?.addEventListener('click', (e) => {
            const add = e.target.closest('[data-add]');
            if (!add) return;
            const item = byId[add.getAttribute('data-add')];
            if (!item) return;
            const key = String(item.id);
            const current = cart.get(key);
            if (current) current.qte += 1;
            else cart.set(key, { ...item, qte: 1 });
            renderTicket();
        });

        ticket?.addEventListener('click', (e) => {
            const inc = e.target.closest('[data-inc]');
            const dec = e.target.closest('[data-dec]');
            const rm = e.target.closest('[data-rm]');
            if (inc) {
                const line = cart.get(inc.getAttribute('data-inc'));
                if (line) line.qte += 1;
            } else if (dec) {
                const key = dec.getAttribute('data-dec');
                const line = cart.get(key);
                if (line) {
                    line.qte -= 1;
                    if (line.qte <= 0) cart.delete(key);
                }
            } else if (rm) {
                cart.delete(rm.getAttribute('data-rm'));
            } else return;
            renderTicket();
        });
    })();
</script>
@endsection
