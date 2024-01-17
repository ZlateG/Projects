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

    {{-- apartmants --}}
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3 mt-5">Resort <span class="text-red-500 font-bold">"{{ $apartment->resort->resort_name }}"</span> Apartments Edit</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">
                    
                     <!-- Update Apartment Form -->
                     <form action="{{ route('apartments.update', ['id' => $apartment->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                    
                        <!-- Apartment Information -->
                        <label for="apartment_name">Apartment Name:</label>
                        <input class="rounded block w-full" type="text" id="apartment_name" name="apartment_name" value="{{ $apartment->apartment_name }}">
                    
                        <label for="apartment_description">Apartment Description:</label>
                        <textarea id="apartment_description" class="block rounded w-full" name="apartment_description">{{ $apartment->apartment_description }}</textarea>
                    
                        <button type="submit" class="w-full bg-blue-300 my-3 p-1 border border-blue-500 hover:bg-blue-500 rounded">Update Apartment</button>
                    </form>
                    <button id="add_new_price" class=" bg-blue-300 my-3 p-1 border border-blue-500 hover:bg-blue-500 rounded">add new price</button>
                    <!-- Apartment Information Form -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                    <div class="bg-green-300 rounded block p-1 text-center">
                        {{ session('success') }}
                    </div>
                @endif           
                @error('price')
                    <div class="bg-red-300 rounded block p-1 text-center">{{ $message }}</div>
                @enderror

                @error('start_date')
                    <div class="bg-red-300 rounded block text-center">{{ $message }}</div>
                @enderror

                @error('end_date')
                    <div class="bg-red-300 rounded block text-center">{{ $message }}</div>
                @enderror
                <table>
                    <thead>
                        <tr>
                            <th>Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($apartment->prices as $index => $price)
                            <form action="{{ route('prices.update', ['priceId' => $price->id]) }}" method="post">
                                @csrf
                                @method('PUT')
                                <!-- Display errors for the "price" field -->

                                <tr class="rounded mb-2">
                                    <td>
                                        <label for="price_{{ $index }}">Price:</label>
                                        <input type="text" id="price_{{ $index }}" name="price" value="{{ $price->price }}">
                                    </td>
                                    <td>
                                        <label for="start_date_{{ $index }}">Start Date:</label>
                                        <input type="date" id="start_date_{{ $index }}" name="start_date" value="{{ $price->start_date }}">
                                    </td>
                                    <td>
                                        
                                        <label for="end_date_{{ $index }}">End Date:</label>
                                        <input type="date" id="end_date_{{ $index }}" name="end_date" value="{{ $price->end_date }}">
                                    </td>
                    
                                    <td>
                                        <button type="submit" class="bg-green-400 border border-bg-green-500 hover:bg-green-500 p-1 rounded">Update Price</button>
                                    </form>
                                        <button class="delete-price bg-red-300 border border-bg-red-500 hover:bg-red-500 p-1 ml-2 rounded"  data-price-id="{{ $price->id }}">Delete</button>
                                    </td>
                                    
                                </tr>
                        @empty
                            <tr>
                                <td colspan="4">No prices available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        
    
    <div id="overlay2" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

    <!-- Modal for Apartmant -->
    <div id="apartmentPriceModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeApartmantPriceModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new Apartment</h2>
                    <form action="{{ route('prices.store') }}" method="post">
                        @csrf
                        <input type="number" name="apartmant_id" hidden value="{{ $apartment->id }}">
                        <label for="price">Price:</label>
                        <x-input id="price" value="{{ old('price') }}" class="block mt-1 w-full mb-2" type="number" name="price" />

                        <label for="start_date">Start Date:</label>
                        <x-input id="start_date" value="{{ old('start_date') }}" class="block mt-1 w-full mb-3" type="date" name="start_date" />

                        <label for="end_date">End Date:</label>
                        <x-input id="end_date" value="{{ old('end_date') }}" class="block mt-1 w-full mb-3" type="date" name="end_date" />



                        <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Submit</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
