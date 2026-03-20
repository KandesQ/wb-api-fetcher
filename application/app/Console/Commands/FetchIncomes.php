<?php

namespace App\Console\Commands;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FetchIncomes extends WbApiAbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:incomes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetches incomes data from the WB API for all time";

    private const INCOME_VALIDATION_RULES = [
        "income_id" => "required|numeric",
        "number" => "nullable|string",
        "date" => "nullable|date",
        "last_change_date" => "nullable|date",
        "supplier_article" => "nullable|string",
        "tech_size" => "nullable|string",
        "barcode" => "nullable|integer",
        "quantity" => "nullable|integer",
        "total_price" => "nullable|string",
        "date_close" => "nullable|string",
        "warehouse_name" => "nullable|string",
        "nm_id" => "nullable|integer"
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
            // Get incomes
            Log::info("Fetching page=$page");

            $incomes = $this->fetchData(
                "/incomes",
                [
                    "page" => $page,
                    "dateFrom" => "1970-01-01",
                    "dateTo" => Carbon::today()->format("Y-m-d")
                ]
            );

            Log::info("Total amount of fetched incomes: " . \count($incomes));

            // Validation
            $createdRecords = [];

            foreach ($incomes as $income) {
                $validation = Validator::make($income, self::INCOME_VALIDATION_RULES);

                if ($validation->fails()) {
                    Log::warning(
                        "invalid income format",
                        [
                            "income" => $income,
                            "page" => $page,
                            "errors" => $validation->failed()
                        ]
                    );
                    continue;
                }
                $createdRecords[] = $income;
            }

            $upserted = Income::upsert(
                $createdRecords,
                ["income_id"],
                [
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
                ]
            );

            Log::info("Page=$page processed. Rows upserted: $upserted");

            $page++;
        } while (!empty($incomes));

        return 0;
    }
}
