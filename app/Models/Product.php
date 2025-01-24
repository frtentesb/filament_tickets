<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Products\CategoryProductEnum;
use App\Enums\Products\ManufacturerProductEnum;

class Product extends Model
{
    protected $fillable = [

        'description',
        'price',
        'category',
        'image',
        'manufacturer',
    ];

    protected $casts = [

        'category' => CategoryProductEnum::class,
        'image' => 'array',



    ];




        //
    }

