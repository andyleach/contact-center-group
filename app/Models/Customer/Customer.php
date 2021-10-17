<?php

namespace App\Models\Customer;

use App\Models\Lead\Lead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    public function leads(): HasMany {
        return $this->hasMany(Lead::class, 'lead_id');
    }
}
