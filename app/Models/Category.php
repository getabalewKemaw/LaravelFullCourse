<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];


    // Always store name in lowercase, present it as Title Case
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => trim(strtolower($value))
        );
    }

    // Boot: ensure slug is set and unique on create/update
    protected static function booted()
    {
        static::creating(function (Category $model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });

        static::updating(function (Category $model) {
            // If name changed and slug wasn't explicitly changed, refresh slug
            if ($model->isDirty('name') && ! $model->isDirty('slug')) {
                $model->slug = static::generateUniqueSlug($model->name, $model->id);
            }
        });
    }

    /**
     * Generate a unique slug based on name.
     *
     * @param string $name
     * @param int|null $ignoreId
     * @return string
     */
    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    // (Optional) Example relationship if you later want to load products:
    // public function products() { return $this->hasMany(Product::class); }
}
