<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Venue extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'notes',
        'street_address',
        'city',
        'maximum_stage_width',
        'maximum_stage_depth',
        'maximum_stage_height',
        'maximum_seats',
        'maximum_wheelchair_seats',
        'number_of_dressing_rooms',
        'backstage_wheelchair_access',
        'region_id',
        'venue_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'maximum_stage_width' => 'integer',
        'maximum_stage_depth' => 'integer',
        'maximum_stage_height' => 'integer',
        'maximum_seats' => 'integer',
        'maximum_wheelchair_seats' => 'integer',
        'number_of_dressing_rooms' => 'integer',
        'backstage_wheelchair_access' => 'boolean',
        'region_id' => 'integer',
        'venue_type_id' => 'integer',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'notes' => $this->notes,
            'street_address' => $this->street_address,
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function venueType(): BelongsTo
    {
        return $this->belongsTo(VenueType::class);
    }

    public function accessEquipments(): BelongsToMany
    {
        return $this->belongsToMany(AccessEquipment::class);
    }

    public function dealTypes(): BelongsToMany
    {
        return $this->belongsToMany(DealType::class);
    }
}
