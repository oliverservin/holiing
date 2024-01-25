<?php

namespace App\Policies;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShortLinkPolicy
{
    public function view(User $user, ShortLink $shortLink): bool
    {
        return $user->currentTeam->id === $shortLink->domain->team->id;
    }
}
