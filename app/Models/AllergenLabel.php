<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllergenLabel extends Model
{
    use HasFactory;

    protected $table = 'allergen_labels';

    protected $fillable = [
        'code',
        'name_en',
        'name_nl',
        'icon_class',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function menuItems()
    {
        return $this->belongsToMany(
            \Igniter\Local\Models\Menus_model::class,
            'menu_item_allergen',
            'allergen_label_id',
            'menu_item_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'nl' ? $this->name_nl : $this->name_en;
    }
}
