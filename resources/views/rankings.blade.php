<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Player Ranking - HC TGM Snooker Club</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: { background: '#0a0a0a', surface: '#171717', 'surface-container-low': '#1c1c1c', 'surface-container-high': '#262626', primary: '#dc2626', 'outline-variant': '#404040' } } } }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body{background:#050505;color:white;position:relative;}
    body::before{
      content:"";
      position:fixed;
      inset:0;
      z-index:0;
      pointer-events:none;
      background:
        radial-gradient(70% 70% at 50% 0%, rgba(220,38,38,.42), transparent 58%),
        linear-gradient(155deg, rgba(127,29,29,.42), transparent 32%, rgba(10,10,10,.2) 52%, rgba(220,38,38,.18) 100%),
        linear-gradient(90deg, rgba(255,255,255,.03), transparent 26%, rgba(255,255,255,.02) 74%, transparent),
        #050505;
    }
    body > *{position:relative;z-index:1;}
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
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Leaderboard</p>
        <h1 class="text-4xl font-black uppercase md:text-6xl">Player Ranking</h1>
        <p class="mt-4 max-w-2xl leading-7 text-neutral-400">Ranking is based on tournament wins, season points, match record, and highest break performance.</p>
      </header>

      <section id="ranking-highlights" class="mb-10 grid gap-5 md:grid-cols-3">
        <div class="rounded-lg border border-neutral-800 bg-surface-container-low p-6 text-center text-neutral-500">Loading rankings...</div>
      </section>

      <section class="overflow-hidden rounded-lg border border-neutral-800 bg-surface-container-low">
        <div class="overflow-x-auto">
          <table class="w-full min-w-[780px] border-collapse text-left">
            <thead class="bg-neutral-950 text-xs uppercase tracking-widest text-neutral-500">
              <tr>
                <th class="px-6 py-5">Rank</th>
                <th class="px-6 py-5">Player</th>
                <th class="px-6 py-5 text-center">Tournament Wins</th>
                <th class="px-6 py-5 text-center">Season Points</th>
                <th class="px-6 py-5 text-center">Played</th>
                <th class="px-6 py-5 text-right">Win Rate</th>
              </tr>
            </thead>
            <tbody id="ranking-body" class="divide-y divide-neutral-800">
              <tr><td colspan="6" class="px-6 py-10 text-center text-neutral-500">Loading rankings...</td></tr>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>

  <footer></footer>

  <script type="module">
    import { initNav } from "/js/nav.js";
    import { initFooter } from "/js/footer.js";
    initNav('rankings');
    initFooter();

    const highlights = document.getElementById('ranking-highlights');
    const body = document.getElementById('ranking-body');

    function winRate(player) {
      const played = Number(player.tournaments_played || 0);
      if (!played) return '0%';
      return `${Math.round((Number(player.wins || 0) / played) * 100)}%`;
    }

    function renderRankings(players) {
      const ranked = [...players].sort((a, b) => Number(b.points || 0) - Number(a.points || 0));
      if (!ranked.length) {
        highlights.innerHTML = '<div class="rounded-lg border border-neutral-800 bg-surface-container-low p-6 text-center text-neutral-400 md:col-span-3">No players have been added in admin yet.</div>';
        body.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center text-neutral-500">No ranking data found.</td></tr>';
        lucide.createIcons();
        return;
      }

      const top = ranked[0];
      const mostWins = [...ranked].sort((a, b) => Number(b.wins || 0) - Number(a.wins || 0))[0];
      const mostPlayed = [...ranked].sort((a, b) => Number(b.tournaments_played || 0) - Number(a.tournaments_played || 0))[0];

      highlights.innerHTML = `
        <div class="rounded-lg border border-red-600/40 bg-red-600/10 p-6 text-center">
          <i data-lucide="trophy" class="mx-auto mb-4 h-9 w-9 text-red-500"></i>
          <p class="text-xs font-bold uppercase tracking-widest text-neutral-400">Rank #1</p>
          <h2 class="mt-2 text-3xl font-black">${top.name}</h2>
          <p class="mt-2 text-neutral-400">${Number(top.points || 0).toLocaleString()} points</p>
        </div>
        <div class="rounded-lg border border-neutral-800 bg-surface-container-low p-6 text-center">
          <i data-lucide="medal" class="mx-auto mb-4 h-9 w-9 text-red-500"></i>
          <p class="text-xs font-bold uppercase tracking-widest text-neutral-400">Most Wins</p>
          <h2 class="mt-2 text-3xl font-black">${Number(mostWins.wins || 0)}</h2>
          <p class="mt-2 text-neutral-400">${mostWins.name}</p>
        </div>
        <div class="rounded-lg border border-neutral-800 bg-surface-container-low p-6 text-center">
          <i data-lucide="star" class="mx-auto mb-4 h-9 w-9 text-red-500"></i>
          <p class="text-xs font-bold uppercase tracking-widest text-neutral-400">Most Active</p>
          <h2 class="mt-2 text-3xl font-black">${mostPlayed.name}</h2>
          <p class="mt-2 text-neutral-400">${Number(mostPlayed.tournaments_played || 0)} tournaments played</p>
        </div>
      `;

      body.innerHTML = ranked.map((player, index) => `
        <tr class="hover:bg-neutral-900">
          <td class="px-6 py-5 font-black text-red-500">${index + 1}</td>
          <td class="px-6 py-5 font-bold">${player.name}</td>
          <td class="px-6 py-5 text-center">${Number(player.wins || 0)}</td>
          <td class="px-6 py-5 text-center">${Number(player.points || 0).toLocaleString()}</td>
          <td class="px-6 py-5 text-center">${Number(player.tournaments_played || 0)}</td>
          <td class="px-6 py-5 text-right">${winRate(player)}</td>
        </tr>
      `).join('');

      lucide.createIcons();
    }

    fetch('/api/players.php?action=list')
      .then((response) => response.json())
      .then((players) => renderRankings(Array.isArray(players) ? players : []))
      .catch(() => {
        highlights.innerHTML = '<div class="rounded-lg border border-red-900/40 bg-red-950/20 p-6 text-center text-red-300 md:col-span-3">Unable to load ranking data from admin.</div>';
        body.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center text-red-300">Unable to load rankings.</td></tr>';
      });
  </script>
</body>
</html>
