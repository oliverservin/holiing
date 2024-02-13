<?php

namespace App\Livewire\App\Links\Analytics\Index;

use App\Models\ShortLink;
use Livewire\Attributes\Url;
use Livewire\Form;

class Filters extends Form
{
    public ShortLink $shortLink;

    #[Url]
    public Range $range = Range::Last_90;

    public function init($shortLink)
    {
        $this->shortLink = $shortLink;
    }

    public function apply($query)
    {
        $query = $this->applyRange($query);

        return $query;
    }

    public function applyRange($query)
    {
        return $query->whereBetween('created_at', $this->range->dates());
    }
}
