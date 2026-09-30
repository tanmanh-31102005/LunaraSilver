@props([
    'status',
    'type' => null,
    'label' => null,
    'dot' => true,
    'size' => 'md',
])

@php
    $normalized = strtolower(trim((string) $status));

    // Resolve semantic color category
    $variant = match($normalized) {
        'completed', 'paid', 'active', 'published', 'resolved', 'success' => 'success',
        'confirmed', 'processing', 'in_progress', 'shipping', 'info' => 'info',
        'pending', 'unpaid', 'refund_pending', 'draft', 'new', 'warning' => 'warning',
        'cancelled', 'failed', 'refunded', 'inactive', 'closed', 'danger' => 'danger',
        default => 'neutral',
    };

    // Auto-detect icon
    $icon = match($normalized) {
        'completed', 'paid', 'resolved' => 'bi-check-circle-fill',
        'confirmed' => 'bi-check2-all',
        'processing', 'in_progress' => 'bi-arrow-repeat',
        'shipping' => 'bi-truck',
        'pending', 'unpaid' => 'bi-clock-history',
        'refund_pending' => 'bi-arrow-counterclockwise',
        'refunded' => 'bi-wallet2',
        'cancelled', 'failed' => 'bi-x-circle-fill',
        'active' => 'bi-check-circle',
        'inactive' => 'bi-pause-circle',
        'draft' => 'bi-file-earmark-text',
        'published' => 'bi-globe2',
        'new' => 'bi-stars',
        'closed' => 'bi-archive',
        default => 'bi-dot',
    };

    // Auto-detect label if none provided
    if (!$label && !trim($slot)) {
        $label = match($normalized) {
            'pending' => $type === 'payment' ? 'Chờ thanh toán' : 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => $type === 'support' ? 'Đang xử lý' : 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
            'refund_pending' => 'Chờ hoàn tiền',
            'refunded' => 'Đã hoàn tiền',
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm dừng',
            'draft' => 'Bản nháp',
            'published' => 'Đã xuất bản',
            'new' => 'Yêu cầu mới',
            'in_progress' => 'Đang xử lý',
            'resolved' => 'Đã giải quyết',
            'closed' => 'Đã đóng',
            default => ucfirst(str_replace('_', ' ', $normalized)),
        };
    }

    $sizeClass = $size === 'sm' ? 'ln-badge--sm' : ($size === 'lg' ? 'ln-badge--lg' : 'ln-badge--md');
    $badgeClasses = "ln-badge ln-badge--{$variant} {$sizeClass}";
@endphp

<span {{ $attributes->merge(['class' => $badgeClasses]) }} data-status="{{ $normalized }}">
    @if($dot)
        <span class="ln-badge__dot" aria-hidden="true"></span>
    @else
        <i class="bi {{ $icon }} ln-badge__icon" aria-hidden="true"></i>
    @endif
    <span class="ln-badge__label">{{ $label ?: $slot }}</span>
</span>
