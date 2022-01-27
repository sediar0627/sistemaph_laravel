<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LecturaPiscina extends Model
{
    use HasFactory;

    protected $fillable = [
        'lectura',
        'piscina_id'
    ];

    public function piscina(): BelongsTo
    {
        return $this->belongsTo(Piscina::class, 'piscina_id');
    }
}
