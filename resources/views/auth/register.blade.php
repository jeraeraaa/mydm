@extends('layouts.app')

@section('content')
<div class="font-[sans-serif] bg-white w-full h-screen flex items-center justify-center p-0 m-0"> <!-- Menggunakan w-full dan h-screen untuk layar penuh -->
    <div class="grid grid-cols-2 items-center w-full h-full max-w-screen-xl mx-auto"> <!-- Menggunakan max-w-screen-xl untuk lebar seragam dengan navbar -->
        <!-- Bagian Kiri -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white p-8 h-full flex flex-col justify-center space-y-12 w-full"> <!-- Menambahkan w-full dan memastikan elemen kiri menempel ke tepi kiri -->
            <div>
                <h4 class="text-lg font-semibold">Create Your Account</h4>
                <p class="text-[13px] mt-3 leading-relaxed">Welcome to our registration page! Get started by creating your account.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold">Simple & Secure Registration</h4>
                <p class="text-[13px] mt-3 leading-relaxed">Our registration process is designed to be straightforward and secure. We prioritize your privacy and data security.</p>
            </div>
        </div>

        <!-- Bagian Form -->
        <form method="POST" action="{{ route('register') }}" class="w-full flex flex-col justify-center px-12 py-16 bg-white h-full"> <!-- Full width form -->
            @csrf

            <div class="mb-8">
                <h3 class="text-gray-800 text-3xl font-bold">Create an account</h3>
            </div>

            <div class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Name</label>
                    <div class="relative flex items-center">
                        <input name="name" type="text" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md outline-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter name" value="{{ old('name') }}" />
                        @error('name')
                            <span class="invalid-feedback text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Email</label>
                    <div class="relative flex items-center">
                        <input name="email" type="email" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md outline-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter email" value="{{ old('email') }}" />
                        @error('email')
                            <span class="invalid-feedback text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Password</label>
                    <div class="relative flex items-center">
                        <input name="password" type="password" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md outline-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter password" />
                        @error('password')
                            <span class="invalid-feedback text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Confirm Password</label>
                    <div class="relative flex items-center">
                        <input name="password_confirmation" type="password" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-2.5 rounded-md outline-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Confirm password" />
                    </div>
                </div>

                <!-- Remember Me (Optional) -->
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring focus:ring-blue-500 border-gray-300 rounded" />
                    <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                        I accept the <a href="javascript:void(0);" class="text-blue-600 font-semibold hover:underline ml-1">Terms and Conditions</a>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-12">
                <button type="submit" class="w-full py-3 px-4 tracking-wider text-sm rounded-md text-white bg-gray-700 hover:bg-gray-800 focus:outline-none">
                    Create an account
                </button>
            </div>

            <p class="text-gray-800 text-sm mt-6 text-center">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a></p>
        </form>
    </div>
</div>
@endsection
