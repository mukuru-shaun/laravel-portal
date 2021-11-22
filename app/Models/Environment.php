<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Environment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const PRODUCTION = 'production';
    public const STAGING = 'staging';
    public const REVIEW = 'review';

    public function applicationInstances(): HasMany
    {
        return $this->hasMany(ApplicationInstance::class);
    }
}
