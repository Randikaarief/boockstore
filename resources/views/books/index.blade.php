@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Temukan Buku</h1>
        <p class="text-slate-600">Temukan bacaan favorit Anda berikutnya dari koleksi kami</p>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="md:w-1/3">
            <form action="{{ route('books.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Cari buku atau penulis..."
                       value="{{ request('search') }}"
                       class="flex-grow px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Cari</button>
            </form>
        </div>
        <div class="md:w-1/4">
            <form action="{{ route('books.index') }}" method="GET">
                <select name="genre" onchange="this.form.submit()"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Genre</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($books as $book)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group border border-slate-100">
                <a href="{{ route('books.show', $book) }}" class="block relative overflow-hidden">
                    @if ($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-64 bg-slate-100 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-slate-400 text-sm">Tanpa Gambar</span>
                            </div>
                        </div>
                    @endif
                </a>
                
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2 line-clamp-2 min-h-[3.5rem]">
                        <a href="{{ route('books.show', $book) }}" 
                           class="text-slate-800 hover:text-blue-600 transition-colors">
                            {{ $book->title }}
                        </a>
                    </h3>
                    
                    <p class="text-slate-600 text-sm mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $book->author }}
                    </p>

                    <div class="mb-4 flex flex-wrap gap-2">
                        @foreach ($book->genres as $genre)
                            <span class="inline-block bg-slate-100 text-slate-600 rounded-full px-3 py-1 text-xs font-semibold">{{ $genre->name }}</span>
                        @endforeach
                    </div>
                    
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <div>
                            <p class="text-xs text-slate-500 mb-0.5">Harga</p>
                            <span class="font-bold text-xl text-blue-600">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                        </div>
                        
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2 text-sm font-medium shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Tambah</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16">
                <svg class="w-24 h-24 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="text-slate-500 text-lg font-medium mb-2">Tidak ada buku yang ditemukan</p>
                <p class="text-slate-400 text-sm">Cek kembali nanti untuk buku baru</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $books->links() }}
    </div>
@endsection