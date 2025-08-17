@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-6">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                <h4 class="text-sm font-medium text-red-800 mb-2">
                    Please fix the following errors:
                </h4>
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session("success"))
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <p class="text-sm text-green-800">{{ session("success") }}</p>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">
                Theme Park Tickets
            </h1>
            <x-back-link :href="route('dashboard')">Back to Dashboard</x-back-link>
        </div>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            ID
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Visit Date
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Tickets
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($tickets ?? [] as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ $ticket->id }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ \Carbon\Carbon::parse($ticket->visit_date)->toHumanDate() }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ $ticket->num_tickets }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{
                                        $ticket->ticket_status == "confirmed"
                                            ? "bg-green-100 text-green-800"
                                            : ($ticket->ticket_status == "pending"
                                                ? "bg-yellow-100 text-yellow-800"
                                                : "bg-red-100 text-red-800")
                                    }}"
                                >
                                    {{ ucfirst($ticket->ticket_status ?? "—") }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm"
                            >
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <a
                                        href="{{ route("theme-park.ticket.activities", $ticket) }}"
                                        class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                        title="View Activities"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />
                                        </svg>
                                    </a>
                                    @if (auth()->check() && auth()->user()->id === $ticket->user_id)
                                        @if (($ticket->ticket_status ?? "") !== "cancelled")
                                            <form
                                                method="POST"
                                                action="{{ route("theme-park.cancel-ticket", $ticket) }}"
                                                class="inline"
                                                onsubmit="return confirm('Cancel this theme park ticket?');"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200"
                                                    title="Cancel Ticket"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"
                                                        />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No tickets found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
