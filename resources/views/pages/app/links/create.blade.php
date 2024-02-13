<?php

use App\HashIdGenerator;
use App\Models\Domain;
use App\Models\ShortLink;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\DomCrawler\Crawler;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\updated;

middleware(['auth']);

name('app.links.create');

state([
    'url' => '',
    'hashid' => '',
    'domain_id' => fn () => Domain::where('public_domain', true)->first()->id,
    'domains' => fn () => Domain::where('team_id', Auth::user()->currentTeam->id)->orWhere('public_domain', true)->latest()->get(),
    'metaTitle',
    'metaDescription',
    'metaImage',
    'metaDomain',
]);

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

    $this->metaTitle = $title;
    $this->metaDescription = $description;
    $this->metaImage = $image;
    $this->metaDomain = Str::of($this->url)->domain();
}]);

$store = function (HashIdGenerator $hashIdGenerator) {
    $validated = $this->validate(
        rules: [
            'url' => ['required', 'string', 'max:255'],
            'hashid' => ['nullable', Rule::unique('short_links')->where(fn (Builder $query) => $query->where('domain_id', $this->domain_id))],
            'domain_id' => ['required', 'exists:domains,id'],
        ],
        attributes: [
            'url' => 'url',
            'hashid' => 'hashid',
            'domain_id' => 'dominio',
        ]
    );

    if (! $validated['hashid']) {
        $validated['hashid'] = $hashIdGenerator->generate();
    }

    Auth::user()->currentTeam->links()->create($validated);

    session()->flash('flash.notification', 'Enlace creado.');

    $this->redirect(route('app.dashboard'), navigate: true);
}

?>

