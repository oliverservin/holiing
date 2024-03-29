<?php

use App\Models\Team;
use App\Models\User;
use App\Notifications\UserRegistered;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

name('register');

middleware('guest');

state([
    'name',
    'email',
    'password',
    'password_confirmation',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    $user->ownedTeams()->save(Team::forceCreate([
        'user_id' => $user->id,
        'name' => 'Personal',
        'personal_team' => true,
        'trial_ends_at' => now()->addDays(10),
    ]));

    Notification::send(User::admin()->get(), new UserRegistered($user));

    Auth::login($user);

    $this->redirect(RouteServiceProvider::HOME, navigate: true);
};

?>

<x-layouts.auth>
    @volt('pages.register')
        <x-container>
            <form wire:submit="register" class="mx-auto w-full max-w-sm space-y-8 pb-24 pt-20">
                <x-heading.h1>Registrarse en Holi</x-heading.h1>
                <x-fieldset.field-group>
                    <x-fieldset.field>
                        <x-fieldset.label>Nombre</x-fieldset.label>
                        <x-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" />
                        @error('name')
                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                        @enderror
                    </x-fieldset.field>
                    <x-fieldset.field>
                        <x-fieldset.label>Email</x-fieldset.label>
                        <x-input wire:model="email" id="email" type="email" name="email" required />
                        @error('email')
                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                        @enderror
                    </x-fieldset.field>
                    <x-fieldset.field>
                        <x-fieldset.label>Contraseña</x-fieldset.label>
                        <x-input wire:model="password" id="password" type="password" name="password" required />
                        @error('password')
                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                        @enderror
                    </x-fieldset.field>
                    <x-fieldset.field>
                        <x-fieldset.label>Confirmar contraseña</x-fieldset.label>
                        <x-input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required />
                        @error('password')
                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                        @enderror
                    </x-fieldset.field>
                </x-fieldset.field-group>
                <x-button class="w-full">Registrarse</x-button>
                <x-text>
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="font-semibold text-zinc-950 hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300">
                        Inicia sesión
                    </a>
                </x-text>
            </form>
        </x-container>
    @endvolt
</x-layouts.auth>
