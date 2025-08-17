@extends("layouts.app")

@section("content")
    @php($event = $event ?? null)
    <div class="container py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">
            Participants — {{ $event?->title ?? "—" }}
        </h1>
        <div class="card overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="py-2 pr-4">User</th>
                        <th class="py-2 pr-4">Participants</th>
                        <th class="py-2 pr-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings ?? [] as $booking)
                        <tr>
                            <td class="py-2 pr-4">
                                {{ $booking->user->name ?? "—" }}
                            </td>
                            <td class="py-2 pr-4">
                                {{ $booking->num_participants ?? "—" }}
                            </td>
                            <td class="py-2 pr-4">
                                {{ ucfirst($booking->booking_status ?? "—") }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-muted-500">
                                No participants
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
