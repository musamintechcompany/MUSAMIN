<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Vinkla\Hashids\Facades\Hashids;

class Idea extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'benefits',
        'additional_info',
        'media_files',
        'contact_email',
        'contact_phone',
        'country_code',
        'status',
        'hashid'
    ];
    
    protected $casts = [
        'media_files' => 'array',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($idea) {
            if (empty($idea->hashid)) {
                $idea->hashid = Hashids::encode($idea->id ?? rand(1000, 9999));
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
