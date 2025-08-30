<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Currently Available Users') }}
        </h2>
    </x-slot>
    <ul>
        @foreach($users as $user)
            <li>
                <x-card class="mt-4" :href="route('users.show', $user)">
                    <h3>{{ $user->name }} - {{ $user->role->name }} in {{ $user->governorate->name_en ?? '—' }}</h3>
                    <p>{{ $user->email }} - {{ $user->created_at->format('Y-m-d') }} </p>
                </x-card>


            </li>
        @endforeach
    </ul>

    {{ $users->links() }}

</x-app-layout>
