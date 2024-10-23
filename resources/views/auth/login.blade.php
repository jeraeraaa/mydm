@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <h2 class="text-3xl font-semibold text-center">Login</h2>
        <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto mt-6">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" class="w-full px-3 py-2 border rounded-md" required
                    autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input id="password" type="password" name="password" class="w-full px-3 py-2 border rounded-md" required>
            </div>

            <div class="flex items-center justify-between mb-4">
                <button type="submit" class="px-4 py-2 font-semibold text-white bg-orange-500 rounded-md">Login</button>
            </div>
        </form>
    </div>
@endsection


