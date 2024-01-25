<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'gambar',
        'judul',
        'short_description',
        'long_description',
        'category',
    ];

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model){
            if($model->isDirty('gambar') && ($model->getOriginal('gambar') !== null))
                Storage::disk('public')->delete($model->getOriginal('gambar'));
            }
        );
    }
}
