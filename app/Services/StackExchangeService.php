<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * StackExchangeService class responsible for interacting with the Stack Exchange API.
 */
class StackExchangeService
{
    /**
     * Holds the single instance of this class.
     *
     * @var StackExchangeService|null
     */
    private static $instance = null;

    /**
     * Guzzle client for HTTP requests.
     *
     * @var Client
     */
    private $client;

    /**
     * Private constructor to prevent instantiating this class.
     * Initializes the Guzzle client with the Stack Exchange base URI.
     */
    private function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('STACK_EXCHANGE_HOST')
        ]);
    }

    /**
     * Provides a single instance of this class.
     * 
     * @return StackExchangeService The single instance of this class.
     */
    public static function getInstance(): StackExchangeService
    {
        if (self::$instance == null) {
            self::$instance = new StackExchangeService();
        }

        return self::$instance;
    }

    /**
     * Search the Stack Exchange API based on the given parameters.
     *
     * @param string $query The search query string.
     * @param int|null $page The page number.
     * @param int|null $pagesize Number of items per page.
     * @param string $site The site for the search, defaulting to 'stackoverflow'.
     * 
     * @return array The formatted search results.
     */
    public function search(string $query, int $page = null, int $pagesize = null, string $site = 'stackoverflow'): array
    {
        // Unique cache key based on the function parameters
        $cacheKey = "search_{$query}_{$page}_{$pagesize}_{$site}";

        // Attempt to retrieve results from the cache first
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($query, $page, $pagesize, $site) {
            try {
                $response = $this->client->get('search', [
                    'query' => [
                        'page' => $page,
                        'pagesize' => $pagesize,
                        'intitle' => $query,
                        'site' => $site
                    ],
                    'timeout' => 5.0,
                ]);

                if ($response->getStatusCode() != Response::HTTP_OK) {
                    Log::error('StackExchange API returned non-200 response.', [
                        'status' => $response->getStatusCode(),
                        'body' => $response->getBody()->getContents()
                    ]);
                    return ['code' => $response->getStatusCode(), 'message' => 'StackExchange API returned non-200 response.'];
                }

                $data = json_decode($response->getBody(), true);

                if (!isset($data['items']) || !is_array($data['items'])) {
                    Log::error('Unexpected response format from StackExchange API.', ['response' => $data]);
                    return ['code' => Response::HTTP_BAD_REQUEST, 'message' => 'Unexpected response format from StackExchange API.'];
                }

                $result = [];
                foreach ($data['items'] as $item) {
                    $result[] = [
                        'title' => array_key_exists('title',$item) ? $item['title'] : null,
                        'answer_count' => array_key_exists('answer_count',$item) ? $item['answer_count'] : null,
                        'username' => array_key_exists('owner',$item) ? $item['owner']['display_name'] : null,
                        'profile_picture' => array_key_exists('owner',$item) ? $item['owner']['profile_image'] : null,
                        'score' => array_key_exists('score',$item) ? $item['score'] : null,
                    ];
                }

                return ['code' => Response::HTTP_OK, 'data' => $result];
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
                Log::error('Error connecting to StackExchange API.', ['error' => $e->getMessage()]);
                return ['code' => Response::HTTP_BAD_GATEWAY, 'message' => 'Error connecting to StackExchange API.'];
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                Log::error('Error received from StackExchange API.', ['error' => $e->getMessage()]);
                return ['code' => Response::HTTP_BAD_GATEWAY, 'message' => 'Error received from StackExchange API.'];
            } catch (\Exception $e) {
                Log::error('Unexpected error occurred.', ['error' => $e->getMessage()]);
                return ['code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Unexpected error occurred'];
            }
        });
    }
}
