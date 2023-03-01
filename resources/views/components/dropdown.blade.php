<div
    x-data="{
        open: false,
        options: {{ json_encode($options) }},
        placeholder: '',
        init() {
            this.placeholder = '{{ $placeholder }}';
        },
        get modelValue() {
           return this.$wire[this.$refs.component.getAttribute('wire:model')] ?? '';
        },
        toggle() {
            if (this.open) {
                return this.close()
            }

            this.$refs.button.focus()

            this.open = true
        },
        close(focusAfter) {
            if (! this.open) return

            this.open = false

            focusAfter && focusAfter.focus()
        },
        selectValue(value) {
            this.$dispatch('input', value)
            this.close()
        },
    }"
    x-on:keydown.escape.prevent.stop="close($refs.button)"
    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
    x-id="['dropdown-button']"
    class="relative"
    x-ref="component"
    {{ $attributes->except('options', 'placeholder') }}
>
    <button
        x-ref="button"
        x-on:click="toggle()"
        :aria-expanded="open"
        :aria-controls="$id('dropdown-button')"
        type="button"
        class="relative w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800"
        aria-haspopup="listbox"
        aria-labelledby="listbox-label"
    >

        <span class="block truncate" :class="modelValue || 'text-gray-400'" x-text="modelValue ? options[modelValue] : placeholder"></span>

        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
            <!-- Heroicon name: mini/chevron-up-down -->
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    <ul
        x-ref="panel"
        x-show="open"
        x-transition.origin.top.left
        x-on:click.outside="close($refs.button)"
        :id="$id('dropdown-button')"
        style="display: none;"
        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:bg-gray-800"
        tabindex="-1"
        role="listbox"
        aria-labelledby="listbox-label"
    >
        @foreach($options as $optionValue => $optionLabel)
            <!--
              Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

              Highlighted: "text-white bg-indigo-600", Not Highlighted: "text-gray-900"
            -->
            <li @click="selectValue('{{ $optionValue }}')" class="text-gray-900 cursor-pointer relative cursor py-2 pl-3 pr-9 hover:bg-primary-500 hover:text-white dark:hover:text-gray-50 dark:text-gray-100" id="listbox-option-0" role="option">
                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                <span class="font-normal block truncate">{{ $optionLabel }}</span>
            </li>
        @endforeach

        <!-- More items... -->
    </ul>
</div>
