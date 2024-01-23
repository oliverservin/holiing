<x-layouts.minimal>
    <div class="w-full flex flex-col gap-8">
        <div class="gap-4 flex flex-col items-start justify-start sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1">
                <h1 class="font-semibold text-3xl text-gray-800">Analíticas</h1>

                <p class="hidden sm:block text-sm text-gray-500">{{ $shortLink->url }}</p>
            </div>
        </div>

        <livewire:analytics :$shortLink />
    </div>
</x-layouts.minimal>
