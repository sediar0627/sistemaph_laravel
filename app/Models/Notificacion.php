<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    public const ESTADOS = [
        "PENDIENTE" => 1,
        "ENVIADA" => 2
    ];

    protected $fillable = [
        'estado',
        'mensaje',
        'lectura_piscina_id',
        'piscina_id'
    ];

    public function lectura(): BelongsTo
    {
        return $this->belongsTo(LecturaPiscina::class, 'lectura_piscina_id');
    }

    public function piscina(): BelongsTo
    {
        return $this->belongsTo(Piscina::class, 'piscina_id');
    }
}
