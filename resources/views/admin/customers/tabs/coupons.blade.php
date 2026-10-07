<div class="table-responsive">
    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
        <thead class="table-light">
            <tr><th>Mã Coupon</th><th>Đơn áp dụng</th><th>Thời gian</th><th>Trạng thái</th></tr>
        </thead>
        <tbody>
            @forelse ($coupon_usages as $cu)
                <tr>
                    <td><span class="badge bg-light text-dark border fw-bold">{{ $cu->coupon ? $cu->coupon->code : '—' }}</span></td>
                    <td>
                        @if ($cu->order)
                            <a href="{{ route('admin.orders.show', $cu->order->order_code) }}" class="text-primary text-decoration-none">#{{ $cu->order->order_code }}</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $cu->used_at ? $cu->used_at->format('d/m/Y H:i') : '' }}</td>
                    <td>
                        <span class="badge {{ $cu->status === 'applied' ? 'bg-success' : 'bg-secondary' }}">
                            {{ \App\Models\CouponUsage::STATUS_LABELS[$cu->status] ?? $cu->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Khách hàng chưa sử dụng mã giảm giá nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($coupon_usages instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $coupon_usages->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $coupon_usages->links() }}
    </div>
@endif
