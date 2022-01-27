<?php

namespace App\Http\Livewire;

use App\Models\Piscina;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Piscinas extends Component
{
    use WithPagination;

    protected $rules = [
        "piscina.nombre" => "required|string",
        "piscina.litros" => "required|numeric"
    ];

    protected $messages = [
        'piscina.nombre.required' => 'El campo nombre no puede estar vacio.',
        'piscina.nombre.string' => 'El campo nombre debe ser alfanumerico.',
        'piscina.litros.required' => 'El campo litros no puede estar vacio.',
        'piscina.litros.string' => 'El campo litros debe ser numerico.',
    ];

    public Piscina $piscina;
    public User $user;
    public $piscinas;

    public function LimpiarCampos()
    {
        $this->piscina = new Piscina();
        $this->user = $this->user->refresh();
    }

    public function GuardarPiscina()
    {

        $this->validate();

        if ($this->piscina->id == null) {
            $this->piscina->user_id = $this->user->id;
            Piscina::create($this->piscina->getAttributes());
            $this->LimpiarCampos();
            $this->render();
        } else {
            $this->piscina->update($this->piscina->getAttributes());
            $this->LimpiarCampos();
            $this->render();
        }
    }

    public function BuscarPiscina($uuid)
    {
        $this->piscina = Piscina::where("uuid", $uuid)->first();
    }

    public function EliminarPiscina($uuid)
    {
        $this->BuscarPiscina($uuid);
        $this->piscina->delete();
        $this->LimpiarCampos();
        $this->render();
    }

    public function mount()
    {
        $this->piscina = new Piscina();
        $this->piscina->litros = "";
        $this->user = User::find(Auth::user()->id);
    }

    public function render()
    {
        $this->piscinas = $this->user->piscinas;

        return view('livewire.piscinas');
    }
}
