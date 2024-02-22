<?php

namespace App\Livewire\ShortLinks\Index;

use App\Models\ShortLink;

trait Archivable
{
    public $showArchive = false;

    public function updatedArchivable($property)
    {
        if ($property === 'showArchive') {
            $this->resetPage();
        }
    }

    public function archive(ShortLink $shorLink)
    {
        $this->authorize('archive', $shorLink);

        $shorLink->archive();
    }

    protected function applyArchive($query)
    {
        return $this->showArchive
            ? $query
            : $query->whereNull('archived_at');
    }
}
