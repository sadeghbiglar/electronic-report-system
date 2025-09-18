<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitTypeRelationship extends Model
{
    use HasFactory;

    protected $fillable = ['parent_type_id', 'child_type_id'];

    public function parentType() { return $this->belongsTo(UnitType::class, 'parent_type_id'); }

    public function childType() { return $this->belongsTo(UnitType::class, 'child_type_id'); }
}