<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'label'];

    public function units() { return $this->hasMany(Unit::class, 'type_id'); }
    public function allowedChildren() { return $this->hasMany(UnitTypeRelationship::class, 'parent_type_id'); }

public function allowedParents() { return $this->hasMany(UnitTypeRelationship::class, 'child_type_id'); }
}