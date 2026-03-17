<?php

namespace App\Console\Commands;

use Exception;
use App\Exceptions\ApiHasChangedException;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

abstract class WbApiAbstractCommand extends Command
{   
    /**
     * Requested page size limit.
     *
     * @var int
     */
    protected $limit = 500;

    /**
     * WB API base url.
     *
     * @var string
     */
    private readonly string $baseUrl;

    /**
     * WB API access key.
     *
     * @var string
     */
    private readonly string $apiKey;


    public function __construct()
    {
        parent::__construct();

        $this->baseUrl = env("WB_API_BASE_URL", "");
        $this->apiKey = env("WB_API_KEY", "");

        if (!$this->baseUrl || !$this->apiKey)
        {
            throw new \RuntimeException("WB API base URL or API key is not set in .env file");
        }
    }

    /**
     * Fetches data from the given URI
     * 
     * @param string $endpoint URI to fetch data from
     * @param array $params URI query params
     * 
     * @return array array of data records, requested by given URI
     * 
    * @throws \Illuminate\Http\Client\RequestException If the HTTP request fails (network error, 4xx/5xx response, timeout, etc.).
    * @throws \App\Exceptions\ApiHasChangedException If the API response does not contain the expected "data" key.
    * @throws \Exception For any other unexpected error during the request or response handling.
     */
    final protected function fetchData(string $endpoint, array $params = []): array
    {   
        $params["key"] = $this->apiKey;
        $params["limit"] = $this->limit;
        
        $url = $this->baseUrl . $endpoint;
        
        try {
            $response = Http::retry(3, 200)
                    ->timeout(10)
                    ->get($url, $params)
                    ->throw()
                    ->json();
            
            if (!array_key_exists("data", $response)) {
                throw new ApiHasChangedException("\"data\" key is missing in API response");
            }

            return $response["data"];

        } catch (RequestException $e) {
            Log::error("Error while requesting data", ["error" => $e->getMessage()]);
            throw $e;

        } catch (ApiHasChangedException $e) {
            Log::error("[\"data\"] key may be absent. Probably the response format has changed");
            throw $e;

        } catch (Exception $e) {
            Log::error("Unexpected error during requesting data", ["error"=> $e->getMessage()]);
            throw $e;
        }
    }

    final protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
