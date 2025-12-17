@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Keranjang Belanja</h1>
        <p class="text-slate-600">Kelola item yang akan Anda beli</p>
    </div>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
                @php $total = 0 @endphp
                @foreach($cart as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6" data-id="{{ $id }}">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex-shrink-0">
                                <img src="{{ $details['cover_image'] ? asset('storage/' . $details['cover_image']) : asset('images/no-image.png') }}" 
                                     alt="{{ $details['name'] }}"
                                     class="w-24 h-32 object-cover rounded-lg">
                            </div>

                            <div class="flex-grow">
                                <h3 class="font-bold text-lg text-slate-800 mb-2">{{ $details['name'] }}</h3>
                                <p class="text-blue-600 font-semibold text-xl mb-4">Rp{{ number_format($details['price'], 0, ',', '.') }}</p>

                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-3">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                                            <button type="button" onclick="decrementCartQty(this)" class="px-3 py-2 bg-slate-50 hover:bg-slate-100 transition-colors">
                                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $details['quantity'] }}" 
                                                   min="1"
                                                   class="w-16 text-center border-0 focus:ring-0 font-semibold text-slate-800">
                                            <button type="button" onclick="incrementCartQty(this)" class="px-3 py-2 bg-slate-50 hover:bg-slate-100 transition-colors">
                                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                            Perbarui
                                        </button>
                                    </form>

                                    <div class="flex items-center justify-between sm:justify-end gap-4">
                                        <div class="text-right">
                                            <p class="text-xs text-slate-500 mb-0.5">Subtotal</p>
                                            <p class="font-bold text-lg text-slate-800">Rp{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Ringkasan Belanja</h2>
                    
                    <div class="space-y-3 mb-6 pb-6 border-b border-slate-200">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal ({{ count($cart) }} item)</span>
                            <span class="font-semibold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Pengiriman</span>
                            <span class="font-semibold text-green-600">Gratis</span>
                        </div>
                    </div>

                    <div class="flex justify-between text-xl font-bold text-slate-800 mb-6">
                        <span>Total</span>
                        <span class="text-blue-600">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    @auth
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors shadow-sm flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span>Beli</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-full bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors shadow-sm flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Login untuk Checkout</span>
                        </a>
                    @endauth

                    <a href="{{ route('books.index') }}" class="w-full mt-3 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Lanjut Belanja</span>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-16">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-32 h-32 text-slate-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Keranjang Anda Kosong</h2>
                <p class="text-slate-500 mb-8">Belum ada item di keranjang. Yuk mulai belanja!</p>
                <a href="{{ route('books.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Mulai Belanja</span>
                </a>
            </div>
        </div>
    @endif

    <script>
        function incrementCartQty(btn) {
            const input = btn.parentElement.querySelector('input[type="number"]');
            input.value = parseInt(input.value) + 1;
        }

        function decrementCartQty(btn) {
            const input = btn.parentElement.querySelector('input[type="number"]');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endsection