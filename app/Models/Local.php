<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Local extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'estado',
    ];
}
