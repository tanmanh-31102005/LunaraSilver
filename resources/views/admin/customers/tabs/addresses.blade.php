<div class="row g-3">
    @forelse ($addresses as $addr)
        <div class="col-md-6">
            <div class="p-3 border rounded-2 h-100 bg-light position-relative">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-dark">{{ $addr->recipient_name }}</span>
                    @if ($addr->is_default)
                        <span class="badge bg-dark text-white rounded-pill px-2 py-1" style="font-size: 0.68rem;">Mặc định</span>
                    @endif
                </div>
                <div class="small text-muted mb-1"><i class="bi bi-telephone me-1"></i>{{ $addr->phone }}</div>
                <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $addr->address_line }}, {{ $addr->ward }}, {{ $addr->district }}, {{ $addr->city }}</div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-4 text-muted small">Khách hàng chưa lưu địa chỉ nào trong sổ địa chỉ.</div>
    @endforelse
</div>
