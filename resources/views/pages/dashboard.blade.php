<?php

use App\HashIdGenerator;
use App\Models\ShortLink;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

$getShortLinks = fn () => $this->shortLinks = Auth::user()->currentTeam->links()->latest()->get();

name('dashboard');

middleware(['auth']);

state([
    'shortLinks' => $getShortLinks,
]);

?>

<x-app-layout>
    <x-slot:header>
        <x-auth-navbar />
    </x-slot:header>
    @volt('pages.dashboard')
        <x-container>
            <div class="pt-12 pb-24 flex flex-col gap-8">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <h2 class="text-zinc-950 dark:text-white text-3xl font-bold tracking-tight">
                            Dashboard
                        </h2>
                    </div>
                    <div>
                        <x-button href="/links/create">
                            Crear enlace
                        </x-button>
                    </div>
                </div>
                <div>
                    <div class="space-y-4">
                        @foreach ($shortLinks as $shortLink)
                            <x-card-sm>
                                <div class="w-full flex items-center">
                                    <div class="flex-1">
                                        <h3 class="font-semibold">
                                            <a href="{{ 'https://' . $shortLink->domain->name . '/' . $shortLink->hashid }}">{{ $shortLink->domain->name . '/' . $shortLink->hashid }}</a>
                                        </h3>
                                        <p class="text-zinc-500 text-sm">{{ $shortLink->url }}</p>
                                    </div>
                                    <button
                                        x-data="{ copied: false, timeout: null }"
                                        @click="
                                            navigator.clipboard.writeText('{{ url('/' . $shortLink->hashid) }}');
                                            clearTimeout(timeout);
                                            copied = true;
                                            timeout = setTimeout(() => { copied = false }, 1000);"
                                        class="text-sm text-gray-600 font-semibold flex items-center gap-1.5"
                                        >
                                            <svg x-show="! copied" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.25 1.5H11.1667C13.0335 1.5 13.9669 1.5 14.68 1.86331C15.3072 2.18289 15.8171 2.69282 16.1367 3.32003C16.5 4.03307 16.5 4.96649 16.5 6.83333V12.75M4.16667 16.5H10.9167C11.8501 16.5 12.3168 16.5 12.6733 16.3183C12.9869 16.1586 13.2419 15.9036 13.4017 15.59C13.5833 15.2335 13.5833 14.7668 13.5833 13.8333V7.08333C13.5833 6.14991 13.5833 5.6832 13.4017 5.32668C13.2419 5.01308 12.9869 4.75811 12.6733 4.59832C12.3168 4.41667 11.8501 4.41667 10.9167 4.41667H4.16667C3.23325 4.41667 2.76654 4.41667 2.41002 4.59832C2.09641 4.75811 1.84144 5.01308 1.68166 5.32668C1.5 5.6832 1.5 6.14991 1.5 7.08333V13.8333C1.5 14.7668 1.5 15.2335 1.68166 15.59C1.84144 15.9036 2.09641 16.1586 2.41002 16.3183C2.76654 16.5 3.23325 16.5 4.16667 16.5Z" stroke="#475467" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <span x-text="copied ? 'Copiado' : 'Copiar'">Copiar</span>
                                        </button>
                                </div>
                            </x-card-sm>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-container>
    @endvolt
    <x-slot:footer>
        <x-footer />
    </x-slot:footer>
</x-app-layout>
