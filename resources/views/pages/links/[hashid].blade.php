<?php

use App\DomainWithoutWWWGenerator;
use App\Models\ClickEvent;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;

middleware('domain');

render(function (View $view, Request $request) {
    $link = $request->domain->links()->where('hashid', $request->hashid)->firstOrFail();

    $agent = new Agent();
    $referer = $request->header('referer');
    $domainWithoutWWWGenerator = new DomainWithoutWWWGenerator($referer);
    $domainWithoutWWW = $domainWithoutWWWGenerator->generate();

    $clickEvent = ClickEvent::create([
        'domain_id' => $request->domain->id,
        'short_link_id' => $link->id,
        'country' => ($location = Location::get()) ? $location->countryCode : 'unknown',
        'device' => $agent->deviceType() === 'other' ? 'unknown' : $agent->deviceType(),
        'browser' => $browser = $agent->browser() ?? 'unknown',
        'bot' => $agent->isRobot(),
        'referer' => $domainWithoutWWW ?? 'unknown',
    ]);

    $link->increment('clicks');
    $link->last_clicked_at = now();
    $link->save();

    return redirect($link->url, 307);
});

?>

lkjsdf
