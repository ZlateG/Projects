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

                        <h2 class="text-lg text-blue-500 bg-green-100 text-center p-3 mb-5">Edit City</h2>
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

                        <form action="{{ route('cities.update', ['id' => $city->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="city_name">Name of Country:</label>
                            <x-input id="city_name" value="{{ $city->city_name }}"  class="mb-5 block mt-1 w-full" type="text" name="city_name" />

                            <select name="country_id" id="country_id" class="mb-5 block rounded">
                                <option value="" selected disabled>Select a Country</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ $country->id == $city->country_id ? 'selected' : '' }}>
                                    {{ $country->country_name }}
                                </option>                                @endforeach
                            </select>   

                            <button type="submit" class="bg-blue-300 hover:bg-blue-500 border w-full border-blue-500 p-2 rounded">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
