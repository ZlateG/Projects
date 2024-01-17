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
    <div class="bg-red-400 border-red-500 hidden capitalize"></div>
    {{-- baranja za aviobileti --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">

                         {{-- baranja za aviobileti --}}
                        <div class="tickets pb-5 border-b border-gray-500 mb-5">
                            <h2 class="text-2xl font-semibold">Авионски Билети</h2>
                            <table class="min-w-full border ">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th class="border px-4 py-2">Број</th>
                                        <th class="border px-4 py-2">Име</th>
                                        <th class="border px-4 py-2">E-маил</th>
                                        <th class="border px-4 py-2">Акција</th>
                                    </tr>
                                </thead>
                                @php
                                    $counter = 0;
                                @endphp
                                <tbody>
                                    @foreach ($airplaneTickets as $ticket)
                                        <tr>
                                            @if ($ticket->answered_by === null)
                                                <td class="border px-4 py-2">{{ ++$counter }}</td>
                                                <td class="border px-4 py-2">{{ $ticket->name }}</td>
                                                <td class="border px-4 py-2">{{ $ticket->email }}</td>
                                                <td class="border px-4 py-2">
                                                    <button data-id={{ $ticket->id }} class="bg-blue-400 hover:bg-blue-500 border border-blue-500 rounded p-1 ticket-btn">Провери</button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                         {{-- odgovoreni baranja za aviobileti --}}
                        <div class="tickets pb-5 border-b border-gray-500 mb-5">
                            <h2 class="text-2xl font-semibold">Одговорени барања за Авионски Билети</h2>
                            <table class="min-w-full border ">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th class="border px-4 py-2">Број</th>
                                        <th class="border px-4 py-2">Име</th>
                                        <th class="border px-4 py-2">Одговорено од</th>
                                        <th class="border px-4 py-2">Акција</th>
                                    </tr>
                                </thead>
                                @php
                                    $counter = 0;
                                @endphp
                                <tbody>
                                    @foreach ($airplaneTickets as $ticket)
                                        <tr>
                                            @if ($ticket->answered_by != null)
                                                <td class="border px-4 py-2">{{ ++$counter }}</td>
                                                <td class="border px-4 py-2">{{ $ticket->name }}</td>
                                                <td class="border px-4 py-2">{{ $ticket->answeredBy->name}}</td>
                                                <td class="border px-4 py-2">
                                                    <button data-id={{ $ticket->id }} class="bg-blue-400 hover:bg-blue-500 border border-blue-500 rounded p-1 ticket-btn">Провери</button>
                                                    <form id="deleteAirplaneTicket_{{ $ticket->id }}" action="{{ route('airplaneTicket.delete', $ticket->id) }}" method="POST" class="inline deleteAirplaneTicketForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button data-ticket-id="{{ $ticket->id }}" type="submit" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2" >Delete</button>
                                                    </form>
                                                </td>
                                            @endif
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
    {{-- baranja za kontakt --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="justify-center flex">
                    <div class="child">
                        {{-- baranja za kontakt --}}
                        <div class="contact">
                            <h2 class="text-2xl font-semibold">Барања за Контакт</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Број</th>
                                        <th class="border px-4 py-2">Име</th>
                                        <th class="border px-4 py-2">E-маил</th>
                                        <th class="border px-4 py-2">Акција</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter1 = 0;
                                    @endphp
                                    @foreach ($contactUs as $contact)
                                        @if ($contact->answered_by === null)
                                            <tr>
                                                <td class="border px-4 py-2">{{ ++$counter1  }}</td>
                                                <td class="border px-4 py-2">{{ $contact->name }}</td>
                                                <td class="border px-4 py-2">{{ $contact->email }}</td>
                                                <td class="border px-4 py-2">
                                                    <button data-id="{{ $contact->id }}" class="bg-blue-400 hover:bg-blue-500 border border-blue-500 rounded p-1 contact-us-btn" >Провери</button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- odgovoreni baranja za kontakt --}}
                        <div class="contact  border-t border-gray-500 pt-5 mt-5">
                            <h2 class="text-2xl font-semibold">Одговорени Барања за Контакт</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Број</th>
                                        <th class="border px-4 py-2">Име</th>
                                        <th class="border px-4 py-2">Одговорени од</th>
                                        <th class="border px-4 py-2">Акција</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter2 = 0;
                                    @endphp
                                    @foreach ($contactUs as $contact)
                                        @if ($contact->answered_by != null)
                                            <tr>
                                                <td class="border px-4 py-2">{{ ++$counter2  }}</td>
                                                <td class="border px-4 py-2">{{ $contact->name }}</td>
                                                <td class="border px-4 py-2">{{ $contact->answeredBy->name}}</td>
                                                <td class="border px-4 py-2">
                                                    <button data-id="{{ $contact->id }}" class="bg-blue-400 hover:bg-blue-500 border border-blue-500 rounded p-1 contact-us-btn" >Провери</button>
                                                    <form id="deleteContact_{{ $ticket->id }}" action="{{ route('contactUs.delete', $contact->id) }}" method="POST" class="inline deleteContactUsForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button data-ticket-id="{{ $contact->id }}" type="submit" class="bg-red-100 border border-red-400 hover:bg-red-400 rounded p-1 mb-2" >Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
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

   
    <!-- Modal for Plane tickets User -->
    <div id="airplaneTicketsModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeAirplaneTicketsModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Airplane Tickets</h2>

                    <table class="table-auto border border-gray-300 rounded">
                        <tr >
                            <td class="border border-gray-300 p-1">Type of ticket:</td>
                            <td class="border border-gray-300 px-5"><span id="airplaneTicketType"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">From:</td>
                            <td class="border border-gray-300 px-5"><span id="fromDestination"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">To:</td>
                            <td class="border border-gray-300 px-5"><span id="toDestination"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Departure date:</td>
                            <td class="border border-gray-300 px-5"><span id="departureDate"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Return date:</td>
                            <td class="border border-gray-300 px-5"><span id="returnDate"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Adults count:</td>
                            <td class="border border-gray-300 px-5"><span id="travelAdults"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Children count:</td>
                            <td class="border border-gray-300 px-5"><span id="travelChildren"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Babies count:</td>
                            <td class="border border-gray-300 px-5"><span id="travelBabies"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Travel Class:</td>
                            <td class="border border-gray-300 px-5"><span id="travelClass"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Contact Name:</td>
                            <td class="border border-gray-300 px-5"><span id="contactName"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Contact Email:</td>
                            <td class="border border-gray-300 px-5"><span id="contactEmail"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Message:</td>
                            <td class="border border-gray-300 px-5"><span id="contactMessage"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Answered by:</td>
                            <td class="border border-gray-300 px-5"><span id="answeredByName"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Answer:</td>
                            <td class="border border-gray-300 px-5"><span id="answerMessage"></span></td>
                        </tr>
                    </table>
                    <form id="updateAirplaneTicket" method="POST"  class="mt-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <input type="text"  name="answered_by" value="{{ auth()->user()->id }}" hidden >
                            <label for="answer">Answer:</label>
                            <textarea id="answer" name="answer" rows="4" cols="50"></textarea>
                        
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Answer</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for ContactUs User -->
    <div id="contactUsModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeContactUsModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col pl-5">
                    <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>

                    <table class="table-auto border border-gray-300 rounded mb-3">
                        <tr >
                            <td class="border border-gray-300 p-1">Contact Name: </td>
                            <td class="border border-gray-300 px-5"><span id="contactUsName"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Contact Email:</td>
                            <td class="border border-gray-300 px-5"><span id="contactUsEmail"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Message:</td>
                            <td class="border border-gray-300 px-5"><span id="contactUsMessage"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Answered by:</td>
                            <td class="border border-gray-300 px-5"><span id="contactUsAnsweredByName"></span></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-1">Answer:</td>
                            <td class="border border-gray-300 px-5"><span id="contactUsAnswerMessage"></span></td>
                        </tr>
                    
                       
                  
                    </table>
   

                    <form id="updateContactUs" method="POST" >
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <input type="text"  name="answered_by" value="{{ auth()->user()->id }}" hidden >
                            <label for="contactUsAnswer">Answer:</label>
                            <textarea id="contactUsAnswer" name="answer" rows="4" cols="50"></textarea>
                        
                        </div>
                        
                        <!-- Save changes button -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Answer</button>
                    </form>
                </div>



               
                    
                </div>
            </div>
        </div>
    </div>
    
    
</x-app-layout>
