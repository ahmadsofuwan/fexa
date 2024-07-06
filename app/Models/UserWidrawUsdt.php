<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWidrawUsdt extends Model
{
    use HasFactory;
    protected $fillable = [
        'reff',
        'saldo',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'reff', 'id');
    }
}
