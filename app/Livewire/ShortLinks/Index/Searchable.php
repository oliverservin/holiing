<?php

namespace App\Livewire\ShortLinks\Index;

trait Searchable
{
    public $search = '';

    public function updatedSearchable($property)
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    protected function applySearch($query)
    {
        return $this->search === ''
            ? $query
            : $query
                ->where('url', 'like', '%'.$this->search.'%')
                ->orWhere('hashid', 'like', '%'.$this->search.'%');
    }
}
