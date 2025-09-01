<div class="p-6">

    <!-- رسالة النجاح -->
    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- البحث و زر الإضافة -->
    <div class="mb-4 flex justify-between items-center">
        <input type="text" wire:model.live="search" placeholder="Search..." class="border rounded p-2 w-1/2">
        <button wire:click="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Farmer</button>
    </div>

    <!-- الجدول -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded">
            <thead class="bg-gray-100">
            <tr>
                <th wire:click="sortBy('id')" class="cursor-pointer px-4 py-2 text-left">ID</th>
                <th wire:click="sortBy('name_en')" class="cursor-pointer px-4 py-2 text-left">Name (EN)</th>
                <th wire:click="sortBy('name_ar')" class="cursor-pointer px-4 py-2 text-left">Name (AR)</th>
                <th wire:click="sortBy('birthdate')" class="cursor-pointer px-4 py-2 text-left">Birthdate</th>
                <th wire:click="sortBy('phone')" class="cursor-pointer px-4 py-2 text-left">Phone</th>
                <th wire:click="sortBy('identity')" class="cursor-pointer px-4 py-2 text-left">Identity</th>
                <th>Identity Type</th>
                <th>Gender</th>
                <th>Governorate</th>
                <th>Locality</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($farmers as $farmer)
                <tr>
                    <td class="px-4 py-2">{{ $farmer->id }}</td>
                    <td class="px-4 py-2">{{ $farmer->name_en }}</td>
                    <td class="px-4 py-2">{{ $farmer->name_ar }}</td>
                    <td class="px-4 py-2">{{ $farmer->birthdate }}</td>
                    <td class="px-4 py-2">{{ $farmer->phone }}</td>
                    <td class="px-4 py-2">{{ $farmer->identity }}</td>
                    <td class="px-4 py-2">{{ $farmer->identityType->name_en ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $farmer->gender->gender_en ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $farmer->governorate->name_en ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $farmer->locality->name_en ?? '-' }}</td>
                    <td class="px-4 py-2 space-x-1">
                        <button wire:click="openModal({{ $farmer->id }})" class="bg-yellow-500 text-black px-2 py-1 rounded hover:bg-yellow-600">Edit</button>
                        <button wire:click="delete({{ $farmer->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $farmers->links() }}
    </div>

    <!-- Modal لإنشاء / تعديل -->
    @if($isModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white text-gray-900 p-6 rounded shadow-lg w-3/4 max-w-4xl">
                <h2 class="text-xl font-bold mb-4">{{ $farmerId ? 'Edit Farmer' : 'Add Farmer' }}</h2>

                <<div class="grid grid-cols-2 gap-4">
                    <div>
                        <input type="text" wire:model.defer="name_en" placeholder="Name EN" class="border p-2 rounded w-full">
                        @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model.defer="name_ar" placeholder="Name AR" class="border p-2 rounded w-full">
                        @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model.defer="phone" placeholder="Phone" class="border p-2 rounded w-full">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model.defer="identity" placeholder="Identity" class="border p-2 rounded w-full">
                        @error('identity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="date" wire:model.defer="birthdate" class="border p-2 rounded w-full">
                        @error('birthdate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model.defer="address" placeholder="Address" class="border p-2 rounded w-full">
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <select wire:model.live="gender_id" class="border p-2 rounded w-full">
                            <option value="">Select Gender</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->id }}">{{ $gender->gender_en }}</option>
                            @endforeach
                        </select>
                        @error('gender_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <select wire:model.live="identity_type_id" class="border p-2 rounded w-full">
                            <option value="">Select Identity Type</option>
                            @foreach($identityTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name_en }}</option>
                            @endforeach
                        </select>
                        @error('identity_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <select wire:model.live="governorate_id" class="border p-2 rounded w-full">
                            <option value="">Select Governorate</option>
                            @foreach($governorates as $gov)
                                <option value="{{ $gov->id }}">{{ $gov->name_en }}</option>
                            @endforeach
                        </select>
                        @error('governorate_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <select wire:model.live="locality_id" class="border p-2 rounded w-full">
                            <option value="">Select Locality</option>
                            @foreach($localities as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name_en }}</option>
                            @endforeach
                        </select>
                        @error('locality_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>


                <div class="mt-4 flex justify-end space-x-2">
                    <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                    <button wire:click="save" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                </div>
            </div>
        </div>

    @endif

</div>
