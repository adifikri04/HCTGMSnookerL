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

  const pages = [
    { id: 'home',        href: '/',       label: 'Home' },
    { id: 'tournaments', href: '/tournaments',  label: 'Tournaments' },
    { id: 'livescores',  href: '/livescores',   label: 'Live Score' },
    { id: 'players',     href: '/players',      label: 'Player Profile' },
    { id: 'rankings',    href: '/rankings',     label: 'Player Ranking' },
    { id: 'shop',        href: '/shop',         label: 'Merchandise' },
  ];

  let html = pages.map(p => {
    const active = currentPage === p.id;
    return `<a href="${p.href}" class="uppercase tracking-widest text-xs transition-all pb-1 ${active ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">${p.label}</a>`;
  }).join('');

  if (user) {
    if (user.role === 'admin') {
      const active = currentPage === 'admin';
      html += `<a href="/admin" class="uppercase tracking-widest text-xs transition-all pb-1 ${active ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Dashboard</a>`;
    } else {
      const active = currentPage === 'profile';
      html += `<a href="/profile" class="uppercase tracking-widest text-xs transition-all pb-1 ${active ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Profile</a>`;
    }
    html += `<a href="/book" class="uppercase tracking-widest text-xs transition-all pb-1 ${currentPage === 'book' ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Book</a>`;
    html += `<button id="btn-nav-logout" class="uppercase tracking-widest text-xs text-neutral-400 hover:text-red-500 transition-all pb-1">Logout</button>`;
  } else {
    html += `<a href="/login" class="uppercase tracking-widest text-xs transition-all pb-1 ${currentPage === 'login' || currentPage === 'signup' ? 'text-red-600 font-bold border-b-2 border-red-600' : 'text-neutral-400 hover:text-white'}">Login</a>`;
  }

  navLinks.innerHTML = html;
  navLinks.classList.remove('hidden');
  navLinks.classList.add('flex');

  document.getElementById('btn-nav-logout')?.addEventListener('click', async () => {
    await fetch('/api/auth.php?action=logout');
    window.location.href = '/login';
  });

  return user;
}
