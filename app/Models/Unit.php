<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_id', 'parent_id', 'location_id', 'slug'];

    public function type() { return $this->belongsTo(UnitType::class); }

    public function parent() { return $this->belongsTo(Unit::class, 'parent_id'); }

    public function children() { return $this->hasMany(Unit::class, 'parent_id'); }

    public function location() { return $this->belongsTo(Location::class); }

    public function users() { return $this->belongsToMany(User::class, 'user_unit'); }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($unit) {
            $unit->slug = Str::slug($unit->name . '-' . uniqid());
        });
    }
}