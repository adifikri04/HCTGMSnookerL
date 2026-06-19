<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Live Scores - HC TGM Snooker Club</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{colors:{surface:'#171717','surface-container-low':'#1c1c1c','surface-container-high':'#262626',primary:'#dc2626','outline-variant':'#404040'}}}}</script>
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
        linear-gradient(115deg, rgba(220,38,38,.2), transparent 34%, rgba(10,10,10,.14) 58%, rgba(127,29,29,.16) 82%, transparent 100%),
        radial-gradient(120% 60% at 50% -10%, rgba(248,113,113,.14), transparent 60%),
        radial-gradient(90% 80% at 95% 75%, rgba(127,29,29,.12), transparent 58%),
        #050505;
    }
    body > *{position:relative;z-index:1;}
    .hidden{display:none!important;}
    @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.3);}}
    .pulse{animation:pulse-dot 1.2s ease-in-out infinite;}
    @keyframes fadeIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
    .fade-in{animation:fadeIn .4s ease forwards;}
    .score-box{background:linear-gradient(135deg,#1c1c1c,#262626);border:1px solid #404040;border-radius:16px;padding:24px 32px;text-align:center;min-width:100px;}
    .live-badge{display:inline-flex;align-items:center;gap:6px;background:#7f1d1d;color:#fca5a5;border:1px solid #991b1b;padding:3px 12px;border-radius:99px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;}
    .upcoming-badge{background:#1c3057;color:#93c5fd;border:1px solid #1d4ed8;}
    .completed-badge{background:#052e16;color:#86efac;border:1px solid #166534;}
    .match-card{background:#111;border:1px solid #262626;border-radius:20px;overflow:hidden;transition:border-color .3s;}
    .match-card.live{border-color:#991b1b;box-shadow:0 0 40px rgba(153,27,27,.2);}
  </style>
</head>
<body class="flex flex-col min-h-screen">

<nav class="fixed top-0 w-full z-50 bg-neutral-950/90 backdrop-blur-md border-b border-neutral-900">
  <div class="flex justify-between items-center px-6 md:px-12 py-4 w-full">
    <a href="/" class="flex items-center gap-3 group">
      <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center border border-red-500/30 group-hover:scale-105 transition-transform">
        <span class="text-white font-black text-xl italic">HC</span>
      </div>
      <div>
        <div class="text-white font-black tracking-tighter text-sm leading-none">TGM SNOOKER</div>
        <div class="text-red-600 font-bold tracking-widest text-[9px] uppercase">Club Elite</div>
      </div>
    </a>
    <div id="nav-links" class="hidden md:flex items-center gap-6"></div>
  </div>
</nav>

<main class="pt-28 pb-24 px-4 md:px-12 flex-grow">
  <div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-10 flex-wrap gap-4">
      <div>
        <div class="flex items-center gap-3 mb-2">
          <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight uppercase">Live Scores</h1>
          <span id="live-indicator" class="hidden live-badge"><span class="pulse w-2 h-2 rounded-full bg-red-400 inline-block"></span>Live</span>
        </div>
        <p class="text-neutral-500 text-sm">Auto-refreshes every 5 seconds.</p>
      </div>
      <div class="flex items-center gap-2 text-xs text-neutral-600">
        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
        <span id="last-updated">—</span>
      </div>
    </div>

    <!-- Filter tabs -->
    <div class="flex gap-2 mb-8 flex-wrap">
      <button class="filter-btn active px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-red-700 text-white" data-filter="all">All</button>
      <button class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-neutral-900 text-neutral-400 hover:text-white border border-neutral-800" data-filter="live">🔴 Live</button>
      <button class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-neutral-900 text-neutral-400 hover:text-white border border-neutral-800" data-filter="upcoming">Upcoming</button>
      <button class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-neutral-900 text-neutral-400 hover:text-white border border-neutral-800" data-filter="completed">Completed</button>
    </div>

    <!-- Matches -->
    <div id="matches-container" class="space-y-4">
      <div class="text-center text-neutral-500 py-20">
        <i data-lucide="loader" class="w-8 h-8 mx-auto mb-3 animate-spin"></i>Loading matches...
      </div>
    </div>

  </div>
</main>

<footer class="w-full py-8 bg-neutral-900 border-t border-neutral-800/30">
  <div class="flex justify-between items-center px-6 md:px-12">
    <div class="text-sm font-bold text-neutral-400">HC TGM SNOOKER CLUB</div>
    <p class="text-neutral-600 text-xs">© 2024 HC TGM SNOOKER CLUB</p>
  </div>
</footer>

<script type="module">
import { initNav } from "{!! asset('js/nav.js') !!}";
import { initFooter } from "{!! asset('js/footer.js') !!}";
initNav('livescores');
initFooter();
lucide.createIcons();
</script>

<script>
let allMatches = [];
let activeFilter = 'all';

document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => {
      b.classList.remove('bg-red-700','text-white');
      b.classList.add('bg-neutral-900','text-neutral-400','border','border-neutral-800');
    });
    btn.classList.add('bg-red-700','text-white');
    btn.classList.remove('bg-neutral-900','text-neutral-400');
    activeFilter = btn.dataset.filter;
    renderMatches();
  });
});

function renderMatches() {
  const filtered = activeFilter === 'all' ? allMatches : allMatches.filter(m => m.status === activeFilter);
  const container = document.getElementById('matches-container');
  const hasLive = allMatches.some(m => m.status === 'live');
  document.getElementById('live-indicator').classList.toggle('hidden', !hasLive);

  if (filtered.length === 0) {
    container.innerHTML = `<div class="text-center text-neutral-600 py-24">
      <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-4 opacity-30"></i>
      <p class="text-lg font-bold">No ${activeFilter === 'all' ? '' : activeFilter} matches</p>
      <p class="text-sm text-neutral-700 mt-2">Check back soon.</p>
    </div>`;
    lucide.createIcons();
    return;
  }

  container.innerHTML = filtered.map(m => {
    const isLive = m.status === 'live';
    const isCompleted = m.status === 'completed';
    const p1Winning = parseInt(m.player1_frames) > parseInt(m.player2_frames);
    const p2Winning = parseInt(m.player2_frames) > parseInt(m.player1_frames);

    const badgeClass = isLive ? 'live-badge' : isCompleted ? 'live-badge completed-badge' : 'live-badge upcoming-badge';
    const badgeText = isLive ? `<span class="pulse w-2 h-2 rounded-full bg-red-400 inline-block"></span>Live Now` : isCompleted ? '✓ Completed' : '⏳ Upcoming';

    return `<div class="match-card ${isLive ? 'live' : ''} fade-in p-6 md:p-8">
      <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
          <div class="text-xs text-neutral-500 uppercase tracking-widest mb-1">${m.table_number}</div>
          <div class="text-lg font-extrabold text-white">${m.match_title}</div>
        </div>
        <span class="${badgeClass}">${badgeText}</span>
      </div>

      <div class="grid grid-cols-3 gap-4 items-center">
        <!-- Player 1 -->
        <div class="text-center">
          <div class="text-xl md:text-2xl font-extrabold text-white mb-1 ${p1Winning && !isCompleted?'text-red-400':''}">${m.player1_name}</div>
          <div class="text-xs text-neutral-600 uppercase tracking-widest">Frames: <span class="text-white font-bold">${m.player1_frames}</span></div>
        </div>

        <!-- Score -->
        <div class="flex items-center justify-center gap-3">
          <div class="score-box">
            <div class="text-4xl md:text-6xl font-black ${p1Winning?'text-red-400':'text-white'}">${m.player1_score}</div>
            <div class="text-[10px] text-neutral-600 uppercase tracking-widest mt-1">Points</div>
          </div>
          <div class="text-2xl font-black text-neutral-700">:</div>
          <div class="score-box">
            <div class="text-4xl md:text-6xl font-black ${p2Winning?'text-red-400':'text-white'}">${m.player2_score}</div>
            <div class="text-[10px] text-neutral-600 uppercase tracking-widest mt-1">Points</div>
          </div>
        </div>

        <!-- Player 2 -->
        <div class="text-center">
          <div class="text-xl md:text-2xl font-extrabold text-white mb-1 ${p2Winning && !isCompleted?'text-red-400':''}">${m.player2_name}</div>
          <div class="text-xs text-neutral-600 uppercase tracking-widest">Frames: <span class="text-white font-bold">${m.player2_frames}</span></div>
        </div>
      </div>

      ${m.notes ? `<div class="mt-5 pt-5 border-t border-neutral-800 text-sm text-neutral-500 flex items-center gap-2"><i data-lucide="message-square" class="w-4 h-4"></i>${m.notes}</div>` : ''}
      <div class="mt-3 text-xs text-neutral-700 text-right">Updated: ${m.updated_at?.replace('T',' ')?.split('.')[0] || m.updated_at || '—'}</div>
    </div>`;
  }).join('');
  lucide.createIcons();
}

async function fetchScores() {
  try {
    const res = await fetch('api/livescores.php?action=list');
    const data = await res.json();
    if (Array.isArray(data)) {
      allMatches = data;
      renderMatches();
      document.getElementById('last-updated').innerText = 'Updated ' + new Date().toLocaleTimeString();
    }
  } catch(e) { console.error(e); }
}

fetchScores();
setInterval(fetchScores, 5000); // auto-refresh every 5 seconds
</script>
</body>
</html>
