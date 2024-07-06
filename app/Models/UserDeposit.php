<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeposit extends Model
{
    use HasFactory;
    protected $fillable = [
        'deposit_id',
        'reffid',
        'hashid',
        'status',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'reffid', 'id');
    }
}
