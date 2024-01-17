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

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3">Edit Resort</h2>
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
                        <form action="{{ route('resort.update', $resort->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                   
                            <label for="resort_name">Name of Resort:</label>
                            <x-input id="resort_name" value="{{ $resort->resort_name }}"  class="mb-5 block mt-1 w-full" type="text" name="resort_name" />
                            <label for="edit_resort_description">Resort Description:</label>
                            <x-input id="edit_resort_description" value="{{ $resort->resort_description }}" class="mb-5 block mt-1 w-full" type="text" name="resort_description" />
                                
                            @if($resort->images->isNotEmpty())
                                <div class="w-1/2">
                                    <label>Resort Image:</label>
                                    <img style="max-width: 100%; max-height: 300px;" src="{{ asset('storage/' . $resort->images->first()->image_path) }}" alt="Resort Image" class="mb-4 rounded">
                                </div>
                            @endif
                            <label for="edit_image">New Resort Image:</label>
                            <input id="edit_image" class="mb-5 block mt-1 w-full" type="file" name="new_image" accept="image/*" />

                            
                            <select name="resort_type" class="rounded">
                                @foreach($resortTypes as $resortType)
                                    <option value="{{ $resortType->id }}" {{ $resortType->id == $resort->resort_type ? 'selected' : '' }}>
                                        {{ $resortType->type }}
                                    </option>
                                @endforeach
                            </select>
                                
                    
                            <label for="edit_country_id">Country:</label>
                            <select name="country_id" id="edit_country_id" onchange="getCitiesEditForm(this.value)" class="rounded">
                                <option value="" disabled>Select a country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $resort->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>


                            <label for="edit_city_id">City:</label>
                            <select name="city_id" id="edit_city_id" class="rounded">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $resort->city_id == $city->id ? 'selected' : '' }}>
                                        {{ $city->city_name }} .{{  $city->country->country_name }}
                                    </option>
                                @endforeach
                            </select>

                    
                            <button type="submit" class="bg-blue-300 hover:bg-blue-400 border border-blue-500 p-1 rounded">Update Resort</button>
                        </form>
                    

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- apartmants --}}
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3 mt-5">Resort <span class="text-red-500 font-bold">"{{ $resort->resort_name }}"</span> Apartments</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">
                        <button id="newApartmantBtn" class="bg-blue-300 mb-5 hover:bg-blue-400 border border-blue-500 p-1 rounded">add new Apartment</button>
                        @foreach($resort->apartments as $apartment)
                            <div class="flex">
                                <div class="border p-4 rounded-md shadow-md mb-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $apartment->apartment_name }}</h3>
                                    <p>{{ $apartment->apartment_description }}</p>
                                    <a href="{{ route('apartments.edit', ['id' => $apartment->id]) }}" class="bg-blue-300 border rounded border-blue-500 hover:bg-blue-500 p-1">Edit Apartment</a>
            
                                    <form action="{{ route('apartments.softDelete', ['id' => $apartment->id]) }}" method="post" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-300 border border-red-500 rounded p-1 hover:bg-red-400 inline mb-3">Remove Apartmant</button>
                                    </form>
                                    <table class="table-auto w-full border border-gray-400">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 border border-gray-400">Start Date</th>
                                                <th class="px-4 py-2 border border-gray-400">End Date</th>
                                                <th class="px-4 py-2 border border-gray-400">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($apartment->prices as $price)
                                                <tr>
                                                    <td class="px-4 py-2 border border-gray-400">{{ $price->start_date }}</td>
                                                    <td class="px-4 py-2 border border-gray-400">{{ $price->end_date }}</td>
                                                    <td class="px-4 py-2 border border-gray-400">{{ $price->price }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-4 py-2">No prices available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                               
                                <div class="img ml-2">
                                    <div class="grid grid-cols-4 gap-2">
                                       
                                        
                                        @foreach($apartment->images as $image)
                                        <div class="relative">
                                            <img style="max-width: 100%; max-height: 300px;" src="{{ asset('storage/' . $image->image_path) }}" alt="Apartment Image" class="mb-4 rounded">
                                            <button data-image-id="{{ $image->id }}" class="bg-red-300 border border-red-500 rounded p-1 hover:bg-red-400 inline mb-3 delete-image-btn">Delete Image</button>
                                        </div>
                                    @endforeach
                                        
                                        
                                      
                                    </div>
                                    <button data-apartment-id="{{ $apartment->id }}" class="bg-blue-300 hover:bg-blue-400 border border-blue-500 p-1 rounded add-image-btn"> Add new image</button>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- trashed apartmants --}}
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-lg text-blue-500 bg-red-100 text-center p-3 mt-5">Resort  <span class="text-red-500 font-bold">"{{ $resort->resort_name }}"</span> Removed Apartments</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">
                    
                        @forelse($trashedApartments as $apartment)
                            <div class="flex">
                                <div class="border p-4 rounded-md shadow-md mb-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $apartment->apartment_name }}</h3>
                                    <p>{{ $apartment->apartment_description }}</p>
                                    <div class="flex justify-between">
                                        <form id="deleteForm_{{ $apartment->id }}" data-apartment-id="{{ $apartment->id }}" action="{{ route('apartments.permDelete', ['id' => $apartment->id]) }}" method="post" class="inline delete_apartmant">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-red-300 border delete_apartmant border-red-500 rounded p-1 hover:bg-red-400 inline mb-3">Delete Apartment</button>
                                        </form>
                                        
                                        <form action="{{ route('apartments.restore', $apartment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1 mb-2">Restore Resort</button>
                                        </form>
                                    </div>
                                    <table class="table-auto w-full border border-gray-400">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 border border-gray-400">Start Date</th>
                                                <th class="px-4 py-2 border border-gray-400">End Date</th>
                                                <th class="px-4 py-2 border border-gray-400">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($apartment->prices as $price)
                                                <tr>
                                                    <td class="px-4 py-2 border border-gray-400">{{ $price->start_date }}</td>
                                                    <td class="px-4 py-2 border border-gray-400">{{ $price->end_date }}</td>
                                                    <td class="px-4 py-2 border border-gray-400">{{ $price->price }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-4 py-2">No prices available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <p>No removed apartments available.</p>
                        @endforelse
                        
                        
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
    
    <div id="overlay2" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

    <!-- Modal for Apartmant -->
    <div id="apartmentModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeApartmantModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new Apartment</h2>
                    <form action="{{ route('apartments.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="number" name="resort_id" hidden value="{{ $resort->id }}">
                        <label for="apartment_name">Apartment Name:</label>
                        <x-input id="apartment_name" value="{{ old('apartment_name') }}" class="block mt-1 w-full mb-2" type="text" name="apartment_name" />

                        <label for="apartment_description">Apartment Description:</label>
                        <x-input id="apartment_description" value="{{ old('apartment_description') }}" class="block mt-1 w-full mb-3" type="text" name="apartment_description" />


                        <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Submit</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
    {{-- images modal --}}
    <div id="imageApartmantModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeImageApartmantModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Add image for selected Apartment</h2>
                    <form action="{{ route('apartmantImage.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="apartmentIdInput" name="apartmant_id">
                        <label for="images">Select Images:</label>
                        <input type="file" name="images[]" id="images" class="mb-3" multiple accept="image/*">
                
                        <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Upload Images</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
