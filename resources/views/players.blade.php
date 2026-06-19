<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Player Profiles - HC TGM Snooker Club</title>
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
        radial-gradient(75% 115% at 0% 18%, rgba(220,38,38,.36), transparent 58%),
        radial-gradient(72% 110% at 100% 82%, rgba(127,29,29,.32), transparent 56%),
        linear-gradient(180deg, rgba(255,255,255,.035), transparent 18%, rgba(220,38,38,.08) 52%, transparent 82%),
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
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-red-500">A to Z</p>
        <h1 class="text-4xl font-black uppercase md:text-6xl">Player Profile</h1>
        <p class="mt-4 max-w-2xl leading-7 text-neutral-400">Click any player to view details, tournament wins, playing style, and current form.</p>
      </header>

      <div id="player-list" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3"></div>
    </div>
  </main>

  <div id="player-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/85 p-4 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-lg border border-neutral-700 bg-surface-container-high p-7 shadow-2xl">
      <div class="mb-6 flex items-start justify-between gap-4">
        <div>
          <p id="modal-level" class="text-xs font-bold uppercase tracking-widest text-red-500"></p>
          <h3 id="modal-name" class="mt-2 text-3xl font-black"></h3>
        </div>
        <button id="close-modal" class="text-neutral-400 hover:text-white"><i data-lucide="x"></i></button>
      </div>
      <p id="modal-bio" class="mb-6 leading-7 text-neutral-300"></p>
      <div class="grid grid-cols-3 gap-3 border-y border-neutral-800 py-5 text-center">
        <div><div id="modal-rank" class="text-2xl font-black"></div><div class="text-xs uppercase tracking-widest text-neutral-500">Rank</div></div>
        <div><div id="modal-wins" class="text-2xl font-black"></div><div class="text-xs uppercase tracking-widest text-neutral-500">Wins</div></div>
        <div><div id="modal-break" class="text-2xl font-black"></div><div class="text-xs uppercase tracking-widest text-neutral-500">Win Rate</div></div>
      </div>
      <div class="mt-6 rounded-md bg-neutral-950 p-4">
        <p class="mb-2 text-xs font-bold uppercase tracking-widest text-neutral-500">Best Achievement</p>
        <p id="modal-achievement" class="text-sm text-neutral-300"></p>
      </div>
    </div>
  </div>

  <footer></footer>

  <script type="module">
    import { initNav } from "{!! asset('js/nav.js') !!}";
    import { initFooter } from "{!! asset('js/footer.js') !!}";
    initNav('players');
    initFooter();

    const list = document.getElementById('player-list');
    list.innerHTML = '<div class="col-span-full py-12 text-center text-neutral-500">Loading players...</div>';

    const modal = document.getElementById('player-modal');

    function winRate(player) {
      const played = Number(player.tournaments_played || 0);
      if (!played) return '0%';
      return `${Math.round((Number(player.wins || 0) / played) * 100)}%`;
    }

    function renderPlayers(players) {
      const alphabetical = [...players].sort((a, b) => a.name.localeCompare(b.name));
      if (!alphabetical.length) {
        list.innerHTML = '<div class="col-span-full rounded-lg border border-neutral-800 bg-surface-container-low p-8 text-center text-neutral-400">No players have been added in admin yet.</div>';
        return;
      }

      const ranked = [...players].sort((a, b) => Number(b.points || 0) - Number(a.points || 0));
      list.innerHTML = alphabetical.map((player, index) => {
        const rank = ranked.findIndex((item) => Number(item.id) === Number(player.id)) + 1;
        const initials = player.name
          .split(' ')
          .map((part) => part[0])
          .join('')
          .slice(0, 2)
          .toUpperCase();
        return `
          <button class="player-card flex min-h-32 items-stretch overflow-hidden rounded-lg border border-neutral-800 bg-surface-container-low text-left transition hover:border-red-600/60 hover:bg-neutral-900" data-index="${index}">
            <div class="flex aspect-square w-32 shrink-0 items-center justify-center bg-gradient-to-br from-red-700 via-neutral-900 to-black text-3xl font-black text-white md:w-36">
              ${initials}
            </div>
            <div class="flex flex-1 flex-col justify-center p-5">
              <div class="mb-3 flex items-center justify-between gap-3">
                <p class="text-xs font-bold uppercase tracking-widest text-red-500">${player.level || 'Beginner'}</p>
                <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Rank #${rank || '-'}</span>
              </div>
              <h2 class="mb-2 text-2xl font-black">${player.name}</h2>
              <p class="text-sm text-neutral-500">${Number(player.wins || 0)} wins · ${Number(player.points || 0).toLocaleString()} points</p>
            </div>
          </button>
        `;
      }).join('');

      document.querySelectorAll('.player-card').forEach((card) => {
        card.addEventListener('click', () => {
          const player = alphabetical[Number(card.dataset.index)];
          const rank = ranked.findIndex((item) => Number(item.id) === Number(player.id)) + 1;
        document.getElementById('modal-level').textContent = player.level;
        document.getElementById('modal-name').textContent = player.name;
        document.getElementById('modal-bio').textContent = `${player.name} is registered in the admin player list as a ${player.level || 'Beginner'} player with ${Number(player.tournaments_played || 0)} tournament appearances.`;
        document.getElementById('modal-rank').textContent = `#${rank || '-'}`;
        document.getElementById('modal-wins').textContent = Number(player.wins || 0);
        document.getElementById('modal-break').textContent = winRate(player);
        document.getElementById('modal-achievement').textContent = `${Number(player.points || 0).toLocaleString()} ranking points from the current admin leaderboard.`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        });
      });

      lucide.createIcons();
    }

    fetch('/api/players.php?action=list')
      .then((response) => response.json())
      .then((players) => renderPlayers(Array.isArray(players) ? players : []))
      .catch(() => {
        list.innerHTML = '<div class="col-span-full rounded-lg border border-red-900/40 bg-red-950/20 p-8 text-center text-red-300">Unable to load players from admin data.</div>';
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

    lucide.createIcons();
  </script>
</body>
</html>