<x-layouts.app>
    @volt('pages.app.links.create')
        <div>
            <x-app.settings.header />

            <x-app.main>
                <x-container>
                    <x-app.section>
                        <div class="space-y-0.5">
                            <x-app.heading.h1>Crear enlace corto</x-app.heading.h1>
                            <x-text.lead>Proporciona los detalles de tu enlace y obtén un enlace corto.</x-text.lead>
                        </div>

                        <x-separator />

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <form wire:submit="store" class="space-y-8">
                                    <x-fieldset.field-group>
                                        <x-fieldset.field>
                                            <x-fieldset.label>URL de destino</x-fieldset.label>
                                            <x-input wire:model.live="url" id="url" type="text" name="url" placeholder="{{ url('/') }}" required />
                                            @error('url')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3 sm:gap-4">
                                            <x-fieldset.field>
                                                <x-fieldset.label>Dominio</x-fieldset.label>
                                                <x-select wire:model="domain_id" :invalid="$errors->has('domain_id')">
                                                    @foreach ($domains as $domain)
                                                        <option value="{{ $domain->id }}">
                                                            {{ $domain->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                                @error('domain_id')
                                                    <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                                @enderror
                                            </x-fieldset.field>
                                            <x-fieldset.field class="sm:col-span-2">
                                                <x-fieldset.label>Alias</x-fieldset.label>
                                                <x-input wire:model="hashid" id="hashid" type="text" name="hashid" />
                                                @error('hashid')
                                                    <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                                @enderror
                                            </x-fieldset.field>
                                        </div>
                                    </x-fieldset.field-group>
                                    <x-button>Crear enlace</x-button>
                                </form>
                            </div>
                            <div>
                                <x-fieldset>
                                    <x-fieldset.legend>Vista previa social</x-fieldset.legend>

                                    <x-fieldset.field-group>
                                        <x-fieldset.field>
                                            <x-fieldset.label>
                                                <div class="flex items-center gap-2">
                                                    <svg
                                                        width="300"
                                                        height="300"
                                                        viewBox="0 0 300 300"
                                                        version="1.1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-3 w-3"
                                                    >
                                                        <path
                                                            stroke="currentColor"
                                                            d="M178.57 127.15 290.27 0h-26.46l-97.03 110.38L89.34 0H0l117.13 166.93L0 300.25h26.46l102.4-116.59 81.8 116.59h89.34M36.01 19.54H76.66l187.13 262.13h-40.66"
                                                        ></path>
                                                    </svg>
                                                    Twitter
                                                </div>
                                            </x-fieldset.label>
                                            <div data-slot="control" class="relative overflow-hidden rounded-2xl border border-zinc-300">
                                                @if ($metaImage)
                                                    <img src="{{ $metaImage }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                                    <div class="absolute bottom-2 left-2 rounded-md bg-[#414142] px-1.5 py-px">
                                                        <h3 class="max-w-sm truncate text-sm text-white">{{ $metaTitle }}</h3>
                                                    </div>
                                                @else
                                                    <div class="h-[250px] bg-zinc-100"></div>
                                                    @if ($metaTitle)
                                                        <div class="absolute bottom-2 left-2 rounded-md bg-[#414142] px-1.5 py-px">
                                                            <h3 class="max-w-sm truncate text-sm text-white">{{ $metaTitle }}</h3>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </x-fieldset.field>
                                        <x-fieldset.field>
                                            <x-fieldset.label>
                                                <div class="flex items-center gap-2">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="1365.12"
                                                        height="1365.12"
                                                        viewBox="0 0 14222 14222"
                                                        class="h-4 w-4"
                                                    >
                                                        <circle cx="7111" cy="7112" r="7111" fill="#1977f3"></circle>
                                                        <path
                                                            d="M9879 9168l315-2056H8222V5778c0-562 275-1111 1159-1111h897V2917s-814-139-1592-139c-1624 0-2686 984-2686 2767v1567H4194v2056h1806v4969c362 57 733 86 1111 86s749-30 1111-86V9168z"
                                                            fill="#fff"
                                                        ></path>
                                                    </svg>
                                                    Facebook
                                                </div>
                                            </x-fieldset.label>
                                            <div data-slot="control" class="relative overflow-hidden border border-zinc-300">
                                                @if ($metaImage)
                                                    <img src="{{ $metaImage }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-[#f2f3f5] p-3">
                                                        <p class="text-[0.8rem] uppercase text-[#606770]">{{ $metaDomain }}</p>
                                                        <h3 class="truncate font-semibold text-[#1d2129]">{{ $metaTitle }}</h3>
                                                        <p class="line-clamp-2 text-sm text-[#606770]">{{ $metaDescription }}</p>
                                                    </div>
                                                @else
                                                    <div class="h-[250px] bg-zinc-100"></div>
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-[#f2f3f5] p-3">
                                                        @if ($domain)
                                                            <p class="text-[0.8rem] uppercase text-[#606770]">{{ $metaDomain }}</p>
                                                        @else
                                                            <div class="h-4 w-24 rounded-md bg-zinc-200"></div>
                                                        @endif

                                                        @if ($metaTitle)
                                                            <h3 class="truncate font-semibold text-[#1d2129]">{{ $metaTitle }}</h3>
                                                        @else
                                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                                        @endif

                                                        @if ($metaTitle)
                                                            <p class="line-clamp-2 text-sm text-[#606770]">{{ $metaDescription }}</p>
                                                        @else
                                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                                            <div class="h-4 w-48 rounded-md bg-zinc-200"></div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </x-fieldset.field>
                                        <x-fieldset.field>
                                            <x-fieldset.label>
                                                <div class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="h-4 w-4">
                                                        <path
                                                            fill="#027ab5"
                                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                                        ></path>
                                                    </svg>
                                                    LinkedIn
                                                </div>
                                            </x-fieldset.label>
                                            <div data-slot="control" class="relative overflow-hidden border border-zinc-300">
                                                @if ($metaImage)
                                                    <img src="{{ $metaImage }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-white p-3">
                                                        <h3 class="truncate font-semibold text-[#000000E6]">{{ $metaTitle }}</h3>
                                                        <p class="text-xs text-[#00000099]">{{ $metaDomain }}</p>
                                                    </div>
                                                @else
                                                    <div class="h-[250px] bg-zinc-100"></div>
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-white p-3">
                                                        @if ($metaTitle)
                                                            <h3 class="truncate font-semibold text-[#000000E6]">{{ $metaTitle }}</h3>
                                                        @else
                                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                                        @endif

                                                        @if ($domain)
                                                            <p class="text-xs text-[#00000099]">{{ $metaDomain }}</p>
                                                        @else
                                                            <div class="h-4 w-24 rounded-md bg-zinc-200"></div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </x-fieldset.field>
                                    </x-fieldset.field-group>
                                </x-fieldset>
                            </div>
                        </div>
                    </x-app.section>
                </x-container>
            </x-app.main>
        </div>
    @endvolt
</x-layouts.app>
