<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – PBL Payment System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-grid {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.08) 1px, transparent 0);
            background-size: 28px 28px;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float { animation: float 4s ease-in-out infinite; }
        .float-slow { animation: float 6s ease-in-out infinite 1s; }
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fade-up 0.6s ease both; }
        .fade-up-2 { animation: fade-up 0.6s ease 0.1s both; }
        .fade-up-3 { animation: fade-up 0.6s ease 0.2s both; }
        input:focus { outline: none; }
        .input-field {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fff;
        }
        .input-field:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.5); }
        .btn-login:active { transform: translateY(0); }
    </style>
</head>
<body class="min-h-screen flex" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);">

    {{-- Decorative background --}}
    <div class="absolute inset-0 bg-grid opacity-40"></div>
    <div class="absolute top-20 left-20 w-64 h-64 bg-indigo-500 rounded-full filter blur-3xl opacity-20 float"></div>
    <div class="absolute bottom-20 right-20 w-80 h-80 bg-purple-500 rounded-full filter blur-3xl opacity-15 float-slow"></div>

    <div class="relative w-full flex flex-col lg:flex-row">

        {{-- Left panel (branding) --}}
        <div class="hidden lg:flex flex-1 flex-col justify-center px-16 py-12">
            <div class="max-w-md">
                <div class="w-14 h-14 rounded-2xl mb-8 flex items-center justify-center"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-white leading-tight mb-4">
                    PBL Payment<br>System
                </h1>
                <p class="text-indigo-200 text-lg leading-relaxed mb-10">
                    Sistem manajemen pembayaran terpadu untuk pulsa internet, asuransi BPJS, dan uang saku peserta pelatihan.
                </p>
                <div class="space-y-4">
                    @foreach([['📱','Pulsa Internet','Kelola pembayaran pulsa harian peserta'],['🛡️','Asuransi BPJS','Manajemen premi asuransi otomatis'],['💰','Uang Saku','Kalkulasi dan distribusi uang saku']] as $f)
                    <div class="flex items-center gap-4" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border-radius: 12px; padding: 14px 16px; border: 1px solid rgba(255,255,255,0.1);">
                        <span class="text-2xl">{{ $f[0] }}</span>
                        <div>
                            <p class="text-white font-semibold text-sm">{{ $f[1] }}</p>
                            <p class="text-indigo-300 text-xs">{{ $f[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right panel (form) --}}
        <div class="flex-1 lg:max-w-md flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-sm fade-up">
                {{-- Mobile logo --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center"
                         style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-extrabold text-white">PBL Payment</h2>
                </div>

                {{-- Card --}}
                <div class="bg-white rounded-2xl p-8 shadow-2xl">
                    <div class="mb-6 fade-up-2">
                        <h2 class="text-2xl font-bold text-slate-800">Selamat datang 👋</h2>
                        <p class="text-slate-500 text-sm mt-1">Masuk ke akun admin Anda</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-4 flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm fade-up-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4 fade-up-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <div class="relative">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <input type="email" name="email" value="{{ old('email', 'admin@test.com') }}"
                                       class="input-field pl-10" placeholder="admin@email.com" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                            <div class="relative" x-data="{ show: false }">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <input :type="show ? 'text' : 'password'" name="password" value="password"
                                       class="input-field pl-10 pr-10" placeholder="••••••••" required>
                                <button type="button" @click="show = !show"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-login">
                                Masuk ke Dashboard
                            </button>
                        </div>
                    </form>

                    <div class="mt-5 p-3 rounded-xl bg-indigo-50 border border-indigo-100">
                        <p class="text-xs text-indigo-700 font-semibold mb-1">Demo Account</p>
                        <p class="text-xs text-indigo-600">Email: admin@test.com · Password: password</p>
                    </div>
                </div>

                <p class="text-center text-indigo-300/60 text-xs mt-6">
                    © {{ date('Y') }} PBL Payment System · Nizar Alamsyah
                </p>
            </div>
        </div>
    </div>
</body>
</html>