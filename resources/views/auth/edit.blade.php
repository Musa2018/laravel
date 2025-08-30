<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            تعديل بيانات المستخدم: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mt-4">
                <x-input-label for="name" value="الاسم" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" required />
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="البريد الإلكتروني" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required />
            </div>

            <div class="mt-4">
                <x-input-label for="role_id" value="الدور" />
                <select name="role_id" id="role_id" class="mt-1 block w-full">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="governorate_id" value="المحافظة" />
                <select name="governorate_id" id="governorate_id" class="mt-1 block w-full">
                    <option value="">— اختر المحافظة —</option>
                    @foreach($governorates as $gov)
                        <option value="{{ $gov->id }}" @selected($user->governorate_id == $gov->id)>{{ $gov->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <x-primary-button>
                    تحديث
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
