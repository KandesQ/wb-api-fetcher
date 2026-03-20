<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "last_change_date",
        "supplier_article",
        "tech_size",
        "total_price",
        "discount_percent",
        "warehouse_name",
        "oblast",
        "income_id",
        "odid",
        "subject",
        "category",
        "brand",
        "is_cancel",
        "cancel_dt",
        "g_number",
        "barcode",
        "nm_id"
    ];

    protected $casts = [
        "date" => "date",
        "last_change_date" => "date",
        "supplier_article" => "string",
        "tech_size" => "string",
        "barcode" => "integer",
        "total_price" => "string",
        "discount_percent" => "integer",
        "warehouse_name" => "string",
        "oblast" => "string",
        "income_id" => "string",
        "odid" => "string",
        "nm_id" => "string",
        "subject" => "string",
        "category" => "string",
        "brand" => "string",
        "is_cancel" => "boolean",
        "cancel_dt" => "date",
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'id'
    ];
}
