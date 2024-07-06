<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'reff',
        'target',
        'value',
        'note',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'reff', 'id');
    }
    public function target()
    {
        return $this->belongsTo(User::class, 'target', 'id');
    }
}
