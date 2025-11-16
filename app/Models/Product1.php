<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Attribute;
use Illuminate\Database\Eloquent\Model;

class Product1 extends Model
{
    protected $fillable=[
        "name","price","metadata","released_at","secret_notes",
    ];

        protected $casts = [
        'metadata'     => 'array',        // JSON → array
        'released_at'  => 'date',         // Date casting
        'secret_notes' => 'encrypted',    // Auto encrypted
        'price'        => MoneyCast::class   // Custom cast
    ];

    // Accessor + Mutator for name
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),     // Output: Capitalized
            set: fn($value) => strtolower($value),  // Store: lowercase
        );
    }
}
