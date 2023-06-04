<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;

    const SYSTEM_NORTH = 'north';

    const SYSTEM_MIDLANDS = 'midlands';

    const SYSTEM_SOUTH_EAST = 'south-east';

    const SYSTEM_SOUTH_WEST = 'south-west';

    const SYSTEM_LONDON = 'london';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'notes',
        'system',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'system' => 'integer',
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}
