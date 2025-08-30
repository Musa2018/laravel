@props(['href' => null])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 shadow rounded-xl p-4']) }}>
    {{ $slot }}

    @if($href)
        <a href="{{ $href }}" class="inline-block mt-2 px-4 py-2 bg-indigo-600 text-black rounded-lg hover:bg-indigo-700">
            View Details
        </a>
    @endif
</div>
