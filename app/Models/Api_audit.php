<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_audit extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'user_type',
		'user_id',
		'api_name',
		'request_json',
		'response_json',
		'created_at',
		'time_taken',
		'updated_at',
    ];
}
