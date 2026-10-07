@forelse ($reviews as $rev)
    <div class="p-3 border rounded-2 mb-3 bg-light">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-semibold text-dark">{{ $rev->product ? $rev->product->name : 'Sản phẩm' }}</span>
                <div class="text-warning small">
                    @for ($s = 1; $s <= 5; $s++)
                        <i class="bi {{ $s <= $rev->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                </div>
            </div>
            <span class="badge {{ $rev->status === 'approved' ? 'bg-success' : ($rev->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                {{ ucfirst($rev->status) }}
            </span>
        </div>
        <p class="mb-1 small text-dark">{{ $rev->comment ?: $rev->content }}</p>
        <div class="text-muted small" style="font-size: 0.72rem;">{{ $rev->created_at ? $rev->created_at->format('d/m/Y H:i') : '' }}</div>
    </div>
@empty
    <div class="text-center py-4 text-muted small">Khách hàng chưa gửi đánh giá nào.</div>
@endforelse

@if ($reviews instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $reviews->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $reviews->links() }}
    </div>
@endif
