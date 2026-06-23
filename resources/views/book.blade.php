<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book a Table - HC TGM Snooker Club</title>
  
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
      <p class="text-neutral-400 mb-8 text-sm">You must be logged in to book a table at HC TGM Snooker Club.</p>
      <a href="/login" class="block w-full baize-gradient text-white py-4 rounded-lg font-bold uppercase tracking-widest hover:brightness-110 transition-all">
        Sign in to Book
      </a>
    </div>
  </main>

  <main id="book-content" class="pt-32 pb-24 min-h-screen px-6 md:px-12 hidden">
    <div class="max-w-3xl mx-auto">
      <div class="bg-surface-container-high p-8 md:p-12 rounded-xl border border-outline-variant/20 shadow-2xl">
        <h1 class="text-4xl md:text-5xl font-headline font-extrabold text-white mb-2">Book a Table</h1>
        <p class="text-neutral-400 mb-8">Reserve your spot on the professional-grade baize.</p>

        <div id="success-message" class="hidden bg-green-900/30 border border-green-500/50 text-green-400 p-4 rounded-lg mb-8 text-sm flex justify-between items-center">
          <span>Booking request submitted successfully! We will confirm your reservation shortly.</span>
          <a href="/profile" class="underline font-bold hover:text-green-300">View Bookings</a>
        </div>

        <div id="error-message" class="hidden bg-red-900/30 border border-red-500/50 text-red-400 p-4 rounded-lg mb-8 text-sm"></div>

        <form id="booking-form" class="space-y-6">
          <div>
            <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Full Name</label>
            <input id="book-name" required class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all" type="text" />
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Date</label>
              <input id="book-date" required class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all" type="date" />
            </div>
            <div>
              <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Time</label>
              <select id="book-time" required class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all">
                <!-- Injected via JS -->
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-neutral-400 mb-2 uppercase tracking-widest">Select Table</label>
            <select id="book-table" class="w-full bg-neutral-900 border border-neutral-800 rounded-lg text-white text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 p-3 outline-none transition-all">
              <option value="Table 1">Table 1 (Championship Baize)</option>
              <option value="Table 2">Table 2 (Standard)</option>
              <option value="Table 3">Table 3 (Standard)</option>
              <option value="VIP Room">VIP Room (Private)</option>
            </select>
          </div>

          <button id="btn-submit" type="submit" class="w-full baize-gradient text-white py-4 rounded-lg text-sm font-bold uppercase tracking-widest hover:brightness-110 transition-all mt-8 shadow-lg shadow-red-900/20 disabled:opacity-50">
            Confirm Booking
          </button>
        </form>
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
    let bookedSlots = [];

    const ALL_TIME_SLOTS = [
      { value: "12:00", label: "12:00 PM" },
      { value: "13:00", label: "1:00 PM" },
      { value: "14:00", label: "2:00 PM" },
      { value: "15:00", label: "3:00 PM" },
      { value: "16:00", label: "4:00 PM" },
      { value: "17:00", label: "5:00 PM" },
      { value: "18:00", label: "6:00 PM" },
      { value: "19:00", label: "7:00 PM" },
      { value: "20:00", label: "8:00 PM" },
      { value: "21:00", label: "9:00 PM" },
      { value: "22:00", label: "10:00 PM" },
      { value: "23:00", label: "11:00 PM" },
      { value: "00:00", label: "12:00 AM" },
      { value: "01:00", label: "1:00 AM" },
      { value: "02:00", label: "2:00 AM" },
    ];

    const authRequiredEl = document.getElementById('auth-required');
    const bookContentEl = document.getElementById('book-content');
    
    const form = document.getElementById('booking-form');
    const nameInput = document.getElementById('book-name');
    const dateInput = document.getElementById('book-date');
    const timeInput = document.getElementById('book-time');
    const tableInput = document.getElementById('book-table');
    const btnSubmit = document.getElementById('btn-submit');
    const successMsg = document.getElementById('success-message');
    const errorMsg = document.getElementById('error-message');

    // Set min date
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
    dateInput.value = today;

    async function checkAuth() {
      const res = await fetch('/api/auth.php?action=session');
      const data = await res.json();
      if (data.user) {
        currentUser = data.user;
        nameInput.value = currentUser.displayName || '';
        authRequiredEl.classList.add('hidden');
        bookContentEl.classList.remove('hidden');
        checkBookedSlots();
      } else {
        currentUser = null;
        authRequiredEl.classList.remove('hidden');
        bookContentEl.classList.add('hidden');
      }
    }

    function renderTimeSlots() {
      timeInput.innerHTML = '';
      const selectedDate = dateInput.value;
      const today = new Date().toISOString().split('T')[0];
      const currentHour = new Date().getHours();
      
      ALL_TIME_SLOTS.forEach(slot => {
        let isBooked = bookedSlots.includes(slot.value);
        let isPast = false;
        
        if (selectedDate === today) {
          const slotHour = parseInt(slot.value.split(':')[0], 10);
          if (slotHour <= currentHour && slotHour >= 12) {
             isPast = true;
          }
        }

        const option = document.createElement('option');
        option.value = slot.value;
        option.disabled = isBooked || isPast;
        option.innerText = slot.label + (isBooked ? ' (Booked)' : (isPast ? ' (Passed)' : ''));
        timeInput.appendChild(option);
      });
    }

    async function checkBookedSlots() {
      const date = dateInput.value;
      const tableId = tableInput.value;
      if (!date || !tableId) return;

      try {
        const res = await fetch(`/api/bookings.php?action=check_slots&date=${date}&tableId=${tableId}`);
        const data = await res.json();
        bookedSlots = Array.isArray(data) ? data : [];
        renderTimeSlots();
      } catch (err) {
        console.error("Error checking slots:", err);
      }
    }

    dateInput.addEventListener('change', checkBookedSlots);
    tableInput.addEventListener('change', checkBookedSlots);

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!currentUser) return;

      btnSubmit.disabled = true;
      btnSubmit.innerText = 'Processing...';
      successMsg.classList.add('hidden');
      errorMsg.classList.add('hidden');

      try {
        const res = await fetch('/api/bookings.php?action=create', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            name: nameInput.value,
            date: dateInput.value,
            time: timeInput.value,
            tableId: tableInput.value
          })
        });
        const data = await res.json();
        
        if (data.success) {
          successMsg.classList.remove('hidden');
          checkBookedSlots(); // Refresh slots
        } else {
          errorMsg.innerText = data.error || 'Booking failed. Please try again.';
          errorMsg.classList.remove('hidden');
        }
      } catch (err) {
        errorMsg.innerText = 'An error occurred while booking. Please try again.';
        errorMsg.classList.remove('hidden');
      }

      btnSubmit.disabled = false;
      btnSubmit.innerText = 'Confirm Booking';
    });

    checkAuth();
    initNav('book');
    initFooter();
    lucide.createIcons();
  </script>
</body>
</html>
