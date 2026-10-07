<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
        <thead class="table-light">
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th class="text-end">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $ord)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $ord->order_code) }}" class="fw-bold text-primary text-decoration-none">
                            #{{ $ord->order_code }}
                        </a>
                    </td>
                    <td class="text-muted small">{{ $ord->created_at ? $ord->created_at->format('d/m/Y H:i') : '' }}</td>
                    <td>
                        <div class="small text-truncate" style="max-width: 240px;">
                            {{ $ord->items->pluck('product_name')->join(', ') }}
                        </div>
                        <span class="text-muted" style="font-size: 0.72rem;">{{ $ord->items_count }} món</span>
                    </td>
                    <td class="fw-bold text-dark">{{ number_format((float) $ord->grand_total, 0, ',', '.') }}₫</td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ strtoupper($ord->payment_method) }}</span>
                        <span class="badge {{ $ord->payment_status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-dark' }} border" style="font-size: 0.7rem;">
                            {{ \App\Models\Order::PAYMENT_STATUS_LABELS[$ord->payment_status] ?? $ord->payment_status }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ match($ord->order_status) { 'completed' => 'bg-success', 'pending' => 'bg-warning text-dark', 'cancelled' => 'bg-danger', default => 'bg-secondary' } }} rounded-pill px-2 py-1" style="font-size: 0.72rem;">
                            {{ \App\Models\Order::STATUS_LABELS[$ord->order_status] ?? $ord->order_status }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $ord->order_code) }}" class="btn btn-sm btn-light border py-1 px-2" title="Mở chi tiết đơn hàng">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Khách hàng chưa phát sinh đơn hàng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if ($orders instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $orders->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
@endif
