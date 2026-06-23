/**
 * nav.js — Shared navigation for HC TGM Snooker Club
 * Usage: import { initNav } from './nav.js'; initNav('home');
 */
export async function initNav(currentPage) {
  const navLinks = document.getElementById('nav-links');
  if (!navLinks) return null;

  let user = null;
  try {
    const res = await fetch('/api/auth.php?action=session');
    const data = await res.json();
    user = data.user || null;
  } catch (e) { /* offline */ }

  if (currentPage === 'admin') {
    return user;
  }

  const pages = [
    { id: 'home',        href: '/',       label: 'Home' },
    { id: 'tournaments', href: '/tournaments',  label: 'Tournaments' },
    { id: 'livescores',  href: '/livescores',   label: 'Live Score' },
    { id: 'players',     href: '/players',      label: 'Player Profile' },
    { id: 'rankings',    href: '/rankings',     label: 'Player Ranking' },
    { id: 'shop',        href: '/shop',         label: 'Merchandise' },
  ];

  let linksHtml = pages.map(p => {
    const active = currentPage === p.id;
    return `<a href="${p.href}" class="uppercase tracking-widest text-xs transition-all pb-1 ${active ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">${p.label}</a>`;
  }).join('');

  if (user) {
    if (user.role === 'admin') {
      const active = currentPage === 'admin';
      linksHtml += `<a href="/admin" class="uppercase tracking-widest text-xs transition-all pb-1 ${active ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Dashboard</a>`;
    } else {
      const active = currentPage === 'profile';
      linksHtml += `<a href="/profile" class="uppercase tracking-widest text-xs transition-all pb-1 ${active ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Profile</a>`;
    }
    linksHtml += `<a href="/book" class="uppercase tracking-widest text-xs transition-all pb-1 ${currentPage === 'book' ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Book</a>`;
    linksHtml += `<button class="btn-nav-logout uppercase tracking-widest text-xs text-neutral-400 hover:text-red-500 transition-all pb-1">Logout</button>`;
  } else {
    linksHtml += `<a href="/login" class="uppercase tracking-widest text-xs transition-all pb-1 ${currentPage === 'login' || currentPage === 'signup' ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Login</a>`;
  }

  const desktopHtml = `<div class="hidden md:flex items-center gap-5 md:gap-8">${linksHtml}</div>`;
  const mobileBtnHtml = `<button id="mobile-menu-btn" class="md:hidden text-white p-2 focus:outline-none"><i data-lucide="menu" class="w-6 h-6"></i></button>`;
  const mobileMenuHtml = `<div id="mobile-menu" class="absolute top-full left-0 w-full bg-neutral-950/95 backdrop-blur-md border-b border-neutral-800 flex-col items-center py-6 gap-6 hidden md:hidden shadow-2xl">${linksHtml}</div>`;

  navLinks.innerHTML = desktopHtml + mobileBtnHtml + mobileMenuHtml;
  navLinks.classList.remove('hidden', 'overflow-x-auto', 'whitespace-nowrap');
  navLinks.classList.add('flex', 'items-center');

  document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
    const menu = document.getElementById('mobile-menu');
    if (menu.classList.contains('hidden')) {
      menu.classList.remove('hidden');
      menu.classList.add('flex');
    } else {
      menu.classList.add('hidden');
      menu.classList.remove('flex');
    }
  });

  document.querySelectorAll('.btn-nav-logout').forEach(btn => {
    btn.addEventListener('click', async () => {
      await fetch('/api/auth.php?action=logout');
      window.location.href = '/login';
    });
  });

  return user;
}
