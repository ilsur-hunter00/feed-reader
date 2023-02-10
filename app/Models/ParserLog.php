<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $request_method
 * @property $request_url
 * @property $response_code
 * @property $response_body
 * @property $request_time
 */
class ParserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_method',
        'request_url',
        'response_code',
        'response_body',
        'request_time'
    ];
}
