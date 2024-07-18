<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','title','image','slug','category_id','subcategory_id','brand_id','old_price','price','short_description','is_featured'
        	,'description','additional_information','shipping_returns','status'];

       
            // Product model

      public function categories() { 
               return $this->belongsTo(Category::Class,'category_id');
         }

      public function subcategories() {
               return $this->belongsTo(Subcategory::Class,'subcategory_id');
        }
        public function brands() {
            return $this->belongsTo(Brand::Class,'brand_id');
     }


        public function carts() : HasMany
        {
            return $this->hasMany(Cart::class,'prod_id');
        }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function product_ratings()
    {
        return $this->hasMany(ProductRating::class)->where('status',0);
    }





     protected static function boot()
     {
         parent::boot();
   
         static::created(function ($product) {
             $product->slug = $product->createSlug($product->title);
             $product->save();
         });
     }
   
     /** 
      * Write code on Method
      *
      * @return response()
      */
     private function createSlug($title){
         if (static::whereSlug($slug = Str::slug($title))->exists()) {
             $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');
   
             if (is_numeric($max[-1])) {
                 return preg_replace_callback('/(\d+)$/', function ($mathces) {
                     return $mathces[1] + 1;
                 }, $max);
             }
   
             return "{$slug}-2";
         }
   
         return $slug;
     }
     

}
