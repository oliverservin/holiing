<?php

use App\Models\ShortLink;

use function Laravel\Folio\render;

render(function (ShortLink $shortLink) {
    return redirect($shortLink->url, 301);
});
