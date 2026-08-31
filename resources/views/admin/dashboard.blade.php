@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Loan tracker overview — '.now()->format('d M Y, H:i'))

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $cards = [
        ['label'=>'App Users', 'value'=>number_format($stats['total_users']), 'sub'=>$stats['new_users_today'].' new today', 'color'=>'indigo'],
        ['label'=>'Loans Logged', 'value'=>number_format($stats['total_loans']), 'sub'=>'$'.number_format($stats['loan_volume'], 2).' volume', 'color'=>'emerald'],
        ['label'=>'Open Balances', 'value'=>'$'.number_format($stats['open_balance'], 2), 'sub'=>'still outstanding', 'color'=>'amber'],
        ['label'=>'Feedback', 'value'=>number_format($stats['feedback']), 'sub'=>$stats['suspended_users'].' suspended users', 'color'=>'purple'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="bg-gray-900 border border-white/5 rounded-2xl p-4">
        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-3">{{ $card['label'] }}</p>
        <p class="text-2xl font-extrabold text-white">{{ $card['value'] }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ $card['sub'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-5 mb-5">
    <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-white mb-4">New Users — Last 30 Days</h3>
        <canvas id="growthChart" height="140"></canvas>
    </div>
    <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-white mb-4">Loan Activity — Last 14 Days</h3>
        <canvas id="loanChart" height="140"></canvas>
    </div>
</div>

<div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-white">Recent Loans</h3>
        <a href="{{ route('admin.transactions') }}" class="text-xs text-indigo-400 hover:underline">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="pb-3">User</th>
                    <th class="pb-3">Contact</th>
                    <th class="pb-3">Type</th>
                    <th class="pb-3">Amount</th>
                    <th class="pb-3">When</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($recentLoans as $tx)
                <tr>
                    <td class="py-3 text-white">{{ $tx->user?->displayName() ?? '—' }}</td>
                    <td class="py-3 text-gray-300">{{ $tx->contact?->name ?? '—' }}</td>
                    <td class="py-3"><span class="text-xs px-2 py-1 rounded-lg bg-white/5 text-indigo-300">{{ str_replace('_', ' ', $tx->type) }}</span></td>
                    <td class="py-3 text-white font-medium">${{ number_format($tx->amount, 2) }}</td>
                    <td class="py-3 text-gray-500">{{ $tx->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-6 text-gray-500">No loans yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
const gridColor = 'rgba(255,255,255,0.05)';
const textColor = '#6b7280';
new Chart(document.getElementById('growthChart'), {
    type: 'bar',
    data: { labels: {!! $growthChart->pluck('date')->toJson() !!}, datasets: [{ data: {!! $growthChart->pluck('count')->toJson() !!}, backgroundColor: 'rgba(99,102,241,0.6)', borderRadius: 4 }] },
    options: { plugins: { legend: { display: false } }, scales: { x: { grid: { color: gridColor }, ticks: { color: textColor, maxTicksLimit: 8 } }, y: { grid: { color: gridColor }, ticks: { color: textColor, precision: 0 }, beginAtZero: true } } }
});
new Chart(document.getElementById('loanChart'), {
    type: 'line',
    data: { labels: {!! $loanChart->pluck('date')->toJson() !!}, datasets: [
        { label: 'Count', data: {!! $loanChart->pluck('count')->toJson() !!}, borderColor: '#6366f1', tension: 0.3 },
        { label: 'Volume', data: {!! $loanChart->pluck('volume')->toJson() !!}, borderColor: '#10b981', tension: 0.3, yAxisID: 'y2' }
    ]},
    options: { plugins: { legend: { labels: { color: textColor } } }, scales: { x: { ticks: { color: textColor }, grid: { color: gridColor } }, y: { ticks: { color: textColor, precision: 0 }, grid: { color: gridColor }, beginAtZero: true }, y2: { position: 'right', grid: { display: false }, ticks: { color: '#10b981' }, beginAtZero: true } } }
});
</script>
@endpush
