<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookstore</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans antialiased">

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <a href="{{ route('books.index') }}" class="flex items-center space-x-2 group">
                <svg class="w-8 h-8 text-slate-800 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-2xl font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Bookstore</span>
            </a>
            
            <div class="flex items-center space-x-6">
                <a href="{{ route('cart.index') }}" class="relative group">
                    <div class="p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6 text-slate-700 group-hover:text-blue-600 transition-colors" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    @php
                        $cartCount = count(session('cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-blue-600 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center font-semibold shadow-lg">{{ $cartCount }}</span>
                    @endif
                </a>
                
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-blue-600 font-medium transition-colors">Masuk</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors shadow-sm">Daftar</a>
                    @endif
                @else
                    @if(Auth::user()->is_admin)
                        <a href="/admin" class="px-4 py-2 text-blue-600 hover:text-blue-700 font-medium transition-colors">Panel Admin</a>
                    @endif
                    <a href="{{ route('my-orders.index') }}" class="px-4 py-2 text-slate-700 hover:text-blue-600 font-medium transition-colors">Pesanan Saya</a>
                    
                    <div class="flex items-center space-x-3 pl-3 border-l border-slate-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-slate-700 font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="px-4 py-2 text-slate-600 hover:text-red-600 font-medium transition-colors">
                                Keluar
                            </a>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto px-6 py-8 min-h-screen">
    @yield('content')
</main>

@if (session('success') || session('error'))
    <div id="toast-notification" class="fixed bottom-6 right-6 z-50 animate-slide-in">
        @if (session('success'))
            <div class="toast-message bg-white border-l-4 border-green-500 text-slate-800 py-4 px-6 rounded-lg shadow-xl flex items-center space-x-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="toast-message bg-white border-l-4 border-red-500 text-slate-800 py-4 px-6 rounded-lg shadow-xl flex items-center space-x-3">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>
    
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-notification');
            if (toast) {
                toast.style.transition = 'opacity 0.3s ease-out';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    </script>
@endif

<footer class="bg-white border-t border-slate-200 mt-16">
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-slate-600 font-medium">Bookstore</span>
            </div>
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} Bookstore. Semua Hak Cipta Dilindungi.
            </p>
            <div class="flex space-x-6">
                <a href="#" class="text-slate-500 hover:text-slate-700 transition-colors text-sm">Kebijakan Privasi</a>
                <a href="#" class="text-slate-500 hover:text-slate-700 transition-colors text-sm">Ketentuan Layanan</a>
                <a href="#" class="text-slate-500 hover:text-slate-700 transition-colors text-sm">Kontak</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>