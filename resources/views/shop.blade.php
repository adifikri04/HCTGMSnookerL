<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Merchandise - HC TGM Snooker Club</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: { background: '#0a0a0a', surface: '#171717', 'surface-container-low': '#1c1c1c', 'surface-container-high': '#262626', primary: '#dc2626', 'outline-variant': '#404040' } } } }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { background:#050505; color:white; position:relative; }
    body::before {
      content:"";
      position:fixed;
      inset:0;
      z-index:0;
      pointer-events:none;
      background:
        linear-gradient(28deg, rgba(220,38,38,.35) 0%, transparent 30%, rgba(255,255,255,.035) 48%, transparent 62%, rgba(127,29,29,.34) 100%),
        radial-gradient(120% 70% at 16% 20%, rgba(127,29,29,.28), transparent 52%),
        radial-gradient(80% 70% at 88% 72%, rgba(220,38,38,.28), transparent 55%),
        #050505;
    }
    body > * { position:relative; z-index:1; }
    .hidden { display:none!important; }
  </style>
</head>
<body class="flex min-h-screen flex-col bg-background text-white">
  <nav class="fixed top-0 z-50 w-full border-b border-neutral-800 bg-neutral-950/90 shadow-2xl shadow-black/50 backdrop-blur-md">
    <div class="flex w-full items-center justify-between gap-6 px-6 py-4 md:px-12">
      <a href="/" class="flex items-center gap-3 group">
        <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-red-500/30 bg-red-600 shadow-lg shadow-red-900/30 transition-transform group-hover:scale-105"><span class="text-xl font-black italic">HC</span></div>
        <div><div class="text-sm font-black leading-none tracking-tight md:text-lg">TGM SNOOKER</div><div class="text-[9px] font-bold uppercase tracking-[0.28em] text-red-600">Club Elite</div></div>
      </a>
      <div id="nav-links" class="hidden items-center gap-5 overflow-x-auto whitespace-nowrap md:gap-8"></div>
    </div>
  </nav>

  <main class="flex-grow px-6 pb-24 pt-32 md:px-12">
    <div class="mx-auto max-w-7xl">
      <header class="mb-12">
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Club Shop</p>
        <h1 class="text-4xl font-black uppercase md:text-6xl">Merchandise</h1>
        <p class="mt-4 max-w-2xl leading-7 text-neutral-400">Official HC TGM Snooker Club merchandise with product photos and details arranged left and right like the main page.</p>
      </header>

      <section id="merch-list" class="space-y-10">
        <div class="rounded-lg border border-neutral-800 bg-surface-container-low p-8 text-center text-neutral-500">Loading merchandise...</div>
      </section>
    </div>
  </main>

  <div id="order-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/85 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-lg border border-neutral-700 bg-surface-container-high p-7 shadow-2xl">
      <div class="mb-6 flex items-start justify-between gap-4">
        <div>
          <p class="text-xs font-bold uppercase tracking-widest text-red-500">Merchandise Order</p>
          <h3 id="modal-item" class="mt-2 text-2xl font-black"></h3>
          <p id="modal-price" class="mt-2 text-red-400 font-bold"></p>
        </div>
        <button id="close-modal" class="text-neutral-400 hover:text-white"><i data-lucide="x"></i></button>
      </div>
      <form id="order-form" class="space-y-4">
        <div id="step-1">
          <label class="text-xs text-neutral-400 uppercase tracking-widest block mb-2">Quantity</label>
          <input id="order-qty" required type="number" min="1" value="1" class="w-full rounded-md border border-neutral-700 bg-neutral-950 p-3 text-sm outline-none focus:border-red-600 mb-4" placeholder="Quantity" />
          <button type="button" id="btn-proceed" class="w-full rounded-md bg-red-600 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500">Proceed to Payment</button>
        </div>
        <div id="step-2" class="hidden text-center">
          <p class="text-sm text-neutral-400 mb-4">Please scan the QR code to complete payment for <span class="text-white font-bold" id="pay-amount"></span>.</p>
          <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="Payment QR" class="w-48 h-48 mx-auto mb-4 bg-white p-2 rounded-lg" />
          <div id="order-error" class="hidden rounded-md border border-red-500/40 bg-red-900/20 p-3 text-sm text-red-300 mb-4 text-left"></div>
          <div id="order-success" class="hidden rounded-md border border-green-500/40 bg-green-900/20 p-3 text-sm text-green-300 mb-4 text-left flex flex-col gap-2">
            <span>Payment received. You can collect your item at the club counter.</span>
            <a href="/profile" class="text-green-400 font-bold underline text-xs">View My Purchases</a>
          </div>
          <button type="submit" id="btn-confirm-payment" class="w-full rounded-md bg-red-600 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500 transition-all">I have paid</button>
          <button type="button" id="btn-back" class="w-full mt-3 text-neutral-400 hover:text-white text-xs font-bold uppercase tracking-widest py-2 transition-colors">Back</button>
        </div>
      </form>
    </div>
  </div>

  <footer></footer>

  <script type="module">
    import { initNav } from "/js/nav.js";
    import { initFooter } from "/js/footer.js";
    const user = await initNav('shop');
    initFooter();

    const merchList = document.getElementById('merch-list');
    const modal = document.getElementById('order-modal');
    const success = document.getElementById('order-success');
    const error = document.getElementById('order-error');
    let selectedItem = null;

    function fallbackImage(index) {
      const images = [
        'https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1519861531473-9200262188bf?auto=format&fit=crop&w=1000&q=80'
      ];
      return images[index % images.length];
    }

    function renderMerch(items) {
      if (!items.length) {
        merchList.innerHTML = '<div class="rounded-lg border border-neutral-800 bg-surface-container-low p-8 text-center text-neutral-400">No merchandise has been added in admin yet.</div>';
        return;
      }

      merchList.innerHTML = items.map((item, index) => {
        const reverse = index % 2 === 1;
        const image = item.image_url || fallbackImage(index);
        const disabled = Number(item.stock || 0) <= 0;
        return `
          <article class="grid overflow-hidden rounded-lg border border-neutral-800 bg-surface-container-low md:grid-cols-2">
            <img src="${image}" alt="${item.name}" class="h-80 w-full object-cover ${reverse ? 'md:order-2' : ''}" />
            <div class="flex flex-col justify-center p-8 md:p-10 ${reverse ? 'md:order-1' : ''}">
              <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">RM ${parseFloat(item.price || 0).toFixed(2)}</p>
              <h2 class="mb-4 text-3xl font-black">${item.name}</h2>
              <p class="mb-4 leading-7 text-neutral-400">${item.description || 'Official HC TGM Snooker Club merchandise.'}</p>
              <p class="mb-6 text-sm text-neutral-500">${disabled ? 'Out of stock' : `${item.stock} in stock`}</p>
              <button class="btn-order w-fit rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500 disabled:cursor-not-allowed disabled:opacity-40" data-id="${item.id}" ${disabled ? 'disabled' : ''}>${disabled ? 'Sold Out' : 'Order Item'}</button>
            </div>
          </article>
        `;
      }).join('');

      document.querySelectorAll('.btn-order').forEach((button) => {
        button.addEventListener('click', () => {
          if (!user) {
            window.location.href = '/login';
            return;
          }
          selectedItem = items.find((item) => Number(item.id) === Number(button.dataset.id));
          document.getElementById('modal-item').textContent = selectedItem.name;
          document.getElementById('modal-price').textContent = `RM ${parseFloat(selectedItem.price || 0).toFixed(2)} each`;
          document.getElementById('order-form').reset();
          document.getElementById('order-qty').max = selectedItem.stock;
          document.getElementById('step-1').classList.remove('hidden');
          document.getElementById('step-2').classList.add('hidden');
          document.getElementById('btn-confirm-payment').classList.remove('hidden');
          document.getElementById('btn-back').classList.remove('hidden');
          success.classList.add('hidden');
          error.classList.add('hidden');
          modal.classList.remove('hidden');
          modal.classList.add('flex');
        });
      });
    }

    document.getElementById('close-modal').addEventListener('click', () => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    });
    modal.addEventListener('click', (event) => {
      if (event.target === modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }
    });
    document.getElementById('btn-proceed').addEventListener('click', () => {
      const qty = parseInt(document.getElementById('order-qty').value);
      if (!qty || qty < 1 || qty > selectedItem.stock) {
        error.textContent = "Invalid quantity.";
        error.classList.remove('hidden');
        document.getElementById('step-1').appendChild(error); // temporarily move error to step 1
        return;
      }
      document.getElementById('step-2').insertBefore(error, document.getElementById('order-success')); // move it back
      error.classList.add('hidden');
      const total = qty * parseFloat(selectedItem.price || 0);
      document.getElementById('pay-amount').textContent = `RM ${total.toFixed(2)}`;
      document.getElementById('step-1').classList.add('hidden');
      document.getElementById('step-2').classList.remove('hidden');
    });

    document.getElementById('btn-back').addEventListener('click', () => {
      document.getElementById('step-2').classList.add('hidden');
      document.getElementById('step-1').classList.remove('hidden');
    });

    document.getElementById('order-form').addEventListener('submit', async (event) => {
      event.preventDefault();
      if (!selectedItem) return;
      
      const btnConfirm = document.getElementById('btn-confirm-payment');
      btnConfirm.disabled = true;
      btnConfirm.textContent = 'Processing...';
      
      success.classList.add('hidden');
      error.classList.add('hidden');

      try {
        const response = await fetch('/api/orders.php?action=buy', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            merchandise_id: selectedItem.id,
            quantity: document.getElementById('order-qty').value
          })
        });
        const result = await response.json();
        if (result.error) throw new Error(result.error);
        
        btnConfirm.classList.add('hidden');
        document.getElementById('btn-back').classList.add('hidden');
        success.classList.remove('hidden');
        
        // Wait 3 seconds, then reload so stock updates
        setTimeout(() => window.location.reload(), 3000);
      } catch (err) {
        error.textContent = err.message || 'Unable to submit order.';
        error.classList.remove('hidden');
        btnConfirm.disabled = false;
        btnConfirm.textContent = 'I have paid';
      }
    });

    fetch('/api/orders.php?action=list')
      .then((response) => response.json())
      .then((items) => renderMerch(Array.isArray(items) ? items : []))
      .catch(() => {
        merchList.innerHTML = '<div class="rounded-lg border border-red-900/40 bg-red-950/20 p-8 text-center text-red-300">Unable to load merchandise from admin data.</div>';
      });

    lucide.createIcons();
  </script>
</body>
</html>
