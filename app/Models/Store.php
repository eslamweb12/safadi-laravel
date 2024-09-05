<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    protected $table='stores';
    protected $connection='mysql';
    protected $keyType='int';
    protected $primaryKey='id';
    public $incrementing=true;
    public $timestamps = true;
    public function products(){
        $this->hasMany(Product::class,'store_id','id');
    }

}
