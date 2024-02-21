<?php

namespace App\Livewire\ShortLinks\Index;

use Livewire\Attributes\Url;

trait Sortable
{
    #[Url]
    public $sortCol;

    #[Url]
    public $sortAsc = false;

    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    protected function applySorting($query)
    {
        if ($this->sortCol) {
            $column = match ($this->sortCol) {
                'date' => 'created_at',
                'clics' => 'clicks',
                'last_clicked' => 'last_clicked_at',
            };

            $query->orderBy($column, $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
