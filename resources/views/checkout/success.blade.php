@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <h1 class="text-2xl font-bold mb-4 text-green-600">Terima Kasih!</h1>
        <p class="text-gray-700">Pesanan Anda telah berhasil ditempatkan.</p>
        <p class="text-gray-700">Anda akan diberitahu setelah admin mengkonfirmasi pesanan Anda.</p>
        <a href="{{ route('books.index') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6">
            Lanjutkan Belanja
        </a>
    </div>
@endsection
