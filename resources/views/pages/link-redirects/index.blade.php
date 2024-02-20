<?php

use Illuminate\Http\Request;
use Illuminate\View\View;

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;

middleware('domain');

render(function (View $view, Request $request) {
    if ($landingPage = $request->domain->landing_page) {
        return redirect($landingPage, 301);
    }
});

?>

hello
