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
            <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3">Edit Testimonial</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child w-1/2">

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

                     
                        <div class="flex justify-center">
                            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="post" enctype="multipart/form-data" >
                                @csrf
                                @method('PUT')

                                <label for="title">Title:</label>
                                <input type="text" value="{{ $testimonial->title }}" name="title" class="block mb-2 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                                <label for="location">Location:</label>
                                <input type="text" value="{{ $testimonial->location }}" name="location"  class="block mb-2 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                                <label for="description">Description:</label>
                                <textarea name="description" class="block w-full mb-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    {{ $testimonial->description }}
                                </textarea>

                                <label for="rating">Rating:</label>
                                <input type="number" value="{{ $testimonial->rating }}" name="rating" min="1" max="5"  class="block mb-2 w-1/2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                                @if ($testimonial->filename)
                                    <div>
                                        <label>Current Image:</label>
                                        <img src="{{ asset('storage/' . $testimonial->filename) }}" alt="Current Image" class="mb-4 border rounded w-1/2">
                                        <label for="new_image">Change Image:</label>
                                    </div>
                                @endif

                                <input type="file" name="new_image" accept="image/*" >

                                <button type="submit" class="block w-full mt-3 bg-blue-300 p-1 border border-blue-500 hover:bg-blue-400 rounded">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
