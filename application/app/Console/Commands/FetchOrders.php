<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FetchOrders extends WbApiAbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches all orders data from the WB API';

    private const ORDER_VALIDATION_RULES = [
        "g_number" => "required|string",
        "date" => "nullable|date",
        "last_change_date" => "nullable|date",
        "supplier_article" => "nullable|string",
        "tech_size" => "nullable|string",
        "barcode" => "required|integer",
        "total_price" => "nullable|string",
        "discount_percent" => "nullable|integer",
        "warehouse_name" => "nullable|string",
        "oblast" => "nullable|string",
        "income_id" => "nullable|integer",
        "odid" => "nullable|string",
        "nm_id" => "required|numeric",
        "subject" => "nullable|string",
        "category" => "nullable|string",
        "brand" => "nullable|string",
        "is_cancel" => "nullable|boolean",
        "cancel_dt" => "nullable|date"
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $page = 1;

        do {
            // Get orders
            Log::info("Fetching page=$page");

            $orders = $this->fetchData(
                "/orders",
                [
                    "page" => $page,
                    "dateFrom" => "1970-01-01",
                    "dateTo" => Carbon::today()->format("Y-m-d")
                ]
            );

            Log::info("Total amount of fetched orders: " . \count($orders));

            // Validation
            $createdRecords = [];

            foreach ($orders as $order) {
                $validation = Validator::make($order, self::ORDER_VALIDATION_RULES);

                if ($validation->fails()) {
                    Log::warning(
                        "invalid order format",
                        [
                            "order" => $order,
                            "page" => $page,
                            "errors" => $validation->failed()
                        ]
                    );
                    continue;
                }
                $createdRecords[] = $order;
            }

            $upserted = Order::upsert(
                $createdRecords,
                ["g_number", "barcode", "nm_id"],
                [
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
                    "cancel_dt"
                ]
            );

            Log::info("Page=$page processed. Rows upserted: $upserted");

            $page++;
        } while (!empty($orders));

        return 0;
    }
}
