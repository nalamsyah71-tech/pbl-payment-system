<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'PBL Payment System'); ?> – Sistem Pembayaran</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#1e1b4b',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <style>
        [x-cloak] { display: none !important; }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 99px; }

        /* Sidebar */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: #a5b4fc;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .nav-item:hover {
            background: rgba(99,102,241,0.2);
            color: #fff;
        }
        .nav-item.active {
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }
        .nav-item svg { flex-shrink: 0; }

        /* Card hover */
        .card-hover { transition: box-shadow 0.2s, transform 0.2s; }
        .card-hover:hover { box-shadow: 0 8px 24px rgba(99,102,241,0.12); transform: translateY(-1px); }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        /* Pulse animation for notifications */
        @keyframes ping-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* Sidebar mobile overlay */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 30;
            backdrop-filter: blur(2px);
        }

        /* Toast animation */
        @keyframes slide-in {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .toast { animation: slide-in 0.3s ease; }

        /* Table row hover */
        .table-row { transition: background 0.1s; }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Spinner */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.8s linear infinite; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    mobileOpen: false
}" @resize.window="sidebarOpen = window.innerWidth >= 1024">

<div class="flex h-screen overflow-hidden">

    
    <div x-show="mobileOpen"
         x-cloak
         class="sidebar-overlay lg:hidden"
         @click="mobileOpen = false">
    </div>

    
    <aside class="fixed lg:relative z-40 flex flex-col h-full transition-all duration-300 ease-in-out flex-shrink-0"
           :class="{
               'translate-x-0': mobileOpen,
               '-translate-x-full': !mobileOpen,
               'lg:translate-x-0': true,
               'lg:w-60': sidebarOpen,
               'lg:w-16': !sidebarOpen,
               'w-60': true
           }"
           style="background: linear-gradient(160deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%);">

        
        <div class="flex items-center gap-3 px-4 h-12 border-b border-indigo-800/50">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg, #6366f1, #818cf8); box-shadow: 0 6px 10px rgba(99,102,241,0.5);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div x-show="sidebarOpen || mobileOpen" class="overflow-hidden">
                <p class="text-white font-bold text-sm leading-none">PBL Payment</p>
                <p class="text-indigo-300 text-xs mt-0.5">v1.0 · Admin</p>
            </div>
        </div>

        
        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-0.5">

            
            <a href="<?php echo e(route('dashboard')); ?>"
               class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Dashboard</span>
            </a>

            
            <div x-show="sidebarOpen || mobileOpen" class="px-3 pt-5 pb-2">
                <p class="text-xs font-semibold text-indigo-400 uppercase tracking-widest">Master Data</p>
            </div>
            <div x-show="!(sidebarOpen || mobileOpen)" class="border-t border-indigo-800/40 my-2 mx-2"></div>

            <a href="<?php echo e(route('kejuruan.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('kejuruan.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Kejuruan</span>
            </a>

            <a href="<?php echo e(route('pelatihan.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('pelatihan.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Pelatihan</span>
            </a>

            <a href="<?php echo e(route('kelas.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('kelas.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Kelas</span>
            </a>

            <a href="<?php echo e(route('peserta.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('peserta.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Peserta</span>
            </a>

            
            <div x-show="sidebarOpen || mobileOpen" class="px-3 pt-5 pb-2">
                <p class="text-xs font-semibold text-indigo-400 uppercase tracking-widest">Pembayaran</p>
            </div>
            <div x-show="!(sidebarOpen || mobileOpen)" class="border-t border-indigo-800/40 my-2 mx-2"></div>

            <a href="<?php echo e(route('pembayaran-pulsa.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('pembayaran-pulsa.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Pulsa Internet</span>
            </a>

            <a href="<?php echo e(route('pembayaran-asuransi.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('pembayaran-asuransi.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Asuransi BPJS</span>
            </a>

            <a href="<?php echo e(route('pembayaran-uang-saku.index')); ?>"
               class="nav-item <?php echo e(request()->routeIs('pembayaran-uang-saku.*') ? 'active' : ''); ?>">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="sidebarOpen || mobileOpen" class="truncate">Uang Saku</span>
            </a>
        </nav>

        
        <div class="border-t border-indigo-800/40 p-3" x-show="sidebarOpen || mobileOpen">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-semibold truncate"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                    <p class="text-indigo-400 text-xs truncate"><?php echo e(auth()->user()->email ?? ''); ?></p>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="flex-shrink-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="p-1.5 text-indigo-400 hover:text-white rounded-lg hover:bg-indigo-700/50 transition-colors" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        
        <header class="bg-white border-b border-slate-200 h-14 flex items-center justify-between px-4 lg:px-6 flex-shrink-0 z-20"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <div class="flex items-center gap-3">
                
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                
                <nav class="hidden sm:flex items-center text-sm text-slate-500">
                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                </nav>
            </div>

            <div class="flex items-center gap-2 lg:gap-4">
                
                <span class="hidden md:block text-xs text-slate-500 font-medium">
                    <?php echo e(now()->locale('id')->isoFormat('dddd, D MMM Y')); ?>

                </span>

            </div>
        </header>

        
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div x-data="{ show: true }"
                     x-show="show"
                     x-cloak
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition:leave="transition duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="toast mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm">
                    <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
                    <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div x-data="{ show: true }"
                     x-show="show"
                     x-cloak
                     x-init="setTimeout(() => show = false, 5000)"
                     x-transition:leave="transition duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="toast mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-sm">
                    <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium"><?php echo e(session('error')); ?></span>
                    <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>

<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\Users\USER\Project PBL final\pbl-payment-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>