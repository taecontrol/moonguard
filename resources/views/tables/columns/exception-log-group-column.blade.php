<div class="py-4 max-w-md text-sm">
    <h1 class="font-medium text-gray-800 truncate">{{ $getRecord()->type }} - {{ $getRecord()->site->name }}</h1>
    <p class="truncate text-zinc-700">{{ $getRecord()->message }}</p>
    <p class="text-zinc-400 truncate">{{ $getRecord()->file }} - {{ $getRecord()->line }} </p>
</div>
