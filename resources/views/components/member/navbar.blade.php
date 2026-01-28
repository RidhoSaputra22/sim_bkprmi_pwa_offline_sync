 <!-- Navbar -->
 <div class="navbar bg-base-100 border-b border-base-300 lg:hidden">
     <div class="flex-none">
         <label for="member-drawer" class="btn btn-square btn-ghost drawer-button">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 class="inline-block w-5 h-5 stroke-current">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                 </path>
             </svg>
         </label>
     </div>
     <div class="flex-1">
         <span class="text-lg font-bold">SIM BKPRMI</span>
     </div>
     <div class="flex-none">
         <div class="dropdown dropdown-end">
             <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                 <div class="bg-primary text-primary-content rounded-full w-10 flex items-center justify-center">
                     <span
                         class="text-xs">{{ substr(auth()->user()->person?->full_name ?? auth()->user()->email ?? 'U', 0, 2) }}</span>
                 </div>
             </div>
             <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                 <li><a href="{{ route('member.dashboard') }}">Profile</a></li>
                 <li>
                     <a href="#"
                         onclick="event.preventDefault(); document.getElementById('logout-form-member-navbar').submit();"
                         class="w-full text-left">Logout</a>
                     <form id="logout-form-member-navbar" method="POST" action="{{ route('logout') }}" class="hidden">
                         @csrf
                     </form>
                 </li>
             </ul>
         </div>
     </div>
 </div>

 <!-- Desktop Navbar -->
 <div class="navbar bg-base-100 border-b border-base-300 hidden lg:flex">
     <div class="flex-1">
         <span class="text-lg font-bold px-4">{{ $title ?? 'Dashboard' }}</span>
     </div>
     <div class="flex-none gap-2">
         <div class="dropdown dropdown-end">
             <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                 <div class="bg-primary text-primary-content rounded-full w-10 flex items-center justify-center">
                     <span
                         class="text-xs">{{ substr(auth()->user()->person?->full_name ?? auth()->user()->email ?? 'U', 0, 2) }}</span>
                 </div>
             </div>
             <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                 <li class="menu-title">
                     <span>{{ auth()->user()->person?->full_name ?? auth()->user()->email }}</span>
                 </li>
                 <li><a href="{{ route('member.dashboard') }}">Profile</a></li>
                 <li>
                     <a href="#"
                         onclick="event.preventDefault(); document.getElementById('logout-form-member-navbar').submit();"
                         class="w-full text-left">Logout</a>
                     <form id="logout-form-member-navbar" method="POST" action="{{ route('logout') }}" class="hidden">
                         @csrf
                     </form>
                 </li>
             </ul>
         </div>
     </div>
 </div>
