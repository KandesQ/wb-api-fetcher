<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        "income_id",
        "number",
        "date",
        "last_change_date",
        "supplier_article",
        "tech_size",
        "barcode",
        "quantity",
        "total_price",
        "date_close",
        "warehouse_name",
        "nm_id"
    ];

    protected $casts = [
        "income_id" => "string",
        "number" => "string",
        "date" => "date",
        "last_change_date" => "date",
        "supplier_article" => "string",
        "tech_size" => "string",
        "barcode" => "integer",
        "quantity" => "integer",
        "total_price" => "string",
        "date_close" => "string",
        "warehouse_name" => "string",
        "nm_id" => "string",
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'id'
    ];
}
