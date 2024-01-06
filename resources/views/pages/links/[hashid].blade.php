<?php

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;

middleware('domain');

render(function (View $view, Request $request) {
    ray($request->domain);
    $link = $request->domain->links()->where('hashid', $request->hashid)->firstOrFail();

    return redirect($link->url, 301);
});

?>

lkjsdf
