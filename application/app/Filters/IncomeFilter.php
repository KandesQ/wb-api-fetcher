<?php

namespace App\Filters;

use App\Models\Income;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class IncomeFilter implements FilterInterface
{
    public static function searchByRequest (FormRequest $request): Builder
    {
        return Income::query()
            ->whereBetween('date', [
                $request->dateFrom,
                $request->dateTo,
            ]);
    }
}