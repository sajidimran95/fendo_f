<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $contacts = $request->user()->contacts()->get();

        $iOwe = $contacts->filter(fn ($c) => (float) $c->balance < 0);
        $oweMe = $contacts->filter(fn ($c) => (float) $c->balance > 0);

        return $this->success([
            'i_owe_total' => round($iOwe->sum(fn ($c) => abs((float) $c->balance)), 2),
            'people_owe_me_total' => round($oweMe->sum(fn ($c) => (float) $c->balance), 2),
            'i_owe' => $iOwe->values()->map->toApiArray(),
            'people_owe_me' => $oweMe->values()->map->toApiArray(),
        ]);
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $contacts = $request->user()
            ->contacts()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('name', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->limit(50)
            ->get()
            ->map->toApiArray();

        return $this->success($contacts);
    }
}
