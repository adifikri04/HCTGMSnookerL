<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tournaments - HC TGM Snooker Club</title>
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
        linear-gradient(135deg, rgba(127,29,29,.22) 0%, transparent 28%, transparent 72%, rgba(220,38,38,.1) 100%),
        radial-gradient(120% 85% at 88% 12%, rgba(220,38,38,.16), transparent 52%),
        radial-gradient(90% 70% at 8% 88%, rgba(127,29,29,.14), transparent 58%),
        linear-gradient(180deg, rgba(255,255,255,.025), transparent 30%, rgba(255,255,255,.015) 100%),
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
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Club Competition</p>
        <h1 class="text-4xl font-black uppercase md:text-6xl">Tournament Information</h1>
      </header>

      <section class="mb-16">
        <div class="mb-6 flex items-center gap-4">
          <h2 class="text-2xl font-black uppercase">Ongoing Tournament</h2>
          <span class="rounded-full border border-red-600/40 bg-red-600/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-red-400">Live</span>
        </div>
        <div class="overflow-hidden rounded-lg border border-neutral-800 bg-surface-container-low">
          <div class="grid gap-0 lg:grid-cols-[.9fr_1.1fr]">
            <div class="p-8 md:p-10">
              <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">June Club Championship</p>
              <h3 class="mb-4 text-3xl font-black">Quarter Final Stage</h3>
              <p class="mb-8 leading-7 text-neutral-400">The top sixteen players are fighting for the monthly title. Matches are played race-to-5, alternate break, with live table updates at the club desk.</p>
              <div class="grid grid-cols-3 gap-4 border-t border-neutral-800 pt-6 text-center">
                <div><div class="text-2xl font-black">16</div><div class="text-xs uppercase tracking-widest text-neutral-500">Players</div></div>
                <div><div class="text-2xl font-black">5</div><div class="text-xs uppercase tracking-widest text-neutral-500">Frames</div></div>
                <div><div class="text-2xl font-black">RM800</div><div class="text-xs uppercase tracking-widest text-neutral-500">Prize</div></div>
              </div>
            </div>
            <div class="bg-neutral-950 p-8 md:p-10">
              <h4 class="mb-5 text-sm font-bold uppercase tracking-widest text-neutral-400">Tournament Table</h4>
              <div class="space-y-3">
                <div class="flex items-center justify-between rounded-md border border-neutral-800 bg-neutral-900 p-4"><span>Aiman Rahman</span><span class="font-black text-red-500">5 - 3</span><span>Brian Lee</span></div>
                <div class="flex items-center justify-between rounded-md border border-neutral-800 bg-neutral-900 p-4"><span>Chen Wei</span><span class="font-black text-red-500">4 - 5</span><span>Danish Hakim</span></div>
                <div class="flex items-center justify-between rounded-md border border-neutral-800 bg-neutral-900 p-4"><span>Farid Osman</span><span class="font-black text-red-500">Tonight</span><span>Haziq Noor</span></div>
                <div class="flex items-center justify-between rounded-md border border-neutral-800 bg-neutral-900 p-4"><span>Marcus Chen</span><span class="font-black text-red-500">Tonight</span><span>Raj Kumar</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section>
        <h2 class="mb-6 text-2xl font-black uppercase">Incoming Tournament</h2>
        <div class="grid gap-6 md:grid-cols-3">
          <article class="rounded-lg border border-neutral-800 bg-surface-container-low p-6">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">July 12, 2026</p>
            <h3 class="mb-3 text-2xl font-black">Red Ball Open</h3>
            <p class="mb-6 text-sm leading-6 text-neutral-400">Open singles tournament for all members. Race-to-3 until semi-final.</p>
            <button class="btn-register rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500" data-tournament="Red Ball Open">Register</button>
          </article>
          <article class="rounded-lg border border-neutral-800 bg-surface-container-low p-6">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">August 3, 2026</p>
            <h3 class="mb-3 text-2xl font-black">Doubles Challenge</h3>
            <p class="mb-6 text-sm leading-6 text-neutral-400">Partner format with handicaps, alternate shots, and one-night finals.</p>
            <button class="btn-register rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500" data-tournament="Doubles Challenge">Register</button>
          </article>
          <article class="rounded-lg border border-neutral-800 bg-surface-container-low p-6">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">September 19, 2026</p>
            <h3 class="mb-3 text-2xl font-black">Black Cup Masters</h3>
            <p class="mb-6 text-sm leading-6 text-neutral-400">Top-ranked invitational event with ranking points and club trophy.</p>
            <button class="btn-register rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500" data-tournament="Black Cup Masters">Register</button>
          </article>
        </div>
      </section>
    </div>
  </main>

  <div id="register-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/85 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-lg border border-neutral-700 bg-surface-container-high p-7 shadow-2xl">
      <div class="mb-6 flex items-start justify-between gap-4">
        <div>
          <p class="text-xs font-bold uppercase tracking-widest text-red-500">Tournament Registration</p>
          <h3 id="modal-title" class="mt-2 text-2xl font-black"></h3>
        </div>
        <button id="close-modal" class="text-neutral-400 hover:text-white"><i data-lucide="x"></i></button>
      </div>
      <form id="register-form" class="space-y-4">
        <input id="reg-name" required class="w-full rounded-md border border-neutral-700 bg-neutral-950 p-3 text-sm outline-none focus:border-red-600" placeholder="Full name" />
        <input id="reg-email" required type="email" class="w-full rounded-md border border-neutral-700 bg-neutral-950 p-3 text-sm outline-none focus:border-red-600" placeholder="Email address" />
        <input id="reg-membership" class="w-full rounded-md border border-neutral-700 bg-neutral-950 p-3 text-sm outline-none focus:border-red-600" placeholder="Membership ID or phone number" />
        <select id="reg-level" class="w-full rounded-md border border-neutral-700 bg-neutral-950 p-3 text-sm outline-none focus:border-red-600">
          <option>Beginner</option>
          <option>Intermediate</option>
          <option>Advanced</option>
          <option>Professional</option>
        </select>
        <div id="error-msg" class="hidden rounded-md border border-red-500/40 bg-red-900/20 p-3 text-sm text-red-300"></div>
        <div id="success-msg" class="hidden rounded-md border border-green-500/40 bg-green-900/20 p-3 text-sm text-green-300">Registration received. The club will contact you soon.</div>
        <button class="w-full rounded-md bg-red-600 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500">Submit Registration</button>
      </form>
    </div>
  </div>

  <footer></footer>

  <script type="module">
    import { initNav } from '/js/nav.js';
    import { initFooter } from '/js/footer.js';
    const user = await initNav('tournaments');
    initFooter();

    const modal = document.getElementById('register-modal');
    const modalTitle = document.getElementById('modal-title');
    const success = document.getElementById('success-msg');
    const error = document.getElementById('error-msg');
    let selectedTournament = '';

    document.querySelectorAll('.btn-register').forEach((button) => {
      button.addEventListener('click', () => {
        if (!user) {
          window.location.href = '/login';
          return;
        }
        selectedTournament = button.dataset.tournament;
        modalTitle.textContent = selectedTournament;
        success.classList.add('hidden');
        error.classList.add('hidden');
        document.getElementById('register-form').reset();
        document.getElementById('reg-name').value = user.displayName || '';
        document.getElementById('reg-email').value = user.email || '';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      });
    });

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

    document.getElementById('register-form').addEventListener('submit', async (event) => {
      event.preventDefault();
      success.classList.add('hidden');
      error.classList.add('hidden');

      try {
        const response = await fetch('/api/tournaments.php?action=register', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            tournamentName: selectedTournament,
            name: document.getElementById('reg-name').value,
            email: document.getElementById('reg-email').value,
            membershipId: document.getElementById('reg-membership').value || document.getElementById('reg-level').value
          })
        });
        const result = await response.json();
        if (result.error) throw new Error(result.error);
        success.classList.remove('hidden');
      } catch (err) {
        error.textContent = err.message || 'Unable to submit registration.';
        error.classList.remove('hidden');
      }
    });

    lucide.createIcons();
  </script>
</body>
</html>
