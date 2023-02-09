<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $description
 * @property $publication_date
 * @property $author
 * @property $image
 */
class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'publication_date',
        'author',
        'image'
    ];
}
