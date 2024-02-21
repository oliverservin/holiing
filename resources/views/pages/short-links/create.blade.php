<?php

use App\HashIdGenerator;
use App\Livewire\ShortLinks\Create\SocialPreview;
use App\Models\Domain;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\form;
use function Livewire\Volt\state;
use function Livewire\Volt\updated;

middleware(['auth']);

name('short-links.create');

form(SocialPreview::class, 'socialPreview');

state([
    'url' => '',
    'hashid' => '',
    'domain_id' => fn () => Domain::where('public_domain', true)->first()->id,
    'domains' => fn () => Domain::where('team_id', Auth::user()->currentTeam->id)->orWhere('public_domain', true)->latest()->get(),
    'comments' => '',
    'expires_at' => '',
]);

updated(['url' => function () {
    $this->socialPreview->fillMetaData($this->url);
}]);

$store = function (HashIdGenerator $hashIdGenerator) {
    $validated = $this->validate(
        rules: [
            'url' => ['required', 'string', 'max:255'],
            'hashid' => ['nullable', Rule::unique('short_links')->where(fn (Builder $query) => $query->where('domain_id', $this->domain_id))],
            'domain_id' => ['required', 'exists:domains,id'],
            'comments' => ['nullable', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:today'],
        ],
        attributes: [
            'url' => 'url',
            'hashid' => 'hashid',
            'comments' => 'comentarios',
            'domain_id' => 'dominio',
        ]
    );

    if (! $validated['hashid']) {
        $validated['hashid'] = $hashIdGenerator->generate();
    }

    Auth::user()->currentTeam->links()->create($validated);

    session()->flash('flash.notification', 'Enlace creado.');

    $this->redirect(route('dashboard'), navigate: true);
}

?>

<x-layouts.app>
    @volt('short-links.create')
        <div>
            <x-settings.header />

            <x-main>
                <x-container>
                    <x-section>
                        <div class="space-y-0.5">
                            <x-heading.h1>Crear enlace corto</x-heading.h1>
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
                                    <x-fieldset.field-group x-data="{ open: false }">
                                        <x-switch.field>
                                            <x-fieldset.label>Agregar comentarios</x-fieldset.label>
                                            <x-fieldset.description>
                                                Agrega observaciones o cualquier detalle adicional que consideres importante.
                                            </x-fieldset.description>
                                            <x-switch x-model="open" />
                                        </x-switch.field>
                                        <x-fieldset.field x-show="open">
                                            <x-fieldset.label>Comentarios</x-fieldset.label>
                                            <x-textarea wire:model="comments" id="comments" name="comments" placeholder="Agregar comentarios" rows="3" />
                                            @error('comments')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                    </x-fieldset.field-group>
                                    <x-fieldset.field-group x-data="{ open: false }">
                                        <x-switch.field>
                                            <x-fieldset.label>Expirar enlace</x-fieldset.label>
                                            <x-fieldset.description>
                                                Hacer que el enlace corto deje de funcionar en una fecha específica.
                                            </x-fieldset.description>
                                            <x-switch x-model="open" />
                                        </x-switch.field>
                                        <x-fieldset.field x-show="open">
                                            <x-fieldset.label>Fecha de expiración</x-fieldset.label>
                                            <x-input type="datetime-local" wire:model="expires_at" id="expires_at" name="expires_at" />
                                            @error('expires_at')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                    </x-fieldset.field-group>
                                    <x-button>Crear enlace</x-button>
                                </form>
                            </div>
                            <div>
                                <x-fieldset>
                                    <x-fieldset.legend>Vista previa social</x-fieldset.legend>
                                    <x-text>Previsualiza cómo se vería tu enlace al compartirlo en tus redes sociales.</x-text>

                                    <x-fieldset.field-group>
                                        <x-fieldset.field>
                                            <x-fieldset.label>
                                                <div class="flex items-center gap-2">
                                                    <x-short-links.create.twitter-icon class="size-3" />
                                                    Twitter
                                                </div>
                                            </x-fieldset.label>
                                            <div data-slot="control" class="relative overflow-hidden rounded-2xl border border-zinc-300">
                                                @if ($socialPreview->image)
                                                    <img src="{{ $socialPreview->image }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                                    <div class="absolute bottom-2 left-2 rounded-md bg-[#414142] px-1.5 py-px">
                                                        <h3 class="max-w-sm truncate text-sm text-white">{{ $socialPreview->title }}</h3>
                                                    </div>
                                                @else
                                                    <div class="h-[250px] bg-zinc-100"></div>
                                                    @if ($socialPreview->title)
                                                        <div class="absolute bottom-2 left-2 rounded-md bg-[#414142] px-1.5 py-px">
                                                            <h3 class="max-w-sm truncate text-sm text-white">{{ $socialPreview->title }}</h3>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </x-fieldset.field>
                                        <x-fieldset.field>
                                            <x-fieldset.label>
                                                <div class="flex items-center gap-2">
                                                    <x-short-links.create.facebook-icon class="size-4" />
                                                    Facebook
                                                </div>
                                            </x-fieldset.label>
                                            <div data-slot="control" class="relative overflow-hidden border border-zinc-300">
                                                @if ($socialPreview->image)
                                                    <img src="{{ $socialPreview->image }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-[#f2f3f5] p-3">
                                                        <p class="text-[0.8rem] uppercase text-[#606770]">{{ $socialPreview->domain }}</p>
                                                        <h3 class="truncate font-semibold text-[#1d2129]">{{ $socialPreview->title }}</h3>
                                                        <p class="line-clamp-2 text-sm text-[#606770]">{{ $socialPreview->description }}</p>
                                                    </div>
                                                @else
                                                    <div class="h-[250px] bg-zinc-100"></div>
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-[#f2f3f5] p-3">
                                                        @if ($domain)
                                                            <p class="text-[0.8rem] uppercase text-[#606770]">{{ $socialPreview->domain }}</p>
                                                        @else
                                                            <div class="h-4 w-24 rounded-md bg-zinc-200"></div>
                                                        @endif

                                                        @if ($socialPreview->title)
                                                            <h3 class="truncate font-semibold text-[#1d2129]">{{ $socialPreview->title }}</h3>
                                                        @else
                                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                                        @endif

                                                        @if ($socialPreview->title)
                                                            <p class="line-clamp-2 text-sm text-[#606770]">{{ $socialPreview->description }}</p>
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
                                                    <x-short-links.create.linkedin-icon class="size-4" />
                                                    LinkedIn
                                                </div>
                                            </x-fieldset.label>
                                            <div data-slot="control" class="relative overflow-hidden border border-zinc-300">
                                                @if ($socialPreview->image)
                                                    <img src="{{ $socialPreview->image }}" alt="Preview" class="h-[250px] w-full object-cover" />
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-white p-3">
                                                        <h3 class="truncate font-semibold text-[#000000E6]">{{ $socialPreview->title }}</h3>
                                                        <p class="text-xs text-[#00000099]">{{ $socialPreview->domain }}</p>
                                                    </div>
                                                @else
                                                    <div class="h-[250px] bg-zinc-100"></div>
                                                    <div class="grid gap-1 border-t border-zinc-300 bg-white p-3">
                                                        @if ($socialPreview->title)
                                                            <h3 class="truncate font-semibold text-[#000000E6]">{{ $socialPreview->title }}</h3>
                                                        @else
                                                            <div class="h-4 w-full rounded-md bg-zinc-200"></div>
                                                        @endif

                                                        @if ($domain)
                                                            <p class="text-xs text-[#00000099]">{{ $socialPreview->domain }}</p>
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
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
