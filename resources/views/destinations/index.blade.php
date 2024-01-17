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

    {{-- Countries/Cities --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <h1 class="text-xl font-bold underline mb-2">Countries/Cities:</h1>
            @if($errors->any())
                <div class="text-red-500 text-xl underline">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="text-lg text-green-500 underline">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-around">
                    <div class="child mr-5">
                        <h2 class="text-lg font-bold underline mb-2">Countries:</h2>
                        @php
                            $counter = 0;
                        @endphp
                        <ul>
                            @foreach ($countries as $country)
                            <li class="mb-2">
                                {{ ++$counter }}.
                                {{ $country->country_name }}   
                                <a href="{{ route('country.edit', $country->id) }}" class="bg-blue-100 border mb-2 border-blue-400 hover:bg-blue-400 inline rounded p-1">Edit</a>
                                <form action="{{ route('countries.softDelete', ['id' => $country->id]) }}" method="post" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-300 border border-red-500 rounded p-1 inline hover:bg-red-400">Remove Country</button>
                                </form>
                            </li>
                            @endforeach
                            <li id="newCountry" class="bg-blue-300 mt-5 p-1 border border-blue-500 rounded hover:bg-blue-400">Add new Country</li>
                        </ul>

                    </div>
                    <div class="child mr-5">
                        <h2 class="text-lg font-bold underline mb-2">Removed Countries:</h2>
                        @php
                            $counter = 0;
                        @endphp
                        <ul>
                            @foreach ($trashedCountries as $trashedCountry)
                            <li class="mb-2">
                                {{ ++$counter }}.
                                {{ $trashedCountry->country_name }}   
                                <form action="{{ route('countries.restore', $trashedCountry->id)  }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1 mb-2">Restore Country</button>
                                </form>
                        
                            </li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="child">
                        <h2 class="text-lg font-bold underline">Cities:</h2>
                        <ul>
                            @php
                                $counter1 = 0;
                            @endphp
                            @foreach ($cities as $city)
                                <li class="mb-2">
                                {{ ++$counter1 }}. {{ $city->city_name }} ({{ $city->country->country_name }})
                                <a href="{{ route('city.edit', $city->id) }}" class="bg-blue-100 border mb-2 border-blue-400 hover:bg-blue-400 rounded p-1">Edit</a>
                                <form action="{{ route('cities.softDelete', ['id' => $city->id]) }}" method="post" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-300 border border-red-500 rounded p-1 hover:bg-red-400 inline">Remove city</button>
                                </form>
                            </li>

                            @endforeach
                            <li id="newCity" class="bg-blue-300 mt-5 p-1 border border-blue-500 rounded hover:bg-blue-400">Add new City</li>

                        </ul>

                    </div>
                    <div class="child">
                        <h2 class="text-lg font-bold underline">Removed Cities:</h2>
                        <ul>
                            @php
                                $counter1 = 0;
                            @endphp
                            @foreach ($trashedCities as $trashedCity)
                            <li>
                                {{ ++$counter1 }}. {{ $trashedCity->city_name }}      
                                @if ($trashedCity->country)
                                    ({{ $trashedCity->country->country_name }})
                                    <form action="{{ route('cities.restore', $trashedCity->id)  }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1 mb-2">Restore City</button>
                                    </form>
                                @elseif ($country = $trashedCountries->firstWhere('id', $trashedCity->country_id))
                                    (removed - {{ $country->country_name }})
                                @else
                                    (country id: {{ $trashedCity->country_id }})
                                @endif
                        
                            </li>

                            @endforeach

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Resorts --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <h2 class="text-xl font-bold underline mb-2">Resorts:</h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-around">
                    <div class="child">
                        <button id="newResort" class="bg-blue-300 mt-5 p-1 border border-blue-500 rounded hover:bg-blue-400 mb-5">Add new Resort</button>

                        @foreach ($resorts as $cityId => $cityResorts)
                            <div class="border border-gray-200 p-2 mb-3 rounded shadow-md">
                                <h2 class="text-xl font-semibold mb-4">{{ $cityResorts->first()->city->city_name }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 ">
                                    @foreach ($cityResorts as $resort)
                                        <div class="border p-2 rounded-md shadow-md mb-4">
                                            @if ($resort->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $resort->images->first()->image_path) }}" alt="{{ $resort->resort_name }}" class="mb-4">
                                            @else
                                                <img src="https://infinity-travel-igor.vercel.app/images/arrangementsCountries/card-image-1.jpg" alt="Default Image" class="mb-4">
                                            @endif
                                            <h3 class="text-xl font-semibold mb-2">{{ $resort->resort_name }}</h3>
                                            <form action="{{ route('resorts.updateLastMinute', ['id' => $resort->id]) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <button class="text-gray-500 mb-2">
                                                    {!! $resort->last_minute_offer ? '<span class="bg-green-300 p-1 rounded hover:bg-transparent border border-green-500">Its last Minute</span>' : '<span class="p-1 border border-gray-300 rounded hover:bg-green-300">Not last Minute</span>' !!}
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('resorts.updateVisibility', ['id' => $resort->id]) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <button class="text-gray-500 mb-2">
                                                    {!! $resort->is_visible ? '<span class="bg-green-300 p-1 rounded hover:bg-transparent border border-green-500">Visible to users</span>' : '<span class="p-1 border border-gray-300 rounded hover:bg-green-300">Not Visible</span>' !!}
                                                </button>
                                            </form>        
                                            <p class="text-gray-700">Priority: {{ $resort->priority }}</p>
                                            
                                            <div class="flex space-x-2">
                                                <a href="{{ route('resort.edit', $resort->id) }}" class="bg-blue-100 inline border mb-2  border-blue-400 hover:bg-blue-400 rounded p-1">View</a>
                                                <form action="{{ route('resort.softDelete', ['id' => $resort->id]) }}" method="post" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-300 border border-red-500 rounded p-1 hover:bg-red-400 inline">Remove Resort</button>
                                                </form>
                                            </div>
                                            <div class="flex space-x-2">
                                                <form action="{{ route('resorts.moveUp', $resort->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="bg-blue-100 border border-blue-400 hover:bg-blue-400 rounded p-1">Move Up</button>
                                                </form>
                                                
                                                <form action="{{ route('resorts.moveDown', $resort->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1">Move Down</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Trashed Resorts --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-around ">
                    <div class="child">
                        <h2 class="text-lg font-bold underline">Removed Resorts:</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            @foreach ($trashedResorts as $trashedResort)
                                <div class="border p-2 rounded-md shadow-md mb-4">
                                    @if ($trashedImages->isNotEmpty())
                                        <img src="{{ asset('storage/' . $trashedImages->first()->image_path) }}" alt="{{ $trashedResort->resort_name }}" class="mb-4">
                                    @else
                                        <img src="https://infinity-travel-igor.vercel.app/images/arrangementsCountries/card-image-1.jpg" alt="Default Image" class="mb-4">
                                    @endif                                    <h3 class="text-xl font-semibold mb-2">{{ $trashedResort->resort_name }} - {{ optional($trashedResort->city)->city_name }}</h3>
                                    <p class="text-gray-500 mb-2">{{ $trashedResort->is_visible ? 'Visible' : 'Not Visible' }}</p>
                                    <p class="text-gray-700">Priority: {{ $trashedResort->priority }}</p>
                                    @php
                                        $softDeletedCity = \App\Models\City::onlyTrashed()->find($trashedResort->city_id);
                                    @endphp
                                    @if ($trashedResort->city)
                                    <form action="{{ route('resort.restore', $trashedResort->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="bg-green-100 border border-green-400 hover:bg-green-400 rounded p-1 mb-2">Restore Resort</button>
                                    </form>
                                    @endif
                                    @if ($softDeletedCity)
                                        <p class="text-red-300">Removed City: <span class="font-semibold text-red-400">{{ $softDeletedCity->city_name }}</span></p>
                                        <p class="text-red-300">Please restore the City first.</p>
                                    @endif
                                    <form id="deleteForm_{{ $trashedResort->id }}" action="{{ route('resort.permDelete', $trashedResort->id) }}" method="POST" class="inline delete_resort">
                                        @csrf
                                        @method('DELETE')
                                        <button data-resort-id="{{ $trashedResort->id }}" type="button" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2"">Delete</button>
                                    </form>

            
                                
  
                                </div>
                            @endforeach
                        </div>
                    </div>
            
                    
                    {{-- <div class="child">
                        <!-- Display Apartments -->
                        <h2 class="text-lg font-bold underline">Apartments</h2>
                        <ul>
                            @foreach ($apartments as $apartment)
                                <li class="border border-gray-500 mb-3 p-3 rounded">
                                    <p class="text-lg font-bold">
                                        {{ $apartment->resort->city->city_name }}  /  {{ $apartment->resort->resort_name }} - {{ $apartment->apartment_name }} 
                                    </p>
                                    <ul>
                                        @foreach ($apartment->prices as $price)
                                            <li>{{ $price->price }}e from: {{ $price->start_date }} to: {{ $price->end_date }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="child">
                        <!-- Display Apartments -->
                        <h2 class="text-lg font-bold underline">Removed Apartments</h2>
                        <ul>
                            @foreach ($trashedApartments as $trashedApartment)
                                <li class="border border-gray-500 mb-3 p-3 rounded">
                                    <p class="text-lg font-bold">
                                        {{ $trashedApartment->apartment_name }} 
                                    </p>
                   
                                </li>
                            @endforeach
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

 

    <div id="overlay2" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>


    <!-- Modal for Country -->
    <div id="countryModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeCountryModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new Country</h2>
                    <form action="{{ route('country.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="country_name">Name of Country:</label>
                        <x-input id="country_name" value="{{ old('country_name') }}" class="mb-5 block mt-1 w-full" type="text" name="country_name" />

                        <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Submit</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for City -->
    <div id="cityModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeCityModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new City</h2>
                    <form action="{{ route('city.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="city_name">City Name:</label>
                        <x-input id="city_name" value="{{ old('city_name') }}" class="block mt-1 w-full mb-5" type="text" name="city_name" />



                        <label for="country_id" >Country:</label>
                        <select name="country_id" id="country_id" class="mb-5 block rounded">
                            <option value="" selected disabled>Select a Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Submit</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Resort -->
    <div id="resortModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeResortModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Create new Resort</h2>
                    <form action="{{ route('resorts.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                    
                        <label for="new_resort_name">Name of Resort:</label>
                        <x-input id="new_resort_name" value="{{ old('resort_name') }}" class="mb-5 block mt-1 w-full" type="text" name="resort_name" />
                    
                        <label for="new_resort_description">Resort Description:</label>
                        <x-input id="new_resort_description" value="{{ old('resort_description') }}" class="mb-5 block mt-1 w-full" type="text" name="resort_description" />
                        
                        <label for="new_images">Resort Image:</label>
                        <input id="new_images" class="mb-5 block mt-1 w-full" type="file" name="image_path" accept="image/*" />
                        
                        <div class="flex justify-between">
                            <div class="class">
                                <label for="type_select">Type:</label>
                                <select id="type_select" name="resort_type" class="block mt-1 rounded">
                                    @foreach($resortTypes as $resortType)
                                        <option value="{{ $resortType->id }}">
                                            {{ $resortType->type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="class">
                                <label for="new_country_id">Country:</label>
                                <select name="country_id" id="new_country_id" class="block mt-1 rounded">
                                    <option value="" disabled selected>Select a country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="class">
                                <label for="new_city_id">City:</label>
                                <select name="city_id" id="new_city_id" class="block mt-1 rounded">
                                        {{-- JavaScript  --}}
                                </select>
                            </div>


                        </div>
                    
                    
                    
                        <button type="submit" class="w-full mt-3 rounded bg-blue-400 border border-blue-500 hover:bg-blue-500 p-1">Create Resort</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>

    
  

   
</x-app-layout>
