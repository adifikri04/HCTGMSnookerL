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
        <div class="overflow-hidden rounded-lg border border-neutral-800 bg-surface-container-low" id="ongoing-tournament-container">
          <div class="p-8 md:p-10 text-center text-neutral-500">Loading ongoing tournament...</div>
        </div>
      </section>

      <section>
        <h2 class="mb-6 text-2xl font-black uppercase">Incoming Tournament</h2>
        <div id="incoming-tournaments" class="grid gap-6 md:grid-cols-3">
          <!-- Dynamically populated via JS -->
          <article class="col-span-3 text-center py-8 text-neutral-500">Loading tournaments...</article>
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
    import { initNav } from "/js/nav.js";
    import { initFooter } from "/js/footer.js";
    const user = await initNav('tournaments');
    initFooter();

    const modal = document.getElementById('register-modal');
    const modalTitle = document.getElementById('modal-title');
    const success = document.getElementById('success-msg');
    const error = document.getElementById('error-msg');
    let selectedTournament = '';

    function attachRegisterListeners() {
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
    }

    async function loadIncomingTournaments() {
      const container = document.getElementById('incoming-tournaments');
      try {
        const response = await fetch('/api/club_tournaments.php?action=list');
        const data = await response.json();
        
        let html = '';
        for (let i = 0; i < 3; i++) {
          if (data[i]) {
            html += `
              <article class="rounded-lg border border-neutral-800 bg-surface-container-low p-6 flex flex-col">
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">${data[i].date}</p>
                <h3 class="mb-3 text-2xl font-black">${data[i].title}</h3>
                <p class="mb-6 text-sm leading-6 text-neutral-400 flex-grow">${data[i].description}</p>
                <button class="btn-register rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-500 mt-auto" data-tournament="${data[i].title}">Register</button>
              </article>
            `;
          } else {
            html += `
              <article class="rounded-lg border border-neutral-800 bg-surface-container-low p-6 flex flex-col justify-center items-center opacity-50 min-h-[240px]">
                <div class="text-4xl mb-4 text-neutral-700"><i data-lucide="clock" class="w-12 h-12"></i></div>
                <h3 class="text-xl font-black text-neutral-500 uppercase tracking-widest">Coming Soon</h3>
              </article>
            `;
          }
        }
        container.innerHTML = html;
        lucide.createIcons();
        attachRegisterListeners();
      } catch (err) {
        console.error('Failed to load tournaments', err);
        container.innerHTML = '<article class="col-span-3 text-center py-8 text-red-500">Failed to load tournaments.</article>';
      }
    }
    
    async function loadOngoingTournament() {
      const container = document.getElementById('ongoing-tournament-container');
      try {
        const [infoRes, matchesRes] = await Promise.all([
          fetch('/api/ongoing_tournament.php?action=get'),
          fetch('/api/livescores.php?action=list')
        ]);
        const info = await infoRes.json();
        const matches = await matchesRes.json();
        
        let matchesHtml = '';
        if (Array.isArray(matches) && matches.length > 0) {
          matchesHtml = matches.map(m => {
            let scoreText = 'Upcoming';
            let scoreClass = 'text-neutral-500';
            if (m.status === 'live' || m.status === 'completed') {
              scoreText = `${m.player1_frames} - ${m.player2_frames}`;
              scoreClass = 'text-red-500';
            } else if (m.status === 'upcoming') {
              scoreText = 'Tonight';
              scoreClass = 'text-red-500';
            }
            return `<div class="flex items-center justify-between rounded-md border border-neutral-800 bg-neutral-900 p-3 md:p-4 text-sm md:text-base"><span class="truncate max-w-[30%]">${m.player1_name}</span><span class="font-black whitespace-nowrap ${scoreClass}">${scoreText}</span><span class="truncate max-w-[30%] text-right">${m.player2_name}</span></div>`;
          }).join('');
        } else {
          matchesHtml = '<div class="text-neutral-500 text-sm">No matches scheduled.</div>';
        }

        if (info) {
          container.innerHTML = `
            <div class="grid gap-0 lg:grid-cols-[.9fr_1.1fr]">
              <div class="p-8 md:p-10 flex flex-col justify-between">
                <div>
                  <p class="mb-3 text-xs font-bold uppercase tracking-widest text-red-500">${info.badge_text}</p>
                  <h3 class="mb-4 text-3xl font-black">${info.title}</h3>
                  <p class="mb-8 leading-7 text-neutral-400">${info.description}</p>
                </div>
                <div class="grid grid-cols-3 gap-2 md:gap-4 border-t border-neutral-800 pt-6 text-center mt-auto">
                  <div><div class="text-lg md:text-2xl font-black">${info.stat1_value}</div><div class="text-[10px] md:text-xs uppercase tracking-widest text-neutral-500">${info.stat1_label}</div></div>
                  <div><div class="text-lg md:text-2xl font-black">${info.stat2_value}</div><div class="text-[10px] md:text-xs uppercase tracking-widest text-neutral-500">${info.stat2_label}</div></div>
                  <div><div class="text-lg md:text-2xl font-black">${info.stat3_value}</div><div class="text-[10px] md:text-xs uppercase tracking-widest text-neutral-500">${info.stat3_label}</div></div>
                </div>
              </div>
              <div class="bg-neutral-950 p-8 md:p-10">
                <h4 class="mb-5 text-sm font-bold uppercase tracking-widest text-neutral-400">Tournament Table</h4>
                <div class="space-y-3">
                  ${matchesHtml}
                </div>
              </div>
            </div>
          `;
        } else {
          container.innerHTML = '<div class="p-8 md:p-10 text-center text-neutral-500">No ongoing tournament info available.</div>';
        }
      } catch (err) {
        console.error('Failed to load ongoing tournament', err);
        container.innerHTML = '<div class="p-8 md:p-10 text-center text-red-500">Failed to load ongoing tournament.</div>';
      }
    }

    loadOngoingTournament();
    loadIncomingTournaments();

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
