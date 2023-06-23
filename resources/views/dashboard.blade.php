<x-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold mb-2">Friend Requests</h2>

        @if ($friendRequests && $friendRequests->count() > 0)
        <ul class="space-y-2">
            @foreach ($friendRequests as $friendRequest)
            <li>
                <div>
                    <span class="font-bold">{{ $friendRequest->sender->name }}</span> sent you a friend request.
                </div>
                <div class="flex mt-2">
                    <form action="{{ route('acceptFriendRequest', $friendRequest->id) }}" method="POST" class="mr-2">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Accept</button>
                    </form>
                    <form action="{{ route('denyFriendRequest', $friendRequest->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Deny</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <p>No friend requests.</p>
        @endif
        @if ($friends && $friends->count() > 0)
        <h2 class="text-xl font-semibold mb-2">Friends</h2>
        <ul class="space-y-2">
            @foreach ($friends as $friend)
            <li>{{ $friend->name }}</li>
            @endforeach
        </ul>
        @else
        <p>No friends.</p>
        @endif
    </div>
    @endsection
</x-app-layout>