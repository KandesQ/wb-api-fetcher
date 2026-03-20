<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FetchStocks extends WbApiAbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "fetch:stocks";
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetches stock data from the WB API for the current day";

    private const STOCK_VALIDATION_RULES = [
        'date' => 'nullable|date',
        'last_change_date' => 'nullable|date',
        'supplier_article' => 'nullable|string',
        'tech_size' => 'nullable|string',
        'barcode' => 'required|integer',
        'quantity' => 'nullable|integer',
        'quantity_full' => 'nullable|integer',
        'is_supply' => 'nullable|boolean',
        'is_realization' => 'nullable|boolean',
        'warehouse_name' => 'required|string',
        'in_way_to_client' => 'nullable|integer',
        'in_way_from_client' => 'nullable|integer',
        'nm_id' => 'required|integer',
        'subject' => 'nullable|string',
        'category' => 'nullable|string',
        'brand' => 'nullable|string',
        'sc_code' => 'required|integer',
        'price' => 'nullable|string',
        'discount' => 'nullable|string',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetches stock data from the WB API for the current day and upserts it into the database.
     *
     * The method paginates through all available stock data for today,
     * validates each record against the defined rules, logs invalid entries,
     * and inserts or updates valid records using the upsert method.
     *
     * @return int Exit code (0 for success)
     */
    public function handle(): int
    {
        $page = 1;

        do {
            // Get stocks
            Log::info("Fetching page=$page");

            $stocks = $this->fetchData(
                "/stocks",
                [
                    "page" => $page,
                    "dateFrom" => Carbon::today()->format("Y-m-d")
                ]
            );

            Log::info("Total amount of fetched stocks: " . \count($stocks));

            $createdRecords = [];

            // Validation
            foreach ($stocks as $stock) {
                $validation = Validator::make($stock, self::STOCK_VALIDATION_RULES);

                if ($validation->fails()) {
                    Log::warning(
                        "Invalid stock format",
                        [
                            "stock" => $stock,
                            "page" => $page,
                            "errors" => $validation->failed()
                        ]
                    );
                    continue;
                }
                $createdRecords[] = $stock;
            }

            $affected = Stock::upsert(
                $createdRecords,
                ["nm_id", "sc_code", "barcode", "warehouse_name"],
                [
                    'date',
                    'last_change_date',
                    'supplier_article',
                    'tech_size',
                    'quantity',
                    'is_supply',
                    'is_realization',
                    'quantity_full',
                    'in_way_to_client',
                    'in_way_from_client',
                    'subject',
                    'category',
                    'brand',
                    'price',
                    'discount'
                ]
            );

            Log::info("Page=$page processed. Rows upserted: $affected");

            $page++;
        } while (!empty($stocks));
        
        return 0;
    }
}
