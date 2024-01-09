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
        'country' => ($location = Location::get()) ? $location->countryCode : 'Unknown',
        'device' => $agent->device() ?? 'Unknown',
        'browser' => $browser = $agent->browser() ?? 'Unknown',
        'browser_version' => $agent->version($browser) ?? 'Unknown',
        'platform' => $platform = $agent->platform() ?? 'Unknown',
        'platform_version' => $agent->version($platform) ?? 'Unknown',
        'bot' => $agent->isRobot(),
        'ua' => $agent->getUserAgent() ?? 'Unknown',
        'referer' => $domainWithoutWWW ?? '(direct)',
        'referer_url' => $referer ?? '(direct)',
    ]);

    $link->increment('clicks');
    $link->last_clicked_at = now();
    $link->save();

    return redirect($link->url, 301);
});

?>

lkjsdf
