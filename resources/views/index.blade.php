<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HC TGM Snooker Club</title>
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
    body { background: #0a0a0a; color: #fff; }
    .flow-section {
      position: relative;
      min-height: 66vh;
      display: flex;
      align-items: center;
      overflow: hidden;
      isolation: isolate;
    }
    .flow-section::before {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -2;
      background-image: var(--photo);
      background-size: cover;
      background-position: center;
      filter: saturate(.9) contrast(1.08);
      transform: scale(1.02);
    }
    .flow-section::after {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -1;
      background:
        linear-gradient(180deg, rgba(10,10,10,.96) 0%, rgba(10,10,10,.2) 24%, rgba(10,10,10,.2) 74%, rgba(10,10,10,.96) 100%),
        linear-gradient(90deg, rgba(10,10,10,.95) 0%, rgba(10,10,10,.7) 34%, rgba(127,29,29,.28) 58%, rgba(10,10,10,.88) 100%);
    }
    .flow-section.right::after {
      background:
        linear-gradient(180deg, rgba(10,10,10,.96) 0%, rgba(10,10,10,.2) 24%, rgba(10,10,10,.2) 74%, rgba(10,10,10,.96) 100%),
        linear-gradient(270deg, rgba(10,10,10,.95) 0%, rgba(10,10,10,.7) 34%, rgba(127,29,29,.28) 58%, rgba(10,10,10,.88) 100%);
    }
    .flow-copy {
      width: min(100%, 560px);
      border-left: 4px solid #dc2626;
      background: linear-gradient(90deg, rgba(10,10,10,.72), rgba(10,10,10,.18));
      padding: 2rem;
      backdrop-filter: blur(2px);
    }
    .flow-section.right .flow-copy {
      border-left: 0;
      border-right: 4px solid #dc2626;
      background: linear-gradient(270deg, rgba(10,10,10,.72), rgba(10,10,10,.18));
      text-align: right;
    }
    @media (max-width: 767px) {
      .flow-section { min-height: 560px; }
      .flow-section.right .flow-copy {
        border-right: 0;
        border-left: 4px solid #dc2626;
        background: linear-gradient(90deg, rgba(10,10,10,.78), rgba(10,10,10,.22));
        text-align: left;
      }
    }
  </style>
</head>
<body class="flex min-h-screen flex-col bg-background text-white">
  <nav class="fixed top-0 z-50 w-full border-b border-neutral-800 bg-neutral-950/90 shadow-2xl shadow-black/50 backdrop-blur-md">
    <div class="flex w-full items-center justify-between gap-6 px-6 py-4 md:px-12">
      <a href="/" class="flex items-center gap-3 group">
        <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-red-500/30 bg-red-600 shadow-lg shadow-red-900/30 transition-transform group-hover:scale-105">
          <span class="text-xl font-black italic text-white">HC</span>
        </div>
        <div class="flex flex-col">
          <span class="text-sm font-black leading-none tracking-tight text-white md:text-lg">TGM SNOOKER</span>
          <span class="text-[9px] font-bold uppercase leading-none tracking-[0.28em] text-red-600 md:text-[10px]">Club Elite</span>
        </div>
      </a>
      <div id="nav-links" class="hidden items-center gap-5 overflow-x-auto whitespace-nowrap md:gap-8"></div>
    </div>
  </nav>

  <main class="flex-grow pt-20">
    <section class="flow-section min-h-[calc(100vh-5rem)] px-6 pt-16 md:px-12" style="--photo: url('https://images.unsplash.com/photo-1615226449406-669ea2525baf?auto=format&fit=crop&w=1800&q=80');">
      <div class="mx-auto flex w-full max-w-7xl justify-start">
        <div class="flow-copy">
          <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Snooker Club</p>
          <h1 class="mb-6 text-4xl font-black uppercase leading-tight text-white md:text-6xl">HC TGM Snooker Club</h1>
          <p class="text-base leading-8 text-neutral-200 md:text-lg">
            A black-table atmosphere for serious practice, friendly matches, tournament nights, and club community. HC TGM brings together competitive players, new members, and supporters who love clean breaks, sharp safety play, and the pressure of the final frame.
          </p>
        </div>
      </div>
    </section>

    <section class="flow-section right px-6 md:px-12" style="--photo: url('https://images.unsplash.com/photo-1532635241-17e820acc59f?auto=format&fit=crop&w=1800&q=80');">
      <div class="mx-auto flex w-full max-w-7xl justify-end">
        <div class="flow-copy">
          <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Competition</p>
          <h2 class="mb-5 text-3xl font-black uppercase leading-tight text-white md:text-5xl">Tournament</h2>
          <p class="mb-8 text-base leading-8 text-neutral-200">
            View ongoing club matches, upcoming competitions, tournament table, entry details, and registration for the next challenge.
          </p>
          <a href="/tournaments" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-red-500">
            Tournament Page <i data-lucide="arrow-right" class="h-4 w-4"></i>
          </a>
        </div>
      </div>
    </section>

    <section class="flow-section px-6 md:px-12" style="--photo: url('https://images.unsplash.com/photo-1521417531039-75e91486cc40?auto=format&fit=crop&w=1800&q=80');">
      <div class="mx-auto flex w-full max-w-7xl justify-start">
        <div class="flow-copy">
          <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Club Players</p>
          <h2 class="mb-5 text-3xl font-black uppercase leading-tight text-white md:text-5xl">Player Profile</h2>
          <p class="mb-8 text-base leading-8 text-neutral-200">
            Browse club players from A to Z and open each profile for level, wins, ranking points, tournament history, and current form.
          </p>
          <a href="/players" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-red-500">
            Profile Page <i data-lucide="arrow-right" class="h-4 w-4"></i>
          </a>
        </div>
      </div>
    </section>

    <section class="flow-section right px-6 md:px-12" style="--photo: url('https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=1800&q=80');">
      <div class="mx-auto flex w-full max-w-7xl justify-end">
        <div class="flow-copy">
          <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Leaderboard</p>
          <h2 class="mb-5 text-3xl font-black uppercase leading-tight text-white md:text-5xl">Player Ranking</h2>
          <p class="mb-8 text-base leading-8 text-neutral-200">
            Track the top players by tournament wins, total points, played matches, win rate, and current club position.
          </p>
          <a href="/rankings" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-red-500">
            Ranking Page <i data-lucide="arrow-right" class="h-4 w-4"></i>
          </a>
        </div>
      </div>
    </section>

    <section class="flow-section px-6 md:px-12" style="--photo: url('https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=1800&q=80');">
      <div class="mx-auto flex w-full max-w-7xl justify-start">
        <div class="flow-copy">
          <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-red-500">Club Shop</p>
          <h2 class="mb-5 text-3xl font-black uppercase leading-tight text-white md:text-5xl">Merchandise</h2>
          <p class="mb-8 text-base leading-8 text-neutral-200">
            Shop official club jerseys, cue towels, caps, chalk sets, and limited HC TGM supporter items from the merchandise page.
          </p>
          <a href="/shop" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-5 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-red-500">
            Merchandise Page <i data-lucide="arrow-right" class="h-4 w-4"></i>
          </a>
        </div>
      </div>
    </section>
  </main>

  <footer></footer>

  <script type="module">
    import { initNav } from "/js/nav.js";
    import { initFooter } from "/js/footer.js";
    initNav('home');
    initFooter();
    lucide.createIcons();
  </script>
</body>
</html>
