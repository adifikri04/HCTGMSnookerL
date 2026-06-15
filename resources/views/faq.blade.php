<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FAQ - HC TGM Snooker Club</title>
  
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
    body { background-color: #0a0a0a; color: white; }
    .baize-gradient { background: linear-gradient(135deg, #166534 0%, #14532d 100%); }
    .faq-item { border-bottom: 1px solid rgba(64, 64, 64, 0.15); }
    .faq-item:last-child { border-bottom: none; }
  </style>
</head>
<body class="flex flex-col min-h-screen">

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

  <main class="pt-32 pb-24 min-h-screen px-6 md:px-12 max-w-4xl mx-auto flex-grow">
    <header class="mb-16 text-center">
      <h1 class="text-5xl md:text-7xl font-headline font-extrabold text-white mb-6 uppercase tracking-tighter">
        Frequently Asked <span class="text-red-600">Questions</span>
      </h1>
      <p class="text-neutral-500 text-lg max-w-2xl mx-auto">
        Everything you need to know about bookings, memberships, and tournament rules at HC TGM Snooker Club.
      </p>
    </header>

    <div class="bg-surface-container-high rounded-2xl border border-outline-variant/20 overflow-hidden shadow-2xl">
      <!-- FAQ Section: Bookings -->
      <div class="p-8 md:p-10 bg-neutral-900/50">
        <h2 class="text-red-500 font-bold uppercase tracking-widest text-xs mb-8 flex items-center gap-3">
          <i data-lucide="calendar" class="w-4 h-4"></i> Table Bookings
        </h2>
        <div class="space-y-8">
          <div class="faq-item pb-8">
            <h3 class="text-white font-bold text-lg mb-3">How do I book a table?</h3>
            <p class="text-neutral-400 text-sm leading-relaxed">
              You can book a table directly through our website by navigating to the "Book" section. You'll need to be logged in to your account. Select your preferred date, time, and table to confirm your reservation.
            </p>
          </div>
          <div class="faq-item pb-8">
            <h3 class="text-white font-bold text-lg mb-3">Can I cancel my booking?</h3>
            <p class="text-neutral-400 text-sm leading-relaxed">
              Yes, you can cancel your booking from your profile page up to 2 hours before the scheduled time. Frequent last-minute cancellations may affect your membership status.
            </p>
          </div>
        </div>
      </div>

      <!-- FAQ Section: Membership -->
      <div class="p-8 md:p-10 border-t border-outline-variant/15">
        <h2 class="text-yellow-500 font-bold uppercase tracking-widest text-xs mb-8 flex items-center gap-3">
          <i data-lucide="award" class="w-4 h-4"></i> Membership & Ranking
        </h2>
        <div class="space-y-8">
          <div class="faq-item pb-8">
            <h3 class="text-white font-bold text-lg mb-3">How are rankings calculated?</h3>
            <p class="text-neutral-400 text-sm leading-relaxed">
              Rankings are based on tournament participation, win rates, and points earned during club events. Our system updates every Monday based on the previous week's performance.
            </p>
          </div>
          <div class="faq-item pb-8">
            <h3 class="text-white font-bold text-lg mb-3">What are the membership levels?</h3>
            <p class="text-neutral-400 text-sm leading-relaxed">
              We have four main levels: Beginner, Intermediate, Advanced, and Professional. New members start at Beginner and can progress by participating in tournaments and winning matches.
            </p>
          </div>
        </div>
      </div>

      <!-- FAQ Section: Club Rules -->
      <div class="p-8 md:p-10 border-t border-outline-variant/15 bg-neutral-900/50">
        <h2 class="text-green-500 font-bold uppercase tracking-widest text-xs mb-8 flex items-center gap-3">
          <i data-lucide="shield-check" class="w-4 h-4"></i> Club Rules
        </h2>
        <div class="space-y-8">
          <div class="faq-item pb-8">
            <h3 class="text-white font-bold text-lg mb-3">Is there a dress code?</h3>
            <p class="text-neutral-400 text-sm leading-relaxed">
              While we encourage casual smart attire, professional tournaments require formal snooker wear (waistcoat and bow tie). For regular play, clean polo shirts and trousers are preferred.
            </p>
          </div>
          <div class="faq-item pb-8">
            <h3 class="text-white font-bold text-lg mb-3">Can I bring my own cue?</h3>
            <p class="text-neutral-400 text-sm leading-relaxed">
              Absolutely. We also provide secure cue storage lockers for our Elite members. Standard club cues are available for all guests.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-16 text-center">
      <p class="text-neutral-500 mb-6">Still have questions?</p>
      <a href="mailto:support@hctgmsnooker.com" class="inline-flex items-center gap-3 baize-gradient text-white px-8 py-4 rounded-lg font-bold text-sm uppercase tracking-widest hover:brightness-110 transition-all shadow-lg shadow-green-900/20">
        <i data-lucide="mail" class="w-4 h-4"></i> Contact Support
      </a>
    </div>
  </main>

  <footer class="w-full"></footer>

  <script type="module">
    import { initNav } from '/js/nav.js';
    import { initFooter } from '/js/footer.js';
    initNav('faq');
    initFooter();
    lucide.createIcons();
  </script>
</body>
</html>
