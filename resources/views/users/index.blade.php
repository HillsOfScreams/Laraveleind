@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Users</h1>
<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th
                class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                ID
            </th>
            <th
                class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Name
            </th>
            <th
                class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Email
            </th>
            <th class="px-6 py-3 bg-gray-100"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            @if (!$user->isFriendWith(Auth::id()) && !$user->hasFriendRequestFrom(Auth::id()))
            <td class="px-6 py-4 whitespace-no-wrap">{{ $user->id }}</td>
            <td class="px-6 py-4 whitespace-no-wrap">{{ $user->name }}</td>
            <td class="px-6 py-4 whitespace-no-wrap">{{ $user->email }}</td>
            <td class="px-6 py-4 whitespace-no-wrap">
            <td class="px-6 py-4 whitespace-no-wrap">
                <form action="{{ route('addFriend') }}" method="POST">
                    @csrf
                    <input type="hidden" name="friend_id" value="{{ $user->id }}">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add
                        Friend</button>
                </form>
                @endif
            </td>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('content')
<h1 class="text-3xl font-bold mb-4">Users</h1>
<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th
                class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                ID
            </th>
            <th
                class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Name
            </th>
            <th
                class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Email
            </th>
            <th class="px-6 py-3 bg-gray-100"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="px-6 py-4 whitespace-no-wrap">{{ $user->id }}</td>
            <td class="px-6 py-4 whitespace-no-wrap">{{ $user->name }}</td>
            <td class="px-6 py-4 whitespace-no-wrap">{{ $user->email }}</td>
            <td class="px-6 py-4 whitespace-no-wrap">
                @if ($user->isFriendWith($user->id))
                <span class="text-green-500">Friend</span>
                @else
                <form action="{{ route('addFriend') }}" method="POST">
                    @csrf
                    <input type="hidden" name="friend_id" value="{{ $user->id }}">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Add Friend</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection