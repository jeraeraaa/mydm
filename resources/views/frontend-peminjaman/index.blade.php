@extends('layouts.app')

@section('content')
<h2>Daftar Alat yang Tersedia</h2>
<div class="alat-container">
    @foreach($alat as $item)
        <div class="alat-item">
            <h3>{{ $item->name }}</h3>
            <p>Kondisi: {{ $item->status }}</p>
            <a href="{{ route('alat.frontend.show', $item->id) }}" class="btn btn-info">Lihat Detail</a>
            <form action="{{ route('alat.frontend.addToCart', $item->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
