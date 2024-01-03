<?php

use function Laravel\Folio\render;

render(function () {
    return response()->json(['ok' => true]);
});

?>
