<div class="max-w-md p-4 text-sm">
    <h1 class="font-medium text-gray-800 truncate dark:text-gray-200">{{ $getRecord()->type }} - {{ $getRecord()->site->name }}</h1>
    <p class="text-gray-700 truncate dark:text-gray-300">{{ $getRecord()->message }}</p>
    <p class="text-gray-500 truncate dark:text-gray-400">{{ $getRecord()->file }} - {{ $getRecord()->line }} </p>
</div>
