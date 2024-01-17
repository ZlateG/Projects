<!-- resources/views/testimonials/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @auth
                {{ __('Hello, ') }} {{ auth()->user()->name }}
            @else
                {{ __('Welcome') }}
            @endauth
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">

                        <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3 mb-5">Edit Moment</h2>
                        @if(session('success'))
                            <div class="text-lg text-green-500">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="text-red-500">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('moment.update', $moment->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <label for="title">Title:</label>
                            <x-input id="title" value="{{ $moment->title }}" class="block mt-1 w-full mb-5" type="text" name="title" />

                            <label for="image">Image:</label>
                            <img src="{{ asset('storage/' . $moment->filename) }}" class="mb-4 h-56" alt="Moment Image" class="mb-4">
                            <input type="file" name="image" accept="image/*" >

                            <button type="submit">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
