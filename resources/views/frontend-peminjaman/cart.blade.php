@extends('layouts.app')

@section('content')
<h2>Keranjang Peminjaman</h2>
@if(session('cart'))
    <table>
        <tr>
            <th>Nama Alat</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        @foreach(session('cart') as $id => $details)
            <tr>
                <td>{{ $details['name'] }}</td>
                <td>{{ $details['quantity'] }}</td>
                <td>
                    <form action="{{ route('alat.frontend.removeFromCart', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>Keranjang kosong</p>
@endif
@endsection
