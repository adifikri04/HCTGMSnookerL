/**
 * footer.js — Shared footer for HC TGM Snooker Club
 */
export function initFooter() {
  const footerEl = document.querySelector('footer');
  if (!footerEl) return;

  footerEl.className = "w-full py-20 bg-neutral-900 border-t border-neutral-800/30 px-6 md:px-12";
  
  footerEl.innerHTML = `
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
      <!-- Brand -->
      <div class="space-y-6">
        <a href="/" class="flex items-center gap-3 group">
          <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center border border-red-500/30">
            <span class="text-white font-black text-xl italic">HC</span>
          </div>
          <div>
            <div class="text-white font-black tracking-tighter text-sm leading-none">TGM SNOOKER</div>
            <div class="text-red-600 font-bold tracking-widest text-[9px] uppercase">Club Elite</div>
          </div>
        </a>
        <p class="text-neutral-500 text-sm leading-relaxed max-w-xs">
          The ultimate snooker experience. Professional tables, elite environment, and a community of passionate players.
        </p>
        <div class="flex gap-4">
          <a href="#" class="w-8 h-8 rounded-full bg-neutral-800 flex items-center justify-center text-neutral-400 hover:bg-red-600 hover:text-white transition-all"><i data-lucide="instagram" class="w-4 h-4"></i></a>
          <a href="#" class="w-8 h-8 rounded-full bg-neutral-800 flex items-center justify-center text-neutral-400 hover:bg-red-600 hover:text-white transition-all"><i data-lucide="facebook" class="w-4 h-4"></i></a>
          <a href="#" class="w-8 h-8 rounded-full bg-neutral-800 flex items-center justify-center text-neutral-400 hover:bg-red-600 hover:text-white transition-all"><i data-lucide="twitter" class="w-4 h-4"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Quick Links</h4>
        <ul class="space-y-4">
          <li><a href="/" class="text-neutral-500 hover:text-white text-sm transition-colors">Home</a></li>
          <li><a href="/tournaments" class="text-neutral-500 hover:text-white text-sm transition-colors">Tournaments</a></li>
          <li><a href="/shop" class="text-neutral-500 hover:text-white text-sm transition-colors">Club Shop</a></li>
          <li><a href="/livescores" class="text-neutral-500 hover:text-white text-sm transition-colors">Live Scores</a></li>
        </ul>
      </div>

      <!-- Help & FAQ -->
      <div>
        <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Support & FAQ</h4>
        <ul class="space-y-4">
          <li><a href="/faq" class="text-neutral-500 hover:text-white text-sm transition-colors">How to book?</a></li>
          <li><a href="/faq" class="text-neutral-500 hover:text-white text-sm transition-colors">Membership Levels</a></li>
          <li><a href="/faq" class="text-neutral-500 hover:text-white text-sm transition-colors">Tournament Rules</a></li>
          <li><a href="/faq" class="text-neutral-500 hover:text-white text-sm transition-colors">Cue Storage</a></li>
        </ul>
      </div>

      <!-- Contact Us -->
      <div>
        <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Contact Us</h4>
        <ul class="space-y-4">
          <li class="flex items-start gap-3">
            <i data-lucide="map-pin" class="w-4 h-4 text-red-600 flex-shrink-0"></i>
            <span class="text-neutral-500 text-sm">123 Snooker Avenue, Elite Sports Center, KL 50450</span>
          </li>
          <li class="flex items-center gap-3">
            <i data-lucide="phone" class="w-4 h-4 text-red-600 flex-shrink-0"></i>
            <span class="text-neutral-500 text-sm">+60 3-1234 5678</span>
          </li>
          <li class="flex items-center gap-3">
            <i data-lucide="mail" class="w-4 h-4 text-red-600 flex-shrink-0"></i>
            <span class="text-neutral-500 text-sm">support@hctgmsnooker.com</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-neutral-800 flex flex-col md:flex-row justify-between items-center gap-4">
      <p class="text-neutral-600 text-[10px] uppercase tracking-widest font-bold">
        © 2024 HC TGM SNOOKER CLUB. THE ELITE SNOOKER EXPERIENCE.
      </p>
      <div class="flex gap-6">
        <a href="#" class="text-neutral-600 hover:text-white text-[10px] uppercase tracking-widest font-bold transition-colors">Privacy Policy</a>
        <a href="#" class="text-neutral-600 hover:text-white text-[10px] uppercase tracking-widest font-bold transition-colors">Terms of Service</a>
      </div>
    </div>
  `;

  if (window.lucide) {
    window.lucide.createIcons();
  }
}
