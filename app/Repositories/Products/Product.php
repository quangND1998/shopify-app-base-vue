<?php
namespace App\Repositories\Products;

use Darkness\Repository\Entity;

class Product extends Entity
{
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->table = 'products';
    }

    /**
    * The attributes that are mass assignable.
    *
    * @var  array
    */
    protected $fillable = [
        'name', 'price', 'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'variants' => 'array',
    ];

    const UPDATED_AT = 'last_update';
    // public  $timestamps =  false; // Sử dụng khi bảng không có trường created_at, updated_at
}
