<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'parent_id', 'slug'];

    protected $casts = ['type' => 'string'];

    public function parent() { return $this->belongsTo(Location::class, 'parent_id'); }

    public function children() { return $this->hasMany(Location::class, 'parent_id'); }

    public function units() { return $this->hasMany(Unit::class); }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($location) {
            $location->slug = Str::slug($location->name . '-' . uniqid());
        });
    }
}