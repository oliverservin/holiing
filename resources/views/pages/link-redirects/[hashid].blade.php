<?php

use App\DomainWithoutWWWGenerator;
use App\Models\ClickEvent;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;
use function Livewire\Volt\mount;
use function Livewire\Volt\protect;
use function Livewire\Volt\state;

middleware('domain');

state(['link', 'password']);

$login = function () {
    $validated = $this->validate(
        rules: [
            'password' => ['required', 'string'],
        ]
    );

    if (! Hash::check($validated['password'], $this->link->password)) {
        throw ValidationException::withMessages([
            'password' => trans('auth.failed'),
        ]);
    }

    return redirect($this->link->url, 307);
};

$redirectUser = protect(function () {
    $agent = new Agent();
    $referer = request()->header('referer');
    $domainWithoutWWWGenerator = new DomainWithoutWWWGenerator($referer);
    $domainWithoutWWW = $domainWithoutWWWGenerator->generate();

    $clickEvent = ClickEvent::create([
        'domain_id' => request()->domain->id,
        'short_link_id' => $this->link->id,
        'country' => ($location = Location::get()) ? $location->countryCode : 'unknown',
        'device' => $agent->deviceType() === 'other' ? 'unknown' : $agent->deviceType(),
        'browser' => $browser = $agent->browser() ?? 'unknown',
        'bot' => $agent->isRobot(),
        'referer' => $domainWithoutWWW ?? 'unknown',
    ]);

    $this->link->increment('clicks');
    $this->link->last_clicked_at = now();
    $this->link->save();

    return redirect($this->link->url, 307);
});

mount(function () {
    $this->link = request()->domain->links()->where('hashid', request()->hashid)->first();

    abort_unless($this->link, 404);

    abort_if($this->link->hasExpired(), 419);

    if (! $this->link->hasPassword()) {
        $this->redirectUser();
    }
});

?>

<x-layouts.auth>
    @volt('pages.link-redirects.show')
        <form wire:submit="login" class="mx-auto w-full max-w-sm space-y-8 pb-24 pt-20">
            <div class="space-y-5">
                <x-heading.h1>Se requiere contraseña</x-heading.h1>
                <x-text>Este enlace está protegido por contraseña. Por favor, introduce la contraseña para acceder.</x-text>
            </div>

            <x-fieldset.field-group>
                <x-fieldset.field>
                    <x-fieldset.label>Contraseña</x-fieldset.label>
                    <x-input wire:model="password" id="password" type="password" name="password" required />
                    @error('password')
                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                    @enderror
                </x-fieldset.field>
            </x-fieldset.field-group>

            <x-button class="w-full">Acceder</x-button>
        </form>
    @endvolt
</x-layouts.auth>
