<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        "sale_id",
        "g_number",
        "date",
        "last_change_date",
        "supplier_article",
        "tech_size",
        "barcode",
        "total_price",
        "discount_percent",
        "is_supply",
        "is_realization",
        "promo_code_discount",
        "warehouse_name",
        "country_name",
        "oblast_okrug_name",
        "region_name",
        "income_id",
        "odid",
        "spp",
        "for_pay",
        "finished_price",
        "price_with_disc",
        "nm_id",
        "subject",
        "category",
        "brand",
        "is_storno"
    ];

    protected $casts = [
        "sale_id" => "string",
        "g_number" => "string",
        "date" => "date",
        "last_change_date" => "date",
        "supplier_article" => "string",
        "tech_size" => "string",
        "barcode" => "integer",
        "total_price" => "string",
        "discount_percent" => "string",
        "is_supply" => "boolean",
        "is_realization" => "boolean",
        "promo_code_discount" => "string",
        "warehouse_name" => "string",
        "country_name" => "string",
        "oblast_okrug_name" => "string",
        "region_name" => "string",
        "income_id" => "string",
        "odid" => "string",
        "spp" => "string",
        "for_pay" => "string",
        "finished_price" => "string",
        "price_with_disc" => "string",
        "nm_id" => "string",
        "subject" => "string",
        "category" => "string",
        "brand" => "string",
        "is_storno" => "boolean"
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'id'
    ];
}
