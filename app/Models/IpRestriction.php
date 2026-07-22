<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpRestriction extends Model
{
    protected $fillable = ['ip_pattern', 'label', 'is_active',];
}
