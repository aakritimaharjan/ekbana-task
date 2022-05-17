<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
	    'category_id',
	    'title',
	    'image',
	    'description',
	    'status'
	];

	public function categoryDetail() {
		return $this->hasOne(CompanyCategory::class, 'id', 'category_id');
	}
}
