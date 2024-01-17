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

    <div class="bg-red-400 border-red-500 hidden"></div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3">Testimonials</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">

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
                        
                        
                        <button id="newTestimonial" class="bg-blue-300 hover:bg-blue-500 border border-blue-500 p-1 rounded my-2">Create New Testimonial</button>
                   
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            @if(isset($testimonials) && count($testimonials) > 0)
                            @foreach($testimonials as $testimonial)
                                <div class="border p-2 rounded-md shadow-md">
                                    <img src="{{ asset('storage/' . $testimonial->filename) }}" alt="Testimonial Image" class="mb-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $testimonial->title }}</h3>
                                    <p class="text-gray-500 mb-2">{{ $testimonial->location }}</p>
                                    <p class="text-gray-700">{{ $testimonial->description }}</p>
                                    <p class="text-yellow-500">{{ str_repeat('★', $testimonial->rating) }}</p>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('testimonials.remove', $testimonial->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2">Remove</button>
                                        </form>
                                        <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="bg-blue-100 border mb-2 border-blue-400 hover:bg-blue-400 rounded p-1">Edit</a>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('testimonials.moveUp', $testimonial->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="bg-blue-100 border border-blue-400 hover:bg-blue-400 rounded p-1">Move Up</button>
                                        </form>
                                        
                                        <form action="{{ route('testimonials.moveDown', $testimonial->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1">Move Down</button>
                                        </form>
                                    </div>
                                    
                                </div>
                            @endforeach
                        @else
                            <p class="">No testimonials available.</p>
                        @endif
                        
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <h2 class="text-lg text-blue-500 bg-red-100  text-center p-3">Removed Testimonials</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">

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
                        
                        

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            
                            @if(isset($trashedTestimonials) && count($trashedTestimonials) > 0)
                            @foreach($trashedTestimonials as $trashedTestimonial)
                            <div class="border p-4 rounded-md shadow-md">

                                <img src="{{ asset('storage/' . $trashedTestimonial->filename) }}" alt="Testimonial Image" class="mb-4">
                                <h3 class="text-xl font-semibold mb-2">{{ $trashedTestimonial->title }}</h3>
                                <p class="text-gray-500 mb-2">{{ $trashedTestimonial->location }}</p>
                                <p class="text-gray-700">{{ $trashedTestimonial->description }}</p>
                                <p class="text-yellow-500">{{ str_repeat('★', $trashedTestimonial->rating) }}</p>
                        
                                {{-- <form id="deleteForm" action="{{ route('testimonials.delete', $trashedTestimonial->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2" onclick="confirmDelete()">Delete</button>
                                </form> --}}
                                <form id="deleteForm_{{ $trashedTestimonial->id }}" action="{{ route('testimonials.delete', $trashedTestimonial->id) }}" method="POST" class="inline delete_testimonial">
                                    @csrf
                                    @method('DELETE')
                                    <button data-testimonial-id="{{ $trashedTestimonial->id }}" type="button" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2"">Delete</button>
                                </form>
                                
                                
                                <form action="{{ route('testimonials.restore', $trashedTestimonial->id)  }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1 mb-2">Restore Testimonial</button>
                                </form>
                            </div>
                            @endforeach
                            @else
                                <p class="">No removed testimonials available.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
 



    <div id="overlay2" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

   

    <!-- Modal for testimonialModal User -->
    <div id="testimonialModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeTestimonialModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new Testimonial</h2>
                    <form action="{{ route('testimonials.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="title">Title:</label>
                        <x-input id="title" value="{{ old('title') }}" class="block mt-1 w-full" type="text" name="title" />

                        <label for="location">Location:</label>
                        <x-input id="location" value="{{ old('location') }}"  class="block mt-1 w-full" type="text" name="location" />

                        <label for="description">Description:</label>
                        <textarea  class="block mt-1 w-full rounded  mb-5" name="description">{{ old('description') }}</textarea>

                        <label for="rating" class="text-lg">Rating:</label>
                        {{-- <input type="number" value="{{ old('rating') }}" name="rating" min="1" max="5"> --}}
                        <label>
                            <input type="radio" name="rating" value="1" {{ old('rating') == '1' ? 'checked' : '' }}>
                            1
                        </label>
                        
                        <label>
                            <input type="radio" name="rating" value="2" {{ old('rating') == '2' ? 'checked' : '' }}>
                            2
                        </label>
                        
                        <label>
                            <input type="radio" name="rating" value="3" {{ old('rating') == '3' ? 'checked' : '' }}>
                            3
                        </label>
                        
                        <label>
                            <input type="radio" name="rating" value="4" {{ old('rating') == '4' ? 'checked' : '' }}>
                            4
                        </label>
                        
                        <label>
                            <input type="radio" name="rating" value="5" {{ old('rating') == '5' ? 'checked' : '' }}>
                            5
                        </label>
                        

                        <label for="image" class="block mt-5 text-lg">Image:</label>
                        <input type="file" name="image" class="block mb-5" accept="image/*" >

                        <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Submit</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
    
 
</x-app-layout>
