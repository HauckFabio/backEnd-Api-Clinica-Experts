<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $fillable = [
        'Identificacao', 'LinkEncurtado', 'LinkOriginal', 'NumeroDeAcessos', 
    ];

    public function regras()
    {
        return [
            'Identificacao' => 'required|unique:links',
            'Link' => 'required',
        ];
    }

}