<x-layout></x-layout>
@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h2>Daftar Alat</h2>
        <div class="row">
            @foreach ($alat as $item)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ url('storage/' . $item->foto) }}" alt="Foto Alat" class="card-img-top"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_alat }}</h5>
                            <p>{{ $item->deskripsi }}</p>
                            <button class="btn btn-primary" onclick="addToCart({{ $item->id_alat }})">Tambahkan ke
                                Keranjang</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function addToCart(id) {
            fetch(`/keranjang/add/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                });
        }
    </script>
@endsection
