<?php

namespace App;

use App\Models\ShortLink;
use Hashids\Hashids;

class HashIdGenerator
{
    public function __construct(protected Hashids $hashids) {}

    public function generate()
    {
        $id = ShortLink::latest()->select('id')->first()?->id ?? 0;

        do {
            $id++;
            $hashid = $this->hashids->encode($id);
        } while (ShortLink::where('hashid', $hashid)->exists());

        return $hashid;
    }
}
