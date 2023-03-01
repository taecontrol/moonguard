<div class="py-4 max-w-md text-sm">
    <h1 class="font-medium text-gray-800 dark:text-gray-200 truncate">{{ $getRecord()->type }} - {{ $getRecord()->site->name }}</h1>
    <p class="truncate text-gray-700 dark:text-gray-300">{{ $getRecord()->message }}</p>
    <p class="text-gray-500 dark:text-gray-400 truncate">{{ $getRecord()->file }} - {{ $getRecord()->line }} </p>
</div>
