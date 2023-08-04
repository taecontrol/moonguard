@props([
    'options' => [],
    'default' => '',
    'model' => '',
])

<select
    x-model="{{ $model }}"
    class="relative w-full py-2 pl-3 pr-10 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 sm:text-sm dark:bg-gray-800"
    >
    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ ($default == $optionValue) ? "selected" : "" }} >{{ $optionLabel }}</option>
    @endforeach
</select>
