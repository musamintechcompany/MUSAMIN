<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservedWord extends Model
{
    protected $fillable = ['word', 'type', 'reason'];

    public static function isReserved(string $word): bool
    {
        return static::where('word', strtolower($word))->exists();
    }

    public static function addReservedWords(array $words, string $type = 'route', string $reason = null): void
    {
        foreach ($words as $word) {
            static::firstOrCreate(
                ['word' => strtolower($word)],
                ['type' => $type, 'reason' => $reason]
            );
        }
    }
}