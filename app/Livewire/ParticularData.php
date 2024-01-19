<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Pagination\Paginator;

class ParticularData extends Component
{
    use WithPagination;

    public $searchInput = '';
    public $selectColumn = 'assessment'; // Default column value

    public function render()
    {
        Paginator::useBootstrap();
        $data = DB::table('mis')
            ->where($this->selectColumn, 'like', '%' . $this->searchInput . '%')
            ->paginate(10);

        return view('livewire.particular-data', ['data' => $data]);
    }

    public function updateData()
    {
        $this->resetPage(); // Reset pagination when data changes
    }
}
