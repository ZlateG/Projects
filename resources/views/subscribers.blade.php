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
                        @if(session('success'))
                        <div class="text-lg text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif
                    <button id="openEmailModal" class="bg-blue-300 hover:bg-blue-500 border border-blue-500 p-1 rounded">Прати нов Е-маил</button>
                        {{-- Display subscribers --}}
                        <div class="contact border-t border-gray-500 pt-5 mt-5">
                            <h2 class="text-2xl font-semibold">Subscribers</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Број</th>
                                        <th class="border px-4 py-2">Име</th>
                                        <th class="border px-4 py-2">Email</th>
                                        <th class="border px-4 py-2">Акција</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter3 = 0;
                                    @endphp
                                    @foreach ($subscribers as $subscriber)
                                        <tr>
                                            <td class="border px-4 py-2">{{ ++$counter3 }}</td>
                                            <td class="border px-4 py-2">{{ $subscriber->name }}</td>
                                            <td class="border px-4 py-2">{{ $subscriber->email }}</td>
                                            <td class="border px-4 py-2">
                                                <form action="{{ route('subscribers.destroy', $subscriber->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-300 hover:bg-red-500 text-white border border-red-500 rounded p-1">Remove</button>
                                                </form>
                                                @if ($subscriber->trashed())
                                                    <form action="{{ route('subscribers.restore', $subscriber->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="bg-green-300 hover:bg-green-500 text-white border border-green-500 rounded p-1">Restore</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="contact border-t border-gray-500 pt-5 mt-5">
                            <h2 class="text-2xl font-semibold">Unsubscribed</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Број</th>
                                        <th class="border px-4 py-2">Име</th>
                                        <th class="border px-4 py-2">Email</th>
                                        <th class="border px-4 py-2">Акција</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter3 = 0;
                                    @endphp
                                    @foreach ($trashedSubscribers  as $trashedSubscriber)
                                        <tr>
                                            <td class="border px-4 py-2">{{ ++$counter3 }}</td>
                                            <td class="border px-4 py-2">{{ $trashedSubscriber->name }}</td>
                                            <td class="border px-4 py-2">{{ $trashedSubscriber->email }}</td>
                                            <td class="border px-4 py-2">
                                                @if ($trashedSubscriber->trashed())
                                                <form action="{{ route('subscribers.restore', $trashedSubscriber->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white border border-green-500 rounded p-1">Restore</button>
                                                </form>
                                            @endif
                                                @if ($trashedSubscriber->trashed())
                                                <form action="{{ route('subscribers.permDelete', $trashedSubscriber->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-300 hover:bg-red-500 text-white border border-red-500 rounded p-1">Delete</button>
                                                </form>
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="overlay2" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>
    <div id="emailSubscribersModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeEmailSubscribersModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-lg text-gray-500 underline">Mail to All Active subscribers :</h2>

                    <form action="{{ route('subscribers.send-email') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <input type="text" name="sent_by" value="{{ auth()->user()->id }}" hidden>
                            <label for="mailToSubscribers">Answer:</label>
                            <textarea id="mailToSubscribers" name="answer" rows="4" cols="50"></textarea>
                        </div>
                        
                        <!-- Save changes button -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send Email</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
