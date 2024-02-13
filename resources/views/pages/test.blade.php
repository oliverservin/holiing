<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\updated;

state(['url', 'title', 'description', 'image', 'domain']);

rules(['url' => ['required', 'url']]);

updated(['url' => function () {
    try {
        $response = Http::get($this->url);
    } catch (Throwable $e) {
        return;
    }

    $crawler = new Crawler($response->body());

    if ($crawler->filter('title')->count() > 0) {
        $titleTag = $crawler->filter('title')->first()->text();
    } else {
        $titleTag = null;
    }

    if ($crawler->filter('meta[property="og:title"], meta[property="twitter:title"]')->count() > 0) {
        $title = $crawler->filter('meta[property="og:title"], meta[property="twitter:title"]')->first()->attr('content') ?? $titleTag;
    } else {
        $title = $titleTag;
    }

    $descriptionNodeList = $crawler->filter('meta[name="description"], meta[property="twitter:description"], meta[property="og:description"]');
    $description = $descriptionNodeList->count() > 0 ? $descriptionNodeList->first()->attr('content') : null;

    $imageNodeList = $crawler->filter('meta[property="og:image"], meta[property="twitter:image"]');
    $image = $imageNodeList->count() > 0 ? $imageNodeList->first()->attr('content') : null;

    $this->title = $title;
    $this->description = $description;
    $this->image = $image;
    $this->domain = Str::of($this->url)->domain();
}]);

?>

<x-layouts.app>
    @volt('pages.app.dashboard')
        <x-app.main>
            <x-container>
                <x-app.section>
                    <div class="max-w-md space-y-5">
                        <x-input wire:model.live="url" type="text" placeholder="https://livewire.laravel.com" />

                        <div>
                            <div class="relative mb-2">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-zinc-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <div class="flex items-center space-x-2 bg-white px-3">
                                        <svg width="300" height="300" viewBox="0 0 300 300" version="1.1" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3">
                                            <path
                                                stroke="currentColor"
                                                d="M178.57 127.15 290.27 0h-26.46l-97.03 110.38L89.34 0H0l117.13 166.93L0 300.25h26.46l102.4-116.59 81.8 116.59h89.34M36.01 19.54H76.66l187.13 262.13h-40.66"
                                            ></path>
                                        </svg>
                                        <p class="text-sm text-zinc-400">Twitter</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-hidden rounded-2xl border border-zinc-300">
                                @if ($image)
                                    <img src="{{ $image }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                    <div class="absolute bottom-2 left-2 rounded-md bg-[#414142] px-1.5 py-px">
                                        <h3 class="max-w-sm truncate text-sm text-white">{{ $title }}</h3>
                                    </div>
                                @else
                                    <div class="h-[250px] bg-zinc-100"></div>
                                    @if ($title)
                                        <div class="absolute bottom-2 left-2 rounded-md bg-[#414142] px-1.5 py-px">
                                            <h3 class="max-w-sm truncate text-sm text-white">{{ $title }}</h3>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="relative mb-2">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-zinc-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <div class="flex items-center space-x-2 bg-white px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1365.12" height="1365.12" viewBox="0 0 14222 14222" class="h-4 w-4">
                                            <circle cx="7111" cy="7112" r="7111" fill="#1977f3"></circle>
                                            <path
                                                d="M9879 9168l315-2056H8222V5778c0-562 275-1111 1159-1111h897V2917s-814-139-1592-139c-1624 0-2686 984-2686 2767v1567H4194v2056h1806v4969c362 57 733 86 1111 86s749-30 1111-86V9168z"
                                                fill="#fff"
                                            ></path>
                                        </svg>
                                        <p class="text-sm text-zinc-400">Facebook</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-hidden border border-zinc-300">
                                @if ($image)
                                    <img src="{{ $image }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                    <div class="grid gap-1 border-t border-zinc-300 bg-[#f2f3f5] p-3">
                                        <p class="text-[0.8rem] uppercase text-[#606770]">{{ $domain }}</p>
                                        <h3 class="truncate font-semibold text-[#1d2129]">{{ $title }}</h3>
                                        <p class="line-clamp-2 text-sm text-[#606770]">{{ $description }}</p>
                                    </div>
                                @else
                                    <div class="h-[250px] bg-zinc-100"></div>
                                    <div class="grid gap-1 border-t border-zinc-300 bg-[#f2f3f5] p-3">
                                        @if ($domain)
                                            <p class="text-[0.8rem] uppercase text-[#606770]">{{ $domain }}</p>
                                        @else
                                            <div class="h-4 w-24 rounded-md bg-zinc-200"></div>
                                        @endif

                                        @if ($title)
                                            <h3 class="truncate font-semibold text-[#1d2129]">{{ $title }}</h3>
                                        @else
                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                        @endif

                                        @if ($title)
                                            <p class="line-clamp-2 text-sm text-[#606770]">{{ $description }}</p>
                                        @else
                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                            <div class="h-4 w-48 rounded-md bg-zinc-200"></div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="relative mb-2">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-zinc-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <div class="flex items-center space-x-2 bg-white px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="h-4 w-4">
                                            <path
                                                fill="#027ab5"
                                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                            ></path>
                                        </svg>
                                        <p class="text-sm text-zinc-400">LinkedIn</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-hidden border border-zinc-300">
                                @if ($image)
                                    <img src="{{ $image }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                    <div class="grid gap-1 border-t border-zinc-300 bg-white p-3">
                                        <h3 class="truncate font-semibold text-[#000000E6]">{{ $title }}</h3>
                                        <p class="text-xs text-[#00000099]">{{ $domain }}</p>
                                    </div>
                                @else
                                    <div class="h-[250px] bg-zinc-100"></div>
                                    <div class="grid gap-1 border-t border-zinc-300 bg-white p-3">
                                        @if ($title)
                                            <h3 class="truncate font-semibold text-[#000000E6]">{{ $title }}</h3>
                                        @else
                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                        @endif

                                        @if ($domain)
                                            <p class="text-xs text-[#00000099]">{{ $domain }}</p>
                                        @else
                                            <div class="h-4 w-24 rounded-md bg-zinc-200"></div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-app.section>
            </x-container>
        </x-app.main>
    @endvolt
</x-layouts.app>
