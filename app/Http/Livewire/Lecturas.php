<?php

namespace App\Http\Livewire;

use App\Models\LecturaPiscina;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Lecturas extends Component
{
    public $piscinas = [];

    public $cantidad_lecturas_inicial = 0;

    public function mount()
    {
        $piscinas = Auth::user()->piscinas;
        $this->piscinas = json_encode($piscinas->pluck('nombre')->toArray());
        foreach ($piscinas as $piscina) {
            $this->cantidad_lecturas_inicial += $piscina->lecturas->count();
        }
    }

    public function render()
    {
        return view('livewire.lecturas');
    }
}
