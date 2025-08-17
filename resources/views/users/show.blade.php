@extends('layouts.app')

@section('content')
    <div class="container py-8 space-y-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $user->name }}</h1>
                <p class="text-sm text-gray-600">User account details and activity.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit User
                </a>
                <a href="{{ route('users.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Users
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Information -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="font-semibold text-gray-900">User Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="h-20 w-20 rounded-full bg-primary-100 flex items-center justify-center">
                                <span class="text-primary-600 font-medium text-2xl">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                @if($user->username)
                                    <p class="text-sm text-gray-400">@{{ $user->username }}</p>
                                @endif
                            </div>
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Role</dt>
                                <dd class="mt-1">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                           ($user->role === 'visitor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('F j, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- User Activity -->
                <div class="card">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="font-semibold text-gray-900">Recent Activity</h2>
                    </div>
                    <div class="p-6">
                        @if($user->isVisitor())
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Hotel Bookings</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->hotelBookings()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Theme Park Tickets</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->themeParksTickets()->count() }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p>Activity tracking for {{ str_replace('_', ' ', $user->role) }} roles</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="card">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <a href="{{ route('users.edit', $user) }}" class="btn-primary w-full text-center">
                            Edit User
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-error w-full"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Account Statistics -->
                <div class="card">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="font-semibold text-gray-900">Account Stats</h2>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Account Age</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Profile Complete</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $user->name && $user->email && $user->username ? '100%' : '75%' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection