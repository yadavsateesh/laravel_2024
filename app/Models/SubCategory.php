<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    
	use HasFactory;
	use SoftDeletes;
	
  	protected $fillable = [
        'category_id',
        'subcategory_name',
		'status',
        'created_at',
        'updated_at',
        'deleted_at',
		
		];
		
		  protected $dates = [ 'deleted_at' ];
}
