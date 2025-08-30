<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Currently Available Users') }}
        </h2>
    </x-slot>
    <div class=" dark:bg-gray-800  shadow rounded-xl p-4">
<h3>{{ $user->name }} - {{ $user->role->name }} in {{ $user->governorate->name_en ?? '—' }}</h3>
<p>{{ $user->email }} - {{ $user->created_at->format('Y-m-d') }} </p>

        <form action="{{ route('users.edit', $user->id) }}" method="get">
            @csrf


            <button type="submit" class="btn inline-block mt-2 px-4 py-2 bg-indigo-600 text-black rounded-lg hover:bg-indigo-700 ">Update User</button>
        </form>
    {{-- delete button --}}
    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn inline-block mt-2 px-4 py-2 bg-indigo-600 text-black rounded-lg hover:bg-indigo-700 ">Delete User</button>
    </form>
    </div>

</x-app-layout>
