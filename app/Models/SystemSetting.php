<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * Scope by key.
     */
    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    /**
     * Scope by group.
     */
    public function scopeOfGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Set a setting (create or update).
     */
    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key, 'group' => $group],
            ['value' => is_bool($value) ? ($value ? '1' : '0') : (string) $value, 'type' => $type]
        );
    }
}
