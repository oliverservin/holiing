<?php

namespace App\Policies;

use App\Models\ShortLink;
use App\Models\User;

class ShortLinkPolicy
{
    public function view(User $user, ShortLink $shortLink): bool
    {
        return $user->currentTeam->id === $shortLink->domain->team->id;
    }

    public function delete(User $user, ShortLink $shortLink): bool
    {
        return $user->currentTeam->id === $shortLink->domain->team->id;
    }

    public function archive(User $user, ShortLink $shortLink): bool
    {
        return $user->currentTeam->id === $shortLink->domain->team->id;
    }
}
