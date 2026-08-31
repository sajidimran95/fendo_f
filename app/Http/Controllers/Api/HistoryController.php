<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = $request->user()
            ->transactions()
            ->with('contact')
            ->latest();

        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        if ($contactId = $request->query('contact_id')) {
            $query->where('contact_id', $contactId);
        }

        $page = $query->paginate(20);

        return $this->success([
            'current_page' => $page->currentPage(),
            'data' => collect($page->items())->map->toApiArray(),
            'per_page' => $page->perPage(),
            'total' => $page->total(),
            'last_page' => $page->lastPage(),
            'next_page_url' => $page->nextPageUrl(),
            'prev_page_url' => $page->previousPageUrl(),
        ]);
    }
}
