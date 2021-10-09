<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Category extends Model
{
	protected $table = 'categories';
	public $timestamps = false;

	protected $appends = ['sub_categories'];

	public function scopeMainCategories()
	{
		return $this->where('parent_product_category_id', 0)
			->where('level', 1);
	}

	public function getSubCategoriesAttribute()
	{
		return $this->subCategories();
	}

	public function subCategories()
	{
		if ($this->level == 1) {
			return $this->where('parent_product_category_id', $this->product_category_id)
			->where('level', 2)
			->orderBy('order_no')
			->get();
		} else if ($this->level == 2) {
			return $this->where('parent_product_category_id', $this->product_category_id)
			->where('level', 3)
			->orderBy('order_no')
			->get();
		} else {
			return [];
		}

	}

	public static function getGenreNameById($id){
        return Category::where('product_category_id',$id)->first();
    }
}
