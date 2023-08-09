<?php

namespace App\Http\Repositories;

use App\Models\Stat;

class StatRepository
{
    /**
     * Retrieves all stats with optional filters.
     * 
     * @param int|null    $pagesize    Number of results per page.
     * @param string|null $startDate   Filters the stats starting from this date.
     * @param string|null $endDate     Filters the stats up to this date.
     * @param string|null $querySearch Search term to filter by.
     * 
     * @return mixed Result set paginated.
     */
    public function getAll(?int $pagesize = null, ?string $startDate = null, ?string $endDate = null, ?string $querySearch = null): mixed
    {
        $query = Stat::query();

        $query->when($startDate, function ($query, $startDate) {
            return $query->whereDate('created_at', '>=', $startDate);
        });

        $query->when($endDate, function ($query, $endDate) {
            return $query->whereDate('created_at', '<=', $endDate);
        });

        $query->when($querySearch, function ($query, $searchTerm) {
            return $query->where('query', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate($pagesize ?? 10);
    }

    /**
     * Retrieves all stats with optional filters.
     * 
     * @param int|null    $pagesize    Number of results per page.
     * @param string|null $startDate   Filters the stats starting from this date.
     * @param string|null $endDate     Filters the stats up to this date.
     * @param string|null $querySearch Search term to filter by.
     * 
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Result set paginated.
     */
    public function store(string $query, int $page = null, int $pagesize = null, string $site = 'stackoverflow')
    {
        return Stat::create([
            'query' => $query,
            'page' => $page,
            'pagesize' => $pagesize,
            'site' => $site
        ]);
    }
}
