@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Pesanan Saya</h1>
        <p class="text-slate-600">Riwayat dan status pesanan Anda</p>
    </div>

    @forelse ($orders as $order)
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-4 hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-4">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <h2 class="font-bold text-xl text-slate-800">Pesanan #{{ $order->id }}</h2>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @switch($order->status)
                                @case('pending')
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @case('confirmed')
                                    bg-blue-100 text-blue-800
                                    @break
                                @case('shipped')
                                    bg-green-100 text-green-800
                                    @break
                                @case('cancelled')
                                    bg-red-100 text-red-800
                                    @break
                            @endswitch
                        ">
                            @switch($order->status)
                                @case('pending')
                                    Menunggu
                                    @break
                                @case('confirmed')
                                    Dikonfirmasi
                                    @break
                                @case('shipped')
                                    Dikirim
                                    @break
                                @case('cancelled')
                                    Dibatalkan
                                    @break
                            @endswitch
                        </span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 space-x-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $order->created_at->format('d F Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $order->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-sm text-slate-500 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-blue-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <h3 class="font-semibold text-slate-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Item Pesanan
                </h3>
                <div class="space-y-3">
                    @foreach ($order->orderItems as $item)
                        <div class="flex justify-between items-center py-2 px-4 bg-slate-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-16 bg-slate-200 rounded flex-shrink-0 overflow-hidden">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                             alt="{{ $item->book->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $item->book->title }}</p>
                                    <p class="text-sm text-slate-500">{{ $item->quantity }} × Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="font-semibold text-slate-800">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center space-x-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Butuh bantuan? <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Hubungi kami</a></span>
                </div>
                <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                    <span>Belanja Lagi</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-16">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-32 h-32 text-slate-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Pesanan</h2>
                <p class="text-slate-500 mb-8">Anda belum memiliki riwayat pesanan</p>
                <a href="{{ route('books.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Mulai Belanja</span>
                </a>
            </div>
        </div>
    @endforelse

    @if($orders->count() > 0)
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
@endsection