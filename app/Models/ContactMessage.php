<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    const SUBJECTS = [
        'استفسار' => 'استفسار',
        'شكوى' => 'شكوى',
        'اقتراح' => 'اقتراح',
    ];

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
