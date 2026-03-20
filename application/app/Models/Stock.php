<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        "date", "last_change_date", "supplier_article",
        "tech_size", "barcode", "quantity", "quantity_full",
        "is_supply", "is_realization", "warehouse_name", "in_way_to_client",
        "in_way_from_client", "nm_id", "subject", "category", "brand",
        "sc_code", "price", "discount"
    ];

    protected $casts = [
        "date" => "date",
        "last_change_date" => "date", 
        "supplier_article" => "string",
        "tech_size" => "string", 
        "barcode" => "integer", 
        "quantity" => "integer", 
        "quantity_full" => "integer",
        "is_supply" => "boolean", 
        "is_realization" => "boolean", 
        "warehouse_name" => "string", 
        "in_way_to_client" => "integer",
        "in_way_from_client" => "integer", 
        "nm_id" => "string", 
        "subject" => "string", 
        "category" => "string", 
        "brand" => "string",
        "sc_code" => "integer", 
        "price" => "decimal:2", 
        "discount" => "decimal:2"
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'id'
    ];
}
