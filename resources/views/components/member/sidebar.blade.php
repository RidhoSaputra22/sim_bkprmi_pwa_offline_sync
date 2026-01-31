 <!-- Sidebar -->
 <div class="drawer-side">
     <label for="member-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
     <aside class="bg-base-100 w-64 min-h-screen">
         <!-- Logo -->
         <div class="p-4 border-b border-base-300">
             <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2">
                 <div class="avatar placeholder">
                     <div
                         class="bg-primary text-primary-content rounded-lg p-2 w-10 h-10 flex items-center justify-center">
                         <span class="text-xl font-bold">B</span>
                     </div>
                 </div>
                 <div>
                     <h1 class="font-bold">SIM BKPRMI</h1>
                     <p class="text-xs text-base-content/60">Member Portal</p>
                 </div>
             </a>
         </div>

         <!-- Navigation -->
         <ul class="menu p-4 w-full">
             <li class="menu-title">
                 <span>Menu Utama</span>
             </li>
             <li>
                 <a href="{{ route('member.dashboard') }}"
                     class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                         </path>
                     </svg>
                     Dashboard
                 </a>
             </li>
             <li>
                 <a href="{{ route('member.organization.index') }}"
                     class="{{ request()->routeIs('member.organization.*') ? 'active' : '' }}">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                         </path>
                     </svg>
                     Informasi Organisasi
                 </a>
             </li>
             <li>
                 <a href="{{ route('member.activities.index') }}"
                     class="{{ request()->routeIs('member.activities.*') ? 'active' : '' }}">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                         </path>
                     </svg>
                     Data Kegiatan
                 </a>
             </li>
             <li>
                 <a href="{{ route('member.reports.index') }}"
                     class="{{ request()->routeIs('member.reports.*') ? 'active' : '' }}">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                         </path>
                     </svg>
                     Laporan
                 </a>
             </li>

             <li class="menu-title mt-4">
                 <span>PWA & Offline</span>
             </li>
             <li>
                 <details>
                     <summary>
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                         </svg>
                         PWA Management
                     </summary>
                     <ul>
                         <li><a href="#" onclick="checkPWAStatus(); return false;">Status PWA</a></li>
                         <li><a href="#" onclick="clearOfflineCache(); return false;">Clear Cache</a></li>
                         <li><a href="#" onclick="syncOfflineData(); return false;">Sync Data</a></li>
                     </ul>
                 </details>
             </li>

             <li class="menu-title mt-4">
                 <span>Akun</span>
             </li>
             <li>
                 <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-member').submit();" class="w-full text-left flex items-center gap-2">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                         </path>
                     </svg>
                     Logout
                 </a>
                 <form id="logout-form-member" method="POST" action="{{ route('logout') }}" class="hidden">
                     @csrf
                 </form>
             </li>
         </ul>
     </aside>
 </div>
