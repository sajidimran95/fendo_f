<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Feedback;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $page = $request->user()
            ->appNotifications()
            ->latest()
            ->paginate(20);

        return $this->success([
            'current_page' => $page->currentPage(),
            'data' => collect($page->items())->map->toApiArray(),
            'per_page' => $page->perPage(),
            'total' => $page->total(),
            'last_page' => $page->lastPage(),
        ]);
    }

    public function unreadCount(Request $request)
    {
        $count = $request->user()->appNotifications()->whereNull('read_at')->count();

        return $this->success(['unread' => $count]);
    }

    public function markRead(Request $request, AppNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 404);
        $notification->update(['read_at' => now()]);

        return $this->success($notification->fresh()->toApiArray(), 'Marked as read.');
    }

    public function markAllRead(Request $request)
    {
        $request->user()->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);

        return $this->success(null, 'All notifications marked as read.');
    }
}
