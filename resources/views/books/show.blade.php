@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('books.index') }}" class="inline-flex items-center text-slate-600 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Buku
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            <div class="bg-slate-50 p-8 flex items-center justify-center">
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         alt="{{ $book->title }}" 
                         class="w-full max-w-md h-auto rounded-lg shadow-lg">
                @else
                    <div class="w-full max-w-md h-96 bg-slate-100 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="text-slate-400">Gambar Tidak Tersedia</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="p-8 lg:p-10">
                <div class="mb-6">
                    @foreach ($book->genres as $genre)
                        <span class="inline-block bg-blue-50 text-blue-700 rounded-full px-3 py-1 text-xs font-semibold mr-2 mb-2">{{ $genre->name }}</span>
                    @endforeach
                </div>

                <h1 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-3">{{ $book->title }}</h1>
                
                <div class="flex items-center text-slate-600 mb-6">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-lg">oleh <span class="font-semibold text-slate-800">{{ $book->author }}</span></span>
                </div>

                <div class="prose prose-slate max-w-none mb-8">
                    <p class="text-slate-600 leading-relaxed">{{ $book->description }}</p>
                </div>

                <div class="border-t border-slate-200 pt-6 mb-6">
                    <div class="flex items-baseline justify-between mb-6">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Harga</p>
                            <span class="font-bold text-4xl text-blue-600">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500 mb-1">Stok Tersedia</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $book->stock > 10 ? 'bg-green-100 text-green-800' : ($book->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $book->stock }} unit
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah</label>
                                <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                                    <button type="button" onclick="decrementQty()" class="px-4 py-3 bg-slate-50 hover:bg-slate-100 transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $book->stock }}" 
                                           class="w-20 text-center border-0 focus:ring-0 font-semibold text-slate-800">
                                    <button type="button" onclick="incrementQty()" class="px-4 py-3 bg-slate-50 hover:bg-slate-100 transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex-grow">
                                <label class="block text-sm font-medium text-slate-700 mb-2">&nbsp;</label>
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors shadow-sm flex items-center justify-center space-x-2"
                                        {{ $book->stock == 0 ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>{{ $book->stock > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const qtyInput = document.getElementById('quantity');
        const maxStock = {{ $book->stock }};

        function incrementQty() {
            const currentVal = parseInt(qtyInput.value);
            if (currentVal < maxStock) {
                qtyInput.value = currentVal + 1;
            }
        }

        function decrementQty() {
            const currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        }
    </script>
@endsection