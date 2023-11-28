<header class="w-full">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 md:max-w-7xl md:px-8">
        <div class="relative flex flex-wrap items-center justify-center md:justify-between">
            <div class="absolute left-0 top-0 flex flex-shrink-0 items-center py-5 md:static">
                <div class="sm:flex sm:space-x-5">
                    <div class="mt-4 text-left sm:mt-0 sm:pt-1">
                        <p class="text-2xl font-bold capitalize text-gray-200 sm:text-2xl">
                            <span class="font-medium text-gray-400">Halo,</span> Name.
                        </p>
                        <p class="text-sm font-medium text-gray-400">username@email.com</p>
                    </div>
                </div>
            </div>
            <div class="hidden md:ml-4 md:flex md:items-center md:py-5 md:pr-0.5">
                <div class="relative ml-4 flex-shrink-0">
                    <div class="relative">
                        <div class="profile-toggle opacity-100 transition delay-300 duration-700">
                            <button class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-500/80 focus:outline-none">
                                <span class="h-10 w-10 rounded-full">
                                    <img class="rounded-full" src="https://ui-avatars.com/api/?name=F+P&color=7F9CF5&background=EBF4FF" alt="User">
                                </span>
                            </button>
                        </div>
                        <div class="fixed inset-0 z-40" style="display: none;"></div>
                        <div class="profile-menu -z-50 w-48 -translate-y-full opacity-0 transition-all duration-300">
                            <div
                                 class="z-50 rounded-xl border border-vulcan-600/80 bg-vulcan-500 bg-opacity-40 bg-clip-padding px-1 py-1 shadow-lg backdrop-blur-lg backdrop-filter">
                                <div>
                                    <a class="flex rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="/">
                                        Home
                                    </a>
                                </div>
                                <div class="pb-1 pt-0.5">
                                    <a class="flex rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="/profile">
                                        Profil
                                    </a>
                                    <a class="flex rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="/game/account">
                                        Akun Game
                                    </a>
                                </div>
                                <div class="border-t border-vulcan-500/70"></div>
                                <form>
                                    <div class="pt-1">
                                        <button class="flex w-full rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                                type="submit">
                                            Keluar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute top-24 hidden md:block  z-0 w-full border-t border-gray-600 opacity-100 transition-all delay-700 duration-700"></div>
            <div class="nav-menu-wrapper z-40" id="nav-menu-wrapper">
                <div class="flex w-full justify-between rounded-lg transition-all duration-700 lg:rounded-xl">
                    <nav class="flex w-full items-center justify-between space-x-4 transition-all duration-700 md:justify-normal">
                        <a class="nav-item active" href="/dashboard">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-house mb-0.5 mt-1 md:m-0 md:mb-0.5"></i>
                                <span>Home</span>
                            </span>
                        </a>
                        <a class="nav-item" href="/project">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-gamepad mb-0.5 mt-1 md:m-0"></i>
                                <span class="">Game</span>
                            </span>
                        </a>
                        <a class="nav-item" href="/transaction">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-layer-group mb-0.5 mt-1 md:m-0"></i>
                                <span class="">Team</span>
                            </span>
                        </a>
                        <a class="nav-item" href="/profile">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-brands fa-steam mb-0.5 mt-1 md:m-0"></i>
                                <span class="">Akun</span>
                            </span>
                        </a>
                        <a class="nav-item flex md:hidden" href="/profile">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <img class="h-7 w-7 rounded-full object-cover" src="https://ui-avatars.com/api/?name=F+p&color=7F9CF5&background=EBF4FF"
                                     alt="User">
                                <span class="">Profil</span>
                            </span>
                        </a>
                    </nav>

                    <div class="profile-toggle hidden opacity-0 transition duration-700 md:flex">
                        <button class="flex rounded-full border-2 border-transparent text-sm focus:border-gray-500/80 focus:outline-none">
                            <span class="h-10 w-10 rounded-full">
                                <img class="rounded-full object-cover" src="https://ui-avatars.com/api/?name=F+p&color=7F9CF5&background=EBF4FF" alt="User">
                            </span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="absolute right-0 flex-shrink-0 md:hidden"></div>
        </div>
</header>
