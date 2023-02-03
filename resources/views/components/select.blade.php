@props([
    'options' => [],
    'value' => '',
    'model' => '',
])

<select 
    x-model="{{ $model }}"
    class="relative w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
    >
    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ ($value == $optionValue) ? "selected" : "" }} >{{ $optionLabel }}</option>
    @endforeach
</select>