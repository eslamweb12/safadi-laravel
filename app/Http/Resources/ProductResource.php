<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'price'=>[
                'normal'=>$this->price,
                'compare_price'=>$this->compare_price,
            ],
            'description'=>$this->description,
            'image'=> $this->image_url,
            'relations'=>[
                
                'category'=>[
                    'id'=>$this->id,
                    'name'=>$this->name,

                ],
                'stor'=>[
                    'id'=>$this->id,
                    'name'=>$this->name,
                ],
            ],
            
        ];
    }
}
