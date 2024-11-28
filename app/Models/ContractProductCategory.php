<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractProductCategory extends Model
{
    protected $table="contract_product_categories";

    protected $fillable=[
        "contract_id",
        "product_category_id",
    ];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract','contract_id');
    }

    public function product_category()
    {
        return $this->belongsTo('App\Models\Category','product_category_id');
    }
}
