<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DatabaseServer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function databases(): HasMany
    {
        return $this->hasMany(DatabaseServer::class);
    }
}
