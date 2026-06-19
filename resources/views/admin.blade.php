<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - HC TGM Snooker Club</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{colors:{background:'#0a0a0a',surface:'#171717','surface-container-low':'#1c1c1c','surface-container-high':'#262626',primary:'#dc2626','outline-variant':'#404040'}}}}</script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body{background:#0a0a0a;color:white;}
    .baize{background:linear-gradient(135deg,#166534,#14532d);}
    .hidden{display:none!important;}
    .tab-btn.active{background:#dc2626;color:white;}
    input,select,textarea{background:#171717;border:1px solid #404040;color:white;padding:8px 12px;border-radius:8px;width:100%;outline:none;}
    input:focus,select:focus,textarea:focus{border-color:#dc2626;}
    table{width:100%;border-collapse:collapse;}
    th{background:#1c1c1c;padding:12px 16px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.1em;color:#6b7280;}
    td{padding:12px 16px;border-bottom:1px solid #262626;font-size:14px;}
    tr:hover td{background:#1c1c1c;}
    .badge{display:inline-block;padding:2px 8px;border-radius:4px;font-size:10px;font-weight:700;text-transform:uppercase;}
    .badge-pending{background:#422006;color:#fb923c;border:1px solid #9a3412;}
    .badge-confirmed,.badge-approved{background:#052e16;color:#4ade80;border:1px solid #166534;}
    .badge-cancelled,.badge-rejected{background:#3f0621;color:#f87171;border:1px solid #991b1b;}
    .modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:200;display:flex;align-items:center;justify-content:center;padding:16px;}
    .modal-box{background:#1c1c1c;border:1px solid #404040;border-radius:12px;padding:32px;width:100%;max-width:480px;}
    .btn{padding:8px 16px;border-radius:8px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;cursor:pointer;border:none;}
    .btn-red{background:#dc2626;color:white;} .btn-red:hover{background:#b91c1c;}
    .btn-gray{background:#262626;color:white;} .btn-gray:hover{background:#404040;}
    .btn-green{background:#166534;color:white;} .btn-green:hover{background:#14532d;}
    .btn-sm{padding:4px 10px;font-size:11px;}
    .sidebar-link{display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#9ca3af;transition:all .2s;}
    .sidebar-link:hover{background:#262626;color:white;}
    .sidebar-link.active{background:#7f1d1d;color:#fca5a5;}
  </style>
</head>
<body class="flex flex-col min-h-screen">

<!-- NAV -->
<nav class="fixed top-0 w-full z-50 bg-neutral-950/90 backdrop-blur-md border-b border-neutral-900">
  <div class="flex justify-between items-center px-6 md:px-10 py-3 w-full">
    <a href="/" class="flex items-center gap-3">
      <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center border border-red-500/30">
        <span class="text-white font-black text-xl italic">HC</span>
      </div>
      <div>
        <div class="text-white font-black tracking-tighter text-sm leading-none">TGM SNOOKER</div>
        <div class="text-red-600 font-bold tracking-widest text-[9px] uppercase">Admin Panel</div>
      </div>
    </a>
    <div id="nav-links" class="hidden md:flex items-center gap-6"></div>
  </div>
</nav>

<!-- LAYOUT -->
<div class="flex pt-16 min-h-screen">

  <!-- SIDEBAR -->
  <aside class="w-56 bg-neutral-900 border-r border-neutral-800 fixed top-16 bottom-0 left-0 overflow-y-auto p-4 z-40">
    <div id="admin-name" class="text-xs text-neutral-500 uppercase tracking-widest mb-4 px-2">Loading...</div>
    <div class="space-y-1">
      <div class="sidebar-link active" data-tab="dashboard"><i data-lucide="layout-dashboard" class="w-4 h-4"></i>Dashboard</div>
      <div class="sidebar-link" data-tab="bookings"><i data-lucide="calendar-check" class="w-4 h-4"></i>Bookings</div>
      <div class="sidebar-link" data-tab="players"><i data-lucide="users" class="w-4 h-4"></i>Players</div>
      <div class="sidebar-link" data-tab="rankings"><i data-lucide="trophy" class="w-4 h-4"></i>Rankings</div>
      <div class="sidebar-link" data-tab="tournaments"><i data-lucide="flag" class="w-4 h-4"></i>Tournaments</div>
      <div class="sidebar-link" data-tab="merchandise"><i data-lucide="shopping-bag" class="w-4 h-4"></i>Merchandise</div>
      <div class="sidebar-link" data-tab="orders"><i data-lucide="package" class="w-4 h-4"></i>Orders</div>
      <div class="sidebar-link" data-tab="livescores"><i data-lucide="radio" class="w-4 h-4"></i>Live Scores</div>
    </div>
    <div class="mt-8 border-t border-neutral-800 pt-4">
      <a href="/" class="sidebar-link"><i data-lucide="home" class="w-4 h-4"></i>Main Site</a>
      <button id="btn-logout" class="sidebar-link w-full text-left text-red-400 hover:text-red-300"><i data-lucide="log-out" class="w-4 h-4"></i>Logout</button>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="ml-56 flex-1 p-8">

    <!-- DASHBOARD -->
    <section id="tab-dashboard">
      <h1 class="text-3xl font-extrabold text-white mb-2">Dashboard</h1>
      <p class="text-neutral-500 text-sm mb-8">Overview of club activity.</p>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8" id="stat-cards"></div>
    </section>

    <!-- BOOKINGS -->
    <section id="tab-bookings" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Table Bookings</h2>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Customer</th><th>Date</th><th>Time</th><th>Table</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="bookings-body"><tr><td colspan="6" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

    <!-- PLAYERS -->
    <section id="tab-players" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Club Players</h2>
        <button class="btn btn-red" onclick="openPlayerModal()">+ Add Player</button>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Name</th><th>Email</th><th>Level</th><th>Wins</th><th>Played</th><th>Points</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="players-body"><tr><td colspan="7" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

    <!-- RANKINGS -->
    <section id="tab-rankings" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Player Rankings</h2>
        <button class="btn btn-red" onclick="openPlayerModal()">+ Add Player</button>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Rank</th><th>Player</th><th>Level</th><th>Wins</th><th>Points</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="rankings-body"><tr><td colspan="6" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

    <!-- TOURNAMENTS -->
    <section id="tab-tournaments" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Tournament Registrations</h2>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Player</th><th>Tournament</th><th>Membership</th><th>Date</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="tournaments-body"><tr><td colspan="6" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

    <!-- MERCHANDISE -->
    <section id="tab-merchandise" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Merchandise</h2>
        <button class="btn btn-red" onclick="openMerchModal()">+ Add Item</button>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Name</th><th>Description</th><th>Image</th><th>Price</th><th>Stock</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="merch-body"><tr><td colspan="6" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

    <!-- ORDERS -->
    <section id="tab-orders" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Shop Orders</h2>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Customer</th><th>Item</th><th>Qty</th><th>Total</th><th>Date</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="orders-body"><tr><td colspan="7" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

    <!-- LIVE SCORES -->
    <section id="tab-livescores" class="hidden">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Live Scores</h2>
        <div class="flex gap-2">
          <a href="/livescores" target="_blank" class="btn btn-gray text-xs">View Public Page ↗</a>
          <button class="btn btn-red" onclick="openLiveModal()">+ New Match</button>
        </div>
      </div>
      <div class="bg-surface-container-high rounded-xl border border-outline-variant/20 overflow-x-auto">
        <table><thead><tr><th>Match</th><th>Player 1</th><th>Score</th><th>Player 2</th><th>Table</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
        <tbody id="livescores-body"><tr><td colspan="7" class="text-center text-neutral-500 py-8">Loading...</td></tr></tbody></table>
      </div>
    </section>

  </main>

<!-- PLAYER MODAL -->
<div id="player-modal" class="modal-bg hidden">
  <div class="modal-box">
    <h3 id="player-modal-title" class="text-xl font-bold text-white mb-6">Add Player</h3>
    <form id="player-form" class="space-y-4">
      <input type="hidden" id="p-id"/>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Name</label><input id="p-name" required placeholder="Full name"/></div>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Email</label><input id="p-email" type="email" placeholder="email@example.com"/></div>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Level</label>
        <select id="p-level"><option>Beginner</option><option>Intermediate</option><option>Advanced</option><option>Professional</option></select>
      </div>
      <div class="grid grid-cols-3 gap-3">
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Wins</label><input id="p-wins" type="number" min="0" value="0"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Played</label><input id="p-played" type="number" min="0" value="0"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Points</label><input id="p-points" type="number" min="0" value="0"/></div>
      </div>
      <div class="flex gap-3 pt-2">
        <button type="button" class="btn btn-gray flex-1" onclick="closeModal('player-modal')">Cancel</button>
        <button type="submit" id="p-submit" class="btn btn-red flex-1">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- MERCH MODAL -->
<div id="merch-modal" class="modal-bg hidden">
  <div class="modal-box">
    <h3 id="merch-modal-title" class="text-xl font-bold text-white mb-6">Add Merchandise</h3>
    <form id="merch-form" class="space-y-4">
      <input type="hidden" id="m-id"/>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Name</label><input id="m-name" required placeholder="Item name"/></div>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Description</label><textarea id="m-desc" rows="2" placeholder="Description"></textarea></div>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Image URL</label><input id="m-image" placeholder="https://example.com/item.jpg"/></div>
      <div class="grid grid-cols-2 gap-3">
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Price (RM)</label><input id="m-price" type="number" min="0" step="0.01" value="0"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Stock</label><input id="m-stock" type="number" min="0" value="0"/></div>
      </div>
      <div class="flex gap-3 pt-2">
        <button type="button" class="btn btn-gray flex-1" onclick="closeModal('merch-modal')">Cancel</button>
        <button type="submit" class="btn btn-red flex-1">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- LIVE SCORE MODAL -->
<div id="live-modal" class="modal-bg hidden">
  <div class="modal-box" style="max-width:560px;max-height:90vh;overflow-y:auto;">
    <h3 id="live-modal-title" class="text-xl font-bold text-white mb-4">New Match</h3>
    <form id="live-form" class="space-y-3">
      <input type="hidden" id="ls-id"/>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Match Title</label><input id="ls-title" required placeholder="e.g. Quarter Final - Round 1"/></div>
      <div class="grid grid-cols-2 gap-3">
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Player 1</label><input id="ls-p1" required placeholder="Player 1 name"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Player 2</label><input id="ls-p2" required placeholder="Player 2 name"/></div>
      </div>
      <div class="grid grid-cols-4 gap-2">
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">P1 Pts</label><input id="ls-s1" type="number" min="0" value="0"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">P2 Pts</label><input id="ls-s2" type="number" min="0" value="0"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">P1 Frames</label><input id="ls-f1" type="number" min="0" value="0"/></div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">P2 Frames</label><input id="ls-f2" type="number" min="0" value="0"/></div>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Table</label>
          <select id="ls-table"><option>Table 1</option><option>Table 2</option><option>Table 3</option><option>VIP Room</option></select>
        </div>
        <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Status</label>
          <select id="ls-status"><option value="upcoming">Upcoming</option><option value="live">🔴 Live</option><option value="completed">Completed</option></select>
        </div>
      </div>
      <div><label class="text-xs text-neutral-400 uppercase tracking-widest block mb-1">Notes (optional)</label><input id="ls-notes" placeholder="e.g. Best of 9 frames"/></div>
      <div class="flex gap-3 pt-3 border-t border-neutral-700">
        <button type="button" class="btn btn-gray flex-1" onclick="closeModal('live-modal')">Cancel</button>
        <button type="submit" class="btn btn-red flex-1">Save Match</button>
      </div>
    </form>
  </div>
</div>

<script type="module">
import { initNav } from "{!! asset('js/nav.js') !!}";

const user = await initNav('admin');
if (!user || user.role !== 'admin') { window.location.href = '/login'; }
document.getElementById('admin-name').innerText = user?.displayName || 'Admin';
document.getElementById('btn-logout').addEventListener('click', async () => {
  await fetch('api/auth.php?action=logout'); window.location.href = '/login';
});
lucide.createIcons();
</script>

<script>
// Tab navigation
document.querySelectorAll('.sidebar-link[data-tab]').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.sidebar-link').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const tab = btn.dataset.tab;
    document.querySelectorAll('main > section').forEach(s => s.classList.add('hidden'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    if (tab === 'bookings') loadBookings();
    else if (tab === 'players') loadPlayers();
    else if (tab === 'rankings') loadRankings();
    else if (tab === 'tournaments') loadTournaments();
    else if (tab === 'merchandise') loadMerch();
    else if (tab === 'orders') loadOrders();
    else if (tab === 'livescores') loadLiveScores();
    else if (tab === 'dashboard') loadDashboard();
  });
});

function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
window.closeModal = closeModal;

function badge(status) {
  return `<span class="badge badge-${status}">${status}</span>`;
}

function api(url, opts) {
  return fetch(url, opts).then(r => r.json());
}

// DASHBOARD
async function loadDashboard() {
  const [bookings, players, merch, tournaments] = await Promise.all([
    api('api/bookings.php?action=list_all'),
    api('api/players.php?action=list'),
    api('api/merchandise.php?action=list'),
    api('api/tournaments.php?action=list_all')
  ]);
  const stats = [
    { label: 'Total Bookings', value: Array.isArray(bookings) ? bookings.length : 0, icon: 'calendar', color: 'text-blue-400' },
    { label: 'Club Players', value: Array.isArray(players) ? players.length : 0, icon: 'users', color: 'text-green-400' },
    { label: 'Merchandise', value: Array.isArray(merch) ? merch.length : 0, icon: 'shopping-bag', color: 'text-yellow-400' },
    { label: 'Registrations', value: Array.isArray(tournaments) ? tournaments.length : 0, icon: 'flag', color: 'text-red-400' },
  ];
  document.getElementById('stat-cards').innerHTML = stats.map(s => `
    <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-6">
      <div class="${s.color} mb-2"><i data-lucide="${s.icon}" class="w-6 h-6"></i></div>
      <div class="text-3xl font-extrabold text-white">${s.value}</div>
      <div class="text-neutral-500 text-xs uppercase tracking-widest mt-1">${s.label}</div>
    </div>`).join('');
  lucide.createIcons();
}

// BOOKINGS
async function loadBookings() {
  const data = await api('api/bookings.php?action=list_all');
  if (!Array.isArray(data)) return;
  document.getElementById('bookings-body').innerHTML = data.length === 0
    ? '<tr><td colspan="6" class="text-center text-neutral-500 py-8">No bookings found.</td></tr>'
    : data.map(b => `<tr>
      <td><div class="font-bold">${b.name}</div><div class="text-xs text-neutral-500">${b.email||''}</div></td>
      <td>${b.date}</td><td>${b.time}</td><td>${b.tableId}</td>
      <td>${badge(b.status)}</td>
      <td class="text-right">
        ${b.status!=='confirmed'?`<button class="btn btn-green btn-sm mr-1" onclick="updateBooking(${b.id},'confirmed')">Confirm</button>`:''}
        ${b.status!=='cancelled'?`<button class="btn btn-gray btn-sm mr-1" onclick="updateBooking(${b.id},'cancelled')">Cancel</button>`:''}
        <button class="btn btn-sm" style="background:#3f0621;color:#f87171" onclick="deleteBooking(${b.id})">Delete</button>
      </td></tr>`).join('');
}
window.updateBooking = async (id, status) => {
  await api('api/bookings.php?action=update_status', {method:'POST',body:JSON.stringify({id,status})});
  loadBookings();
};
window.deleteBooking = async (id) => {
  if (!confirm('Delete this booking?')) return;
  await api('api/bookings.php?action=delete', {method:'POST',body:JSON.stringify({id})});
  loadBookings();
};

// PLAYERS
async function loadPlayers() {
  const data = await api('api/players.php?action=list');
  if (!Array.isArray(data)) return;
  document.getElementById('players-body').innerHTML = data.length === 0
    ? '<tr><td colspan="7" class="text-center text-neutral-500 py-8">No players found.</td></tr>'
    : data.map(p => `<tr>
      <td class="font-bold">${p.name}</td><td class="text-neutral-400 text-sm">${p.email||'-'}</td>
      <td><span class="badge badge-confirmed">${p.level}</span></td>
      <td>${p.wins}</td><td>${p.tournaments_played}</td><td class="font-bold text-red-400">${Number(p.points).toLocaleString()}</td>
      <td class="text-right">
        <button class="btn btn-gray btn-sm mr-1" onclick='editPlayer(${JSON.stringify(p)})'>Edit</button>
        <button class="btn btn-sm" style="background:#3f0621;color:#f87171" onclick="deletePlayer(${p.id})">Delete</button>
      </td></tr>`).join('');
}
window.openPlayerModal = () => {
  document.getElementById('player-modal-title').innerText = 'Add Player';
  document.getElementById('p-id').value=''; document.getElementById('p-name').value='';
  document.getElementById('p-email').value=''; document.getElementById('p-level').value='Beginner';
  document.getElementById('p-wins').value=0; document.getElementById('p-played').value=0; document.getElementById('p-points').value=0;
  document.getElementById('player-modal').classList.remove('hidden');
};
window.editPlayer = (p) => {
  document.getElementById('player-modal-title').innerText = 'Edit Player';
  document.getElementById('p-id').value=p.id; document.getElementById('p-name').value=p.name;
  document.getElementById('p-email').value=p.email||''; document.getElementById('p-level').value=p.level;
  document.getElementById('p-wins').value=p.wins; document.getElementById('p-played').value=p.tournaments_played; document.getElementById('p-points').value=p.points;
  document.getElementById('player-modal').classList.remove('hidden');
};
window.deletePlayer = async (id) => {
  if (!confirm('Delete this player?')) return;
  await api('api/players.php?action=delete', {method:'POST',body:JSON.stringify({id})});
  loadPlayers(); loadRankings();
};
document.getElementById('player-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('p-id').value;
  const payload = {name:document.getElementById('p-name').value,email:document.getElementById('p-email').value,
    level:document.getElementById('p-level').value,wins:document.getElementById('p-wins').value,
    tournaments_played:document.getElementById('p-played').value,points:document.getElementById('p-points').value};
  if (id) payload.id = id;
  await api(`api/players.php?action=${id?'update':'create'}`, {method:'POST',body:JSON.stringify(payload)});
  closeModal('player-modal'); loadPlayers(); loadRankings();
});

// RANKINGS
async function loadRankings() {
  const data = await api('api/players.php?action=list');
  if (!Array.isArray(data)) return;
  const sorted = [...data].sort((a,b) => b.points - a.points);
  document.getElementById('rankings-body').innerHTML = sorted.length === 0
    ? '<tr><td colspan="6" class="text-center text-neutral-500 py-8">No players found.</td></tr>'
    : sorted.map((p,i) => `<tr>
      <td class="text-2xl font-extrabold text-neutral-600">${String(i+1).padStart(2,'0')}</td>
      <td class="font-bold">${p.name}</td><td><span class="badge badge-confirmed">${p.level}</span></td>
      <td>${p.wins}</td><td class="font-extrabold text-red-400">${Number(p.points).toLocaleString()}</td>
      <td class="text-right"><button class="btn btn-gray btn-sm" onclick='editPlayer(${JSON.stringify(p)})'>Edit</button></td>
    </tr>`).join('');
}

// TOURNAMENTS
async function loadTournaments() {
  const data = await api('api/tournaments.php?action=list_all');
  if (!Array.isArray(data)) return;
  document.getElementById('tournaments-body').innerHTML = data.length === 0
    ? '<tr><td colspan="6" class="text-center text-neutral-500 py-8">No registrations found.</td></tr>'
    : data.map(t => `<tr>
      <td><div class="font-bold">${t.name}</div><div class="text-xs text-neutral-500">${t.email}</div></td>
      <td>${t.tournamentName}</td><td>${t.membershipId||'N/A'}</td>
      <td class="text-xs text-neutral-500">${t.created_at?.split(' ')[0]||''}</td>
      <td>${badge(t.status)}</td>
      <td class="text-right">
        ${t.status!=='approved'?`<button class="btn btn-green btn-sm mr-1" onclick="updateTournament(${t.id},'approved')">Approve</button>`:''}
        ${t.status!=='rejected'?`<button class="btn btn-gray btn-sm mr-1" onclick="updateTournament(${t.id},'rejected')">Reject</button>`:''}
        <button class="btn btn-sm" style="background:#3f0621;color:#f87171" onclick="deleteTournament(${t.id})">Delete</button>
      </td></tr>`).join('');
}
window.updateTournament = async (id, status) => {
  await api('api/tournaments.php?action=update_status', {method:'POST',body:JSON.stringify({id,status})});
  loadTournaments();
};
window.deleteTournament = async (id) => {
  if (!confirm('Delete this registration?')) return;
  await api('api/tournaments.php?action=delete', {method:'POST',body:JSON.stringify({id})});
  loadTournaments();
};

// MERCHANDISE
async function loadMerch() {
  const data = await api('api/merchandise.php?action=list');
  if (!Array.isArray(data)) return;
  document.getElementById('merch-body').innerHTML = data.length === 0
    ? '<tr><td colspan="6" class="text-center text-neutral-500 py-8">No items found.</td></tr>'
    : data.map(m => `<tr>
      <td class="font-bold">${m.name}</td><td class="text-neutral-400 text-sm">${m.description||'-'}</td>
      <td>${m.image_url ? `<img src="${m.image_url}" alt="${m.name}" class="w-14 h-14 object-cover rounded border border-neutral-700"/>` : '<span class="text-neutral-600 text-xs">No image</span>'}</td>
      <td class="font-bold text-green-400">RM ${parseFloat(m.price).toFixed(2)}</td><td>${m.stock}</td>
      <td class="text-right">
        <button class="btn btn-gray btn-sm mr-1" onclick='editMerch(${JSON.stringify(m)})'>Edit</button>
        <button class="btn btn-sm" style="background:#3f0621;color:#f87171" onclick="deleteMerch(${m.id})">Delete</button>
      </td></tr>`).join('');
}
window.openMerchModal = () => {
  document.getElementById('merch-modal-title').innerText = 'Add Item';
  document.getElementById('m-id').value=''; document.getElementById('m-name').value='';
  document.getElementById('m-desc').value=''; document.getElementById('m-image').value=''; document.getElementById('m-price').value=0; document.getElementById('m-stock').value=0;
  document.getElementById('merch-modal').classList.remove('hidden');
};
window.editMerch = (m) => {
  document.getElementById('merch-modal-title').innerText = 'Edit Item';
  document.getElementById('m-id').value=m.id; document.getElementById('m-name').value=m.name;
  document.getElementById('m-desc').value=m.description||''; document.getElementById('m-image').value=m.image_url||''; document.getElementById('m-price').value=m.price; document.getElementById('m-stock').value=m.stock;
  document.getElementById('merch-modal').classList.remove('hidden');
};
window.deleteMerch = async (id) => {
  if (!confirm('Delete this item?')) return;
  await api('api/merchandise.php?action=delete', {method:'POST',body:JSON.stringify({id})});
  loadMerch();
};
document.getElementById('merch-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('m-id').value;
  const payload = {name:document.getElementById('m-name').value,description:document.getElementById('m-desc').value,
    image_url:document.getElementById('m-image').value,price:document.getElementById('m-price').value,stock:document.getElementById('m-stock').value};
  if (id) payload.id = id;
  await api(`api/merchandise.php?action=${id?'update':'create'}`, {method:'POST',body:JSON.stringify(payload)});
  closeModal('merch-modal'); loadMerch();
});

// Load dashboard on start
loadDashboard();

// ORDERS
async function loadOrders() {
  const data = await api('api/orders.php?action=list_all');
  if (!Array.isArray(data)) return;
  const statusColors = {pending:'badge-pending',processing:'badge-pending',completed:'badge-confirmed',cancelled:'badge-cancelled'};
  document.getElementById('orders-body').innerHTML = data.length === 0
    ? '<tr><td colspan="7" class="text-center text-neutral-500 py-8">No orders yet.</td></tr>'
    : data.map(o => `<tr>
      <td><div class="font-bold">${o.user_name}</div><div class="text-xs text-neutral-500">${o.user_email}</div></td>
      <td>${o.merchandise_name}</td>
      <td>${o.quantity}</td>
      <td class="font-bold text-green-400">RM ${parseFloat(o.total).toFixed(2)}</td>
      <td class="text-xs text-neutral-500">${o.created_at?.split(' ')[0]||''}</td>
      <td><span class="badge ${statusColors[o.status]||'badge-pending'}">${o.status}</span></td>
      <td class="text-right">
        <select onchange="updateOrder(${o.id}, this.value)" class="text-xs bg-neutral-800 border border-neutral-700 text-white rounded px-2 py-1 mr-1">
          ${['pending','processing','completed','cancelled'].map(s => `<option value="${s}" ${o.status===s?'selected':''}>${s}</option>`).join('')}
        </select>
        <button class="btn btn-sm" style="background:#3f0621;color:#f87171" onclick="deleteOrder(${o.id})">Del</button>
      </td></tr>`).join('');
}
window.updateOrder = async (id, status) => {
  await api('api/orders.php?action=update_status', {method:'POST',body:JSON.stringify({id,status})});
};
window.deleteOrder = async (id) => {
  if (!confirm('Delete this order?')) return;
  await api('api/orders.php?action=delete', {method:'POST',body:JSON.stringify({id})});
  loadOrders();
};

// LIVE SCORES
async function loadLiveScores() {
  const data = await api('api/livescores.php?action=list');
  if (!Array.isArray(data)) return;
  const statusColors = {live:'badge-pending',upcoming:'','completed':'badge-confirmed'};
  document.getElementById('livescores-body').innerHTML = data.length === 0
    ? '<tr><td colspan="7" class="text-center text-neutral-500 py-8">No matches yet. Click "+ New Match" to add one.</td></tr>'
    : data.map(m => `<tr>
      <td class="font-bold">${m.match_title}</td>
      <td>${m.player1_name}</td>
      <td class="font-extrabold text-center">${m.player1_score} : ${m.player2_score}<br><span class="text-xs text-neutral-500">${m.player1_frames}F - ${m.player2_frames}F</span></td>
      <td>${m.player2_name}</td>
      <td class="text-xs text-neutral-500">${m.table_number}</td>
      <td><span class="badge ${statusColors[m.status]||''}" style="${m.status==='live'?'background:#7f1d1d;color:#fca5a5;border:1px solid #991b1b':m.status==='upcoming'?'background:#1c2a3f;color:#93c5fd;border:1px solid #1d4ed8':''}"> ${m.status}</span></td>
      <td class="text-right">
        <button class="btn btn-gray btn-sm mr-1" onclick='editLive(${JSON.stringify(m)})'>Edit</button>
        <button class="btn btn-sm" style="background:#3f0621;color:#f87171" onclick="deleteLive(${m.id})">Del</button>
      </td></tr>`).join('');
}
window.openLiveModal = () => {
  document.getElementById('live-modal-title').innerText = 'New Match';
  ['ls-id','ls-title','ls-p1','ls-p2','ls-notes'].forEach(id => document.getElementById(id).value='');
  ['ls-s1','ls-s2','ls-f1','ls-f2'].forEach(id => document.getElementById(id).value=0);
  document.getElementById('ls-status').value='upcoming';
  document.getElementById('live-modal').classList.remove('hidden');
};
window.editLive = (m) => {
  document.getElementById('live-modal-title').innerText = 'Edit Match';
  document.getElementById('ls-id').value=m.id;
  document.getElementById('ls-title').value=m.match_title;
  document.getElementById('ls-p1').value=m.player1_name; document.getElementById('ls-p2').value=m.player2_name;
  document.getElementById('ls-s1').value=m.player1_score; document.getElementById('ls-s2').value=m.player2_score;
  document.getElementById('ls-f1').value=m.player1_frames; document.getElementById('ls-f2').value=m.player2_frames;
  document.getElementById('ls-table').value=m.table_number; document.getElementById('ls-status').value=m.status;
  document.getElementById('ls-notes').value=m.notes||'';
  document.getElementById('live-modal').classList.remove('hidden');
};
window.deleteLive = async (id) => {
  if (!confirm('Delete this match?')) return;
  await api('api/livescores.php?action=delete', {method:'POST',body:JSON.stringify({id})});
  loadLiveScores();
};
document.getElementById('live-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('ls-id').value;
  const payload = {
    match_title: document.getElementById('ls-title').value,
    player1_name: document.getElementById('ls-p1').value, player2_name: document.getElementById('ls-p2').value,
    player1_score: document.getElementById('ls-s1').value, player2_score: document.getElementById('ls-s2').value,
    player1_frames: document.getElementById('ls-f1').value, player2_frames: document.getElementById('ls-f2').value,
    table_number: document.getElementById('ls-table').value, status: document.getElementById('ls-status').value,
    notes: document.getElementById('ls-notes').value
  };
  if (id) payload.id = id;
  await api(`api/livescores.php?action=${id?'update':'create'}`, {method:'POST',body:JSON.stringify(payload)});
  closeModal('live-modal'); loadLiveScores();
});
</script>
</body>
</html>
