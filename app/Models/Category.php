<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='categories';
    protected $fillable=['name','parent_id','description','image','status','slug'];

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');

    }
    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id')
        ->withDefault([
            'name'=>'-'
        ]);
    }
    public function child(){
        return $this->hasMany(Category::class,'category_id','id');

    }
    

    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }
    // public function scopeStatus(Builder $builder,$status){
    //     $builder->where('status','=',$status);

    // }
    public function scopeFilter(Builder $builder ){
        $builder->when($filters['name']?? false,function($builder,$value){
            $builder->where('name','LIKE',"{% $value%}");
        });
        $builder->when($filters['status']?? false,function($builder,$value){
            $builder->where('status','LIKE',"{% $value%}");
        });
    }
    

    public static function rules($id=0){
        return [
            'name'=>[
                'required',
                 'string',
                 'min:3',
                 'max:255',
                 Rule::unique('categories','name')->ignore($id),
                //  function ($attribute,$value,$fails){
                //     if(strtolower($value)=='laravel'){
                //         $fails("this is name is forbidden");
                //     }
                //  }, 
                // 'filter:laravel,php,html',
                new Filter(['laravel','php','html',]),
                
            ],
            'parent_id'=>[
                'nullable','int','exists:categories,id'
            ],
            'image'=>[
                'image','max:1048576','dimensions:min_width=100,min_height=100',
   
            ],
             'status'=>'required|in:active,archived',


        ];
    }
}
