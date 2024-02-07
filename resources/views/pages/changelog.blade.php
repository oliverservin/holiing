<?php

use function Laravel\Folio\render;

use App\Models\Release;
use Illuminate\View\View;

render(function (View $view) {
    return $view->with('releases', Release::orderBy('date', 'desc')->get());
});

?>

<x-layouts.changelog>
    <header class="flex justify-center">
        <div class="w-full max-w-[1112px] px-5">
            <div class="h-[84px] flex justify-between items-center">
                <div>
                    <x-logo />
                </div>
                <x-marketing.nav />
            </div>
        </div>
    </header>
    <main>
        <div class="w-full max-w-[1112px] mx-auto px-5">
            <div class="pt-12 pb-24">
                <h1 class="text-[44px] font-extrabold tracking-tight">Changelog</h1>

                <div class="mt-6 space-y-8">
                    @foreach($releases as $release)
                        <div class="bg-zinc-100 dark:bg-zinc-800 p-8 rounded-lg">
                            <div>
                                <h2 class="text-2xl font-bold">{{ $release->title }}</h2>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $release->dateForHumans() }}</p>
                            </div>
                            <div class="mt-4">
                                <div class="prose prose-zinc prose-sm dark:prose-invert">{!! $release->description() !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</x-layouts.changelog>
