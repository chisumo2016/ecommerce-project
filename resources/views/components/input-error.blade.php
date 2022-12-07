@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'font-medium text-sm bg-emerald-500 py-3 px-4 text-white rounded']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif


{{--text-sm text-red-600 space-y-1--}}
