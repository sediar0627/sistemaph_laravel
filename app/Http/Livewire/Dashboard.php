<?php

namespace App\Http\Livewire;

use App\Models\LecturaPiscina;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public User $usuario;
    public $lecturas = [];

    public function mount()
    {
        $this->usuario = Auth::user();
    }

    public function render()
    {
        $id_piscinas = $this->usuario->piscinas->pluck("id");

        $this->lecturas = LecturaPiscina::with(["piscina", "notificacion"])
            ->whereIn("piscina_id", $id_piscinas)
            ->orderBy("id", "desc")
            ->take(30)
            ->get();

        return view('livewire.dashboard');
    }
}
