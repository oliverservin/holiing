<?php

use App\Models\Domain;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

middleware('signed');

name('domains.mark-as-verified');

render(function (Domain $domain) {
    $domain->verified_at = now();

    $domain->save();

    return 'Dominio marcado como verificado';
});

?>
