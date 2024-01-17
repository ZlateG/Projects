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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">

                        <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3">Your Moments</h2>
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
                        
                        
                        <button id="newMoment" class="bg-blue-300 hover:bg-blue-500 border border-blue-500 p-1 rounded my-2">Create New Moment</button>
                   
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            @if(isset($moments
                            ) && count($moments) > 0)
                            @foreach($moments as $moment)
                                <div class="border p-2 rounded-md shadow-md">
                                    <img src="{{ asset('storage/' . $moment->filename) }}" alt="Testimonial Image" class="mb-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $moment->title }}</h3>
                                
                                    <div class="flex space-x-2">
                                        <form action="{{ route('moments.remove', $moment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2">Remove</button>
                                        </form>
                                        <a href="{{ route('moment.edit', $moment->id) }}" class="bg-blue-100 border mb-2 border-blue-400 hover:bg-blue-400 rounded p-1">Edit</a>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('moments.moveUp', $moment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="bg-blue-100 border border-blue-400 hover:bg-blue-400 rounded p-1">Move Up</button>
                                        </form>
                                        
                                        <form action="{{ route('moments.moveDown', $moment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1">Move Down</button>
                                        </form>
                                    </div>
                                    
                                </div>
                            @endforeach
                        @else
                            <p class="">No Moments available.</p>
                        @endif
                        
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">

                        <h2 class="text-lg text-blue-500 bg-red-100  text-center p-3">Removed Moments</h2>
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
                            
                            @if(isset($trashedMoments) && count($trashedMoments) > 0)
                            @foreach($trashedMoments as $trashedMoment)
                            <div class="border p-4 rounded-md shadow-md">

                                <img src="{{ asset('storage/' . $trashedMoment->filename) }}" alt="Testimonial Image" class="mb-4">
                                <h3 class="text-xl font-semibold mb-2">{{ $trashedMoment->title }}</h3>
                                {{-- <form id="deleteForm" action="{{ route('moments.delete', $trashedMoment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2" onclick="confirmDelete()">Delete</button>
                                </form> --}}
                                <form id="deleteForm_{{ $trashedMoment->id }}" action="{{ route('moments.delete', $trashedMoment->id) }}" method="POST" class="inline delete_moment">
                                    @csrf
                                    @method('DELETE')
                                    <button data-moment-id="{{ $trashedMoment->id }}" type="button" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2"">Delete</button>
                                </form>
                                <form action="{{ route('moments.restore', $trashedMoment->id)  }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1 mb-2">Restore Testimonial</button>
                                </form>
                            </div>
                            @endforeach
                            @else
                                <p>No removed moments available.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
 



    <div id="overlay2" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

   

    <!-- Modal for ContactUs User -->
    <div id="momentModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeMomentModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new Moment</h2>
                    <form action="{{ route('moments.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="title">Title:</label>
                        <x-input id="title" value="{{ old('title') }}" class="block mt-1 w-full" type="text" name="title" />



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
