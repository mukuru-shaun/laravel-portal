<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApplicationInstance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }
}
