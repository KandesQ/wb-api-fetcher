<?php

namespace App\Console\Commands;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FetchSales extends WbApiAbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches sales data from the WB API for the current day';

    private const SALE_VALIDATION_RULES = [
        "g_number" => "nullable|string",
        "date" => "nullable|date",
        "last_change_date" => "nullable|date",
        "supplier_article" => "nullable|string",
        "tech_size" => "nullable|string",
        "barcode" => "nullable|integer",
        "total_price" => "nullable|string",
        "discount_percent" => "nullable|string",
        "is_supply" => "nullable|boolean",
        "is_realization" => "nullable|boolean",
        "promo_code_discount" => "nullable|string",
        "warehouse_name" => "nullable|string",
        "country_name" => "nullable|string",
        "oblast_okrug_name" => "nullable|string",
        "region_name" => "nullable|string",
        "income_id" => "nullable|integer",
        "sale_id" => "required|string",
        "odid" => "nullable|string",
        "spp" => "nullable|string",
        "for_pay" => "nullable|string",
        "finished_price" => "nullable|string",
        "price_with_disc" => "nullable|string",
        "nm_id" => "nullable|integer",
        "subject" => "nullable|string",
        "category" => "nullable|string",
        "brand" => "nullable|string",
        "is_storno" => "nullable|boolean"
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
            // Get sales
            Log::info("Fetching page=$page");

            $sales = $this->fetchData(
                "/sales",
                [
                    "page" => $page,
                    "dateFrom" => "1970-01-01",
                    "dateTo" => Carbon::today()->format("Y-m-d")
                ]
            );

            Log::info("Total amount of fetched sales: " . \count($sales));

            // Validation
            $createdRecords = [];

            foreach ($sales as $sale) {
                $validation = Validator::make($sale, self::SALE_VALIDATION_RULES);

                if ($validation->fails()) {
                    Log::warning(
                        "invalid sale format",
                        [
                            "sale" => $sale,
                            "page" => $page,
                            "errors" => $validation->failed()
                        ]
                    );
                    continue;
                }
                $createdRecords[] = $sale;
            }

            $upserted = Sale::upsert(
                $createdRecords,
                ["sale_id"],
                [
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
                ]
            );

            Log::info("Page=$page processed. Rows upserted: $upserted");

            $page++;
        } while (!empty($sales));

        return 0;
    }
}
