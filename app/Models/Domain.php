<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $casts = [
        'public_domain' => 'boolean',
    ];

    protected $fillable = [
        'public_domain',
    ];
}
