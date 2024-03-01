<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
     use HasFactory;
	use SoftDeletes;
	
  	protected $fillable = [
        'product_id',
		'image',
        'created_at',
        'updated_at',
        'deleted_at',
		
		];
}
