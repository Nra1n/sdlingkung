<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public const LEVELS = ['Sekolah', 'Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional'];

    protected $fillable = [
        'title',
        'level',
        'year',
        'description',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'year' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getLevelColorAttribute(): string
    {
        return match ($this->level) {
            'Nasional' => 'danger',
            'Provinsi' => 'warning',
            'Kabupaten' => 'info',
            'Kecamatan' => 'success',
            default => 'secondary',
        };
    }
}
