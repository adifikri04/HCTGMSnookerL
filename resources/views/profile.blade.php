<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile - HC TGM Snooker Club</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            background: '#0a0a0a',
            surface: '#171717',
            'surface-container-low': '#1c1c1c',
            'surface-container-high': '#262626',
            primary: '#dc2626',
            'outline-variant': '#404040'
          },
          fontFamily: {
            headline: ['Inter', 'sans-serif'],
            label: ['Inter', 'sans-serif'],
            body: ['Inter', 'sans-serif']
          }
        }
      }
    }
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
    .baize-gradient { background: linear-gradient(135deg, #166534 0%, #14532d 100%); }
    
  </style>
</head>
<body class="flex flex-col min-h-screen bg-background text-white">

  <nav class="fixed top-0 w-full z-50 bg-neutral-950/80 backdrop-blur-md shadow-2xl shadow-black/50">
    <div class="flex justify-between items-center px-6 md:px-12 py-4 w-full">
      <a href="/" class="flex items-center gap-3 group">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-red-600 rounded-lg flex items-center justify-center shadow-lg shadow-red-900/40 group-hover:scale-105 transition-transform border border-red-500/30">
          <span class="text-white font-black text-xl md:text-2xl font-headline italic">HC</span>
        </div>
        <div class="flex flex-col">
          <span class="text-white font-black tracking-tighter text-sm md:text-lg leading-none font-headline">TGM SNOOKER</span>
          <span class="text-red-600 font-bold tracking-[0.3em] text-[8px] md:text-[10px] leading-none uppercase font-label">Club Elite</span>
        </div>
      </a>
      <div id="nav-links" class="hidden md:flex items-center space-x-8"></div>
    </div>
  </nav>

  <main id="auth-required" class="pt-32 pb-24 min-h-screen flex items-center justify-center px-6 hidden">
    <div class="bg-surface-container-high p-8 md:p-12 rounded-xl max-w-md w-full text-center border border-outline-variant/20 shadow-2xl">
      <h2 class="text-3xl font-headline font-bold text-white mb-4">Login Required</h2>
      <p class="text-neutral-400 mb-8 text-sm">You must be logged in to view your profile.</p>
      <a href="/login" class="block w-full baize-gradient text-white py-4 rounded-lg font-bold uppercase tracking-widest hover:brightness-110 transition-all">
        Sign in
      </a>
    </div>
  </main>

  <main id="profile-content" class="pt-32 pb-24 min-h-screen px-6 md:px-12 hidden">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Profile Section -->
      <div class="lg:col-span-1 space-y-8">
        <div class="bg-surface-container-high p-8 rounded-xl border border-outline-variant/20 shadow-2xl">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-headline font-bold text-white">Profile</h2>
            <button id="btn-edit-profile" class="text-neutral-400 hover:text-white transition-colors">
              <i data-lucide="edit-2" class="w-4 h-4"></i>
            </button>
          </div>

          <form id="edit-profile-form" class="space-y-4 hidden">
            <div>
              <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Display Name</label>
              <input id="edit-displayName" required class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all" type="text" />
            </div>
            <div>
              <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Phone (Optional)</label>
              <input id="edit-phone" class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all" type="tel" />
            </div>
            <div>
              <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Bio (Optional)</label>
              <textarea id="edit-bio" rows="3" class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
              <button type="button" id="btn-cancel-edit" class="flex-1 bg-neutral-800 text-white py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-neutral-700 transition-all">
                Cancel
              </button>
              <button type="submit" id="btn-save-profile" class="flex-1 baize-gradient text-white py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:brightness-110 transition-all">
                Save
              </button>
            </div>
          </form>

          <div id="profile-display" class="space-y-6">
            <div class="flex items-center gap-4">
              <div id="profile-pic-placeholder" class="w-16 h-16 rounded-full bg-neutral-800 border-2 border-neutral-700 flex items-center justify-center text-white font-bold text-xl">S</div>
              <div>
                <h3 id="display-name" class="text-xl font-bold text-white"></h3>
                <p id="display-email" class="text-neutral-400 text-sm"></p>
              </div>
            </div>
            <div id="phone-container" class="hidden">
              <span class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-1">Phone</span>
              <p id="display-phone" class="text-neutral-300 text-sm"></p>
            </div>
            <div id="bio-container" class="hidden">
              <span class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-1">Bio</span>
              <p id="display-bio" class="text-neutral-300 text-sm leading-relaxed"></p>
            </div>
            <div class="pt-6 border-t border-neutral-800">
              <button id="btn-logout" class="flex items-center gap-2 text-red-500 hover:text-red-400 text-xs font-bold uppercase tracking-widest transition-colors">
                <i data-lucide="log-out" class="w-4 h-4"></i> Logout
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Dashboard Sections -->
      <div class="lg:col-span-2 space-y-12">
        
        <!-- Bookings Section -->
        <section>
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-headline font-bold text-white flex items-center gap-3">
              <i data-lucide="calendar" class="w-6 h-6 text-primary"></i>
              My Bookings
            </h2>
          </div>

          <div id="empty-bookings" class="bg-surface-container-high p-8 rounded-xl border border-outline-variant/20 text-center hidden">
            <p class="text-neutral-400 mb-4">You have no table bookings yet.</p>
            <a href="/book" class="inline-block baize-gradient text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-widest hover:brightness-110 transition-all">
              Book a Table
            </a>
          </div>

          <div id="bookings-list" class="grid gap-4">
            <!-- Bookings injected here -->
          </div>
        </section>

        <!-- Tournaments Section -->
        <section>
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-headline font-bold text-white flex items-center gap-3">
              <i data-lucide="trophy" class="w-6 h-6 text-yellow-500"></i>
              My Tournaments
            </h2>
          </div>

          <div id="empty-tournaments" class="bg-surface-container-high p-8 rounded-xl border border-outline-variant/20 text-center hidden">
            <p class="text-neutral-400 mb-4">You haven't registered for any tournaments yet.</p>
            <a href="/tournaments" class="inline-block baize-gradient text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-widest hover:brightness-110 transition-all">
              Browse Tournaments
            </a>
          </div>

          <div id="tournaments-list" class="grid gap-4">
            <!-- Tournaments injected here -->
          </div>
        </section>

        <!-- Purchases Section -->
        <section>
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-headline font-bold text-white flex items-center gap-3">
              <i data-lucide="shopping-bag" class="w-6 h-6 text-primary"></i>
              My Purchases
            </h2>
          </div>

          <div id="empty-purchases" class="bg-surface-container-high p-8 rounded-xl border border-outline-variant/20 text-center hidden">
            <p class="text-neutral-400 mb-4">You haven't purchased any merchandise yet.</p>
            <a href="/shop" class="inline-block baize-gradient text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-widest hover:brightness-110 transition-all">
              Visit Shop
            </a>
          </div>

          <div id="purchases-list" class="grid gap-4">
            <!-- Purchases injected here -->
          </div>
        </section>

      </div>
    </div>
  </main>

  <footer class="w-full py-12 mt-auto bg-neutral-900 border-t border-neutral-800/30">
    <div class="flex flex-col md:flex-row justify-between items-center px-6 md:px-12 gap-8">
      <div class="text-lg font-bold text-neutral-200 font-headline">HC TGM SNOOKER CLUB</div>
      <p class="text-neutral-500 font-body text-xs opacity-60">
        © 2024 HC TGM SNOOKER CLUB. THE ELITE SNOOKER EXPERIENCE.
      </p>
    </div>
  </footer>

  <script type="module">
    import { initNav } from "/js/nav.js";
    import { initFooter } from "/js/footer.js";

    let currentUser = null;

    // Elements
    const authRequiredEl = document.getElementById('auth-required');
    const profileContentEl = document.getElementById('profile-content');
    const profileDisplay = document.getElementById('profile-display');
    const editProfileForm = document.getElementById('edit-profile-form');
    const btnEditProfile = document.getElementById('btn-edit-profile');
    const btnCancelEdit = document.getElementById('btn-cancel-edit');
    const editDisplayName = document.getElementById('edit-displayName');
    const editPhone = document.getElementById('edit-phone');
    const editBio = document.getElementById('edit-bio');
    const btnLogout = document.getElementById('btn-logout');

    btnLogout.addEventListener('click', async () => {
      await fetch('/api/auth.php?action=logout');
      window.location.href = '/login';
    });

    async function checkAuth() {
      const res = await fetch('/api/auth.php?action=session');
      const data = await res.json();
      if (data.user) {
        currentUser = data.user;
        authRequiredEl.classList.add('hidden');
        profileContentEl.classList.remove('hidden');
        loadAllData();
      } else {
        authRequiredEl.classList.remove('hidden');
        profileContentEl.classList.add('hidden');
      }
    }

    async function loadAllData() {
      try {
        const res = await fetch('/api/profile.php');
        const data = await res.json();
        
        if (data.error) {
           console.error(data.error);
           return;
        }

        renderProfile(data.user);
        renderBookings(data.bookings);
        renderTournaments(data.registrations);
        
        try {
          const ordersRes = await fetch('/api/orders.php?action=my_orders');
          const ordersData = await ordersRes.json();
          renderPurchases(ordersData);
        } catch (e) {
          console.error("Error loading orders:", e);
        }
        
      } catch (err) {
        console.error("Error loading profile data:", err);
      }
    }

    function renderProfile(user) {
      document.getElementById('display-name').innerText = user.displayName || 'Snooker Player';
      document.getElementById('display-email').innerText = user.email || '';
      document.getElementById('profile-pic-placeholder').innerText = (user.displayName || 'S')[0].toUpperCase();

      if (user.phone) {
        document.getElementById('display-phone').innerText = user.phone;
        document.getElementById('phone-container').classList.remove('hidden');
      } else {
        document.getElementById('phone-container').classList.add('hidden');
      }

      if (user.bio) {
        document.getElementById('display-bio').innerText = user.bio;
        document.getElementById('bio-container').classList.remove('hidden');
      } else {
        document.getElementById('bio-container').classList.add('hidden');
      }

      editDisplayName.value = user.displayName || '';
      editPhone.value = user.phone || '';
      editBio.value = user.bio || '';
    }

    function renderBookings(bookings) {
      const list = document.getElementById('bookings-list');
      const empty = document.getElementById('empty-bookings');
      
      if (!bookings || bookings.length === 0) {
        list.classList.add('hidden');
        empty.classList.remove('hidden');
        return;
      }

      list.classList.remove('hidden');
      empty.classList.add('hidden');
      list.innerHTML = '';

      bookings.forEach(booking => {
        const div = document.createElement('div');
        div.className = 'bg-surface-container-high p-6 rounded-xl border border-outline-variant/20 flex flex-col md:flex-row md:items-center justify-between gap-6';
        
        let statusClass = 'bg-yellow-900/30 text-yellow-400 border border-yellow-500/30';
        if (booking.status === 'confirmed') statusClass = 'bg-green-900/30 text-green-400 border border-green-500/30';
        if (booking.status === 'cancelled') statusClass = 'bg-red-900/30 text-red-400 border border-red-500/30';

        div.innerHTML = `
          <div class="space-y-2">
            <div class="flex items-center gap-3">
              <h3 class="text-xl font-bold text-white">${booking.tableId}</h3>
              <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest ${statusClass}">${booking.status}</span>
            </div>
            <p class="text-neutral-400 text-sm">
              ${new Date(booking.date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })} at ${booking.time}
            </p>
          </div>
          <div class="flex items-center gap-3">
            <button class="btn-cancel-booking p-2 text-neutral-400 hover:text-red-500 bg-neutral-800 hover:bg-neutral-700 rounded transition-colors" data-id="${booking.id}">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
          </div>
        `;
        list.appendChild(div);
      });

      lucide.createIcons();

      document.querySelectorAll('.btn-cancel-booking').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          if (confirm('Are you sure you want to cancel this booking?')) {
            const id = e.currentTarget.getAttribute('data-id');
            await fetch('/api/bookings.php?action=delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            loadAllData();
          }
        });
      });
    }

    function renderTournaments(registrations) {
      const list = document.getElementById('tournaments-list');
      const empty = document.getElementById('empty-tournaments');
      
      if (!registrations || registrations.length === 0) {
        list.classList.add('hidden');
        empty.classList.remove('hidden');
        return;
      }

      list.classList.remove('hidden');
      empty.classList.add('hidden');
      list.innerHTML = '';

      registrations.forEach(reg => {
        const div = document.createElement('div');
        div.className = 'bg-surface-container-high p-6 rounded-xl border border-outline-variant/20 flex flex-col md:flex-row md:items-center justify-between gap-6';
        
        let statusClass = 'bg-yellow-900/30 text-yellow-400 border border-yellow-500/30';
        if (reg.status === 'approved') statusClass = 'bg-green-900/30 text-green-400 border border-green-500/30';
        if (reg.status === 'rejected') statusClass = 'bg-red-900/30 text-red-400 border border-red-500/30';

        div.innerHTML = `
          <div class="space-y-2">
            <div class="flex items-center gap-3">
              <h3 class="text-xl font-bold text-white">${reg.tournamentName}</h3>
              <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest ${statusClass}">${reg.status}</span>
            </div>
            <p class="text-neutral-400 text-sm">
              Registered on ${new Date(reg.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}
            </p>
            ${reg.membershipId ? `<p class="text-neutral-500 text-xs">Membership ID: ${reg.membershipId}</p>` : ''}
          </div>
          <div class="flex items-center gap-3">
            <button class="btn-cancel-reg p-2 text-neutral-400 hover:text-red-500 bg-neutral-800 hover:bg-neutral-700 rounded transition-colors" data-id="${reg.id}">
              <i data-lucide="x-circle" class="w-4 h-4"></i>
            </button>
          </div>
        `;
        list.appendChild(div);
      });

      lucide.createIcons();

      document.querySelectorAll('.btn-cancel-reg').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          if (confirm('Are you sure you want to withdraw from this tournament?')) {
            const id = e.currentTarget.getAttribute('data-id');
            await fetch('/api/tournaments.php?action=delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            loadAllData();
          }
        });
      });
    }

    function renderPurchases(orders) {
      const list = document.getElementById('purchases-list');
      const empty = document.getElementById('empty-purchases');
      
      if (!orders || orders.length === 0) {
        list.classList.add('hidden');
        empty.classList.remove('hidden');
        return;
      }

      list.classList.remove('hidden');
      empty.classList.add('hidden');
      list.innerHTML = '';

      orders.forEach(order => {
        const div = document.createElement('div');
        div.className = 'bg-surface-container-high p-6 rounded-xl border border-outline-variant/20 flex flex-col md:flex-row md:items-center justify-between gap-6';
        
        let statusClass = 'bg-yellow-900/30 text-yellow-400 border border-yellow-500/30';
        if (order.status === 'processing') statusClass = 'bg-blue-900/30 text-blue-400 border border-blue-500/30';
        if (order.status === 'completed') statusClass = 'bg-green-900/30 text-green-400 border border-green-500/30';
        if (order.status === 'cancelled') statusClass = 'bg-red-900/30 text-red-400 border border-red-500/30';

        div.innerHTML = `
          <div class="space-y-2">
            <div class="flex items-center gap-3">
              <h3 class="text-xl font-bold text-white">${order.merchandise_name} (x${order.quantity})</h3>
              <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest ${statusClass}">${order.status}</span>
            </div>
            <p class="text-neutral-400 text-sm">
              Purchased on ${new Date(order.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}
            </p>
            <p class="text-neutral-500 text-xs">Total Paid: RM ${parseFloat(order.total).toFixed(2)}</p>
          </div>
          <div class="flex items-center gap-3 text-xs text-neutral-500">
            ${order.status === 'pending' ? 'Awaiting verification' : order.status === 'completed' ? 'Collected' : 'Ready to collect'}
          </div>
        `;
        list.appendChild(div);
      });

      lucide.createIcons();
    }

    btnEditProfile.addEventListener('click', () => {
      profileDisplay.classList.add('hidden');
      editProfileForm.classList.remove('hidden');
      btnEditProfile.classList.add('hidden');
    });

    btnCancelEdit.addEventListener('click', () => {
      profileDisplay.classList.remove('hidden');
      editProfileForm.classList.add('hidden');
      btnEditProfile.classList.remove('hidden');
    });

    editProfileForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const saveBtn = document.getElementById('btn-save-profile');
      saveBtn.disabled = true;
      saveBtn.innerText = 'Saving...';

      try {
        const res = await fetch('/api/profile.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                displayName: editDisplayName.value,
                phone: editPhone.value,
                bio: editBio.value
            })
        });
        const data = await res.json();
        
        if (data.success) {
            await loadAllData();
            profileDisplay.classList.remove('hidden');
            editProfileForm.classList.add('hidden');
            btnEditProfile.classList.remove('hidden');
        } else {
            alert(data.error || 'Failed to update profile');
        }
      } catch (err) {
        console.error(err);
      }
      
      saveBtn.disabled = false;
      saveBtn.innerText = 'Save';
    });

    // Init
    checkAuth();
    initNav('profile');
    initFooter();
    lucide.createIcons();
  </script>
</body>
</html>
