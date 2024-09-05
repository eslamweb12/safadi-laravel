<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class Product extends Model
{
    use HasFactory;
    
    protected $table='products';


    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ];
    protected $hidden=[
        'image',
        'created_at','updated_at','deleted_at'
    ]; 

    protected $appends =[
        'image_url'
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');

    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag',  // Pivot table name
            'product_id',   // FK in pivot table for the current model
            'tag_id',       // FK in pivot table for the related model
            'id',           // PK current model
            'id'            // PK related model
        );
    }
    public function ScopeActive(Builder $builder){
        $builder->where('status','=','active');
    }
    public function getImageUrlAttribute(){
        if(!$this->image){

            return 'https://app.advaiet.com/item_dfile/default_product.png';
        }
        if(Str::startsWith($this->image,['http://','https://'])){
            return $this->image;
        }
        return asset('storage/' .$this->image);

    }
    public function getSalePercentAttribute(){
        if(!$this->compare_price){
            return 0;
        }
        return rand(100 - (100 *  $this->price/$this->compare_price),1);
    }
    protected static function booted(){
        static::addGlobalScope('store',function(Builder $builder){
            $user=Auth::user();
            if($user && $user->store_id){
                $builder->where('store_id','=',$user->store_id);


            }

        });

        static::creating(function(Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function scopeFilter(Builder $builder,$filters){
        $options=array_merge([
            'store_id'=>null,
             'category_id'=>null,
             'tag_id'=>null,
             'status'=>'active'
        ],$filters);
        $builder->when($options['status'],function($query,$status){
           return $query->where('status',$status);
        });
        $builder->when($options['category_id'],function($builder,$value){

            $builder->where('category_id',$value);
        });
        $builder->when($options['tag_id'],function($builder,$value){
            $builder->whereExists(function($query) use($value){
                $query->select(1)
                ->from('product_tag')
                ->whereRaw('product_id=product.id')
                ->where('tag_id',$value);
            });
        });
        
    }
}
