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
                        {{-- Admin Start --}}
                        @if(auth()->check() && auth()->user()->toAdmin())
                            <button id="addUserButton" class="bg-blue-400 hover:bg-blue-500 border border-blue-500 p-1 rounded text-white">
                                Add new User
                            </button>
                            @error('name')
                                <div class="bg-red-200 border border-red-300 text-center">
                                    <p class="text-red-500">{{ $message }}</p>
                                </div>
                            @enderror
                            @error('email')
                                <div class="bg-red-200 border border-red-300 text-center">
                                    <p class="text-red-500">{{ $message }}</p>
                                </div>
                            @enderror
                            @if (Session::has('success'))
                                <div class="bg-green-200 border border-green-300 text-center">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                        

                            <h3 class="text-lg font-semibold mb-4">All Users</h3>
                            <div id="user-container">
                                <!-- Users will be loaded here -->
                            </div>
                        @endif
                        {{-- Admin end --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- add user modal --}}
    <div id="addUserModal" class="fixed inset-0 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
    
            <!-- Modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <!-- Modal content goes here -->              <button id="addUserModal" class="absolute top-2 right-2 text-gray-700 text-3xl hover:text-red-500 cursor-pointer">
                    &times;
                </button>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Your form to add a new user goes here -->
                    
                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf
                    
                        <div>
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                        @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        @error('email')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Register') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

   
    <!-- Modal for Editing User -->
    <div id="editUserModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white w-1/2 p-6 rounded-lg relative">
                <!-- Close button -->
                <button id="closeEditUserModal" class="absolute top-2 right-2 text-3xl text-gray-700 hover:text-red-500 cursor-pointer">
                    &times;
                </button>

                <!-- Modal content -->
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-2xl font-semibold mb-4">Edit User</h2>
    

                    <form id="editUserForm" method="POST" class="w-1/2">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="editUserName" class="block text-gray-600">Name:</label>
                            <input type="text" id="editUserName" name="name" class="border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <input type="text" id="editUserID" name="editUserID" class="hidden" required>
                        </div>
                    
                        <div class="mb-4">
                            <label for="editUserEmail" class="block text-gray-600">Email:</label>
                            <input type="email" id="editUserEmail" name="email" class="form-input border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        </div>
                    
                        <div class="mb-4">
                            <label for="editUserRole" class="block text-gray-600">Role:</label>
                            <select id="editUserRole" name="role_id" class="capitalize form-select border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            
                            </select>
                        </div>
                    
                        <!-- Save changes button -->
                        <button type="submit" class="bg-blue-400 border border-blue-500 hover:bg-blue-500 text-white px-4 w-full py-2 rounded">Save Changes</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    
    
</x-app-layout>
