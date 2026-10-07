<h6 class="fw-bold text-dark small text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">Ticket liên hệ / Hỗ trợ</h6>
<div class="table-responsive mb-4">
    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
        <thead class="table-light">
            <tr><th>Mã yêu cầu</th><th>Tiêu đề</th><th>Trạng thái</th><th>Ngày tạo</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
            @forelse ($contact_messages as $cm)
                <tr>
                    <td><span class="fw-bold">#{{ $cm->reference }}</span></td>
                    <td>{{ $cm->subject }}</td>
                    <td>
                        <span class="badge {{ match($cm->status) { 'new' => 'bg-danger', 'in_progress' => 'bg-warning text-dark', 'resolved' => 'bg-success', default => 'bg-secondary' } }}">
                            {{ \App\Models\ContactMessage::STATUS_LABELS[$cm->status] ?? $cm->status }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $cm->created_at ? $cm->created_at->format('d/m/Y') : '' }}</td>
                    <td><a href="{{ route('admin.support.show', $cm->id) }}" class="btn btn-sm btn-light border py-0 px-2 small">Xem ticket</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Không có ticket hỗ trợ nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<h6 class="fw-bold text-dark small text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">Phiên Live Chat</h6>
<div class="table-responsive">
    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
        <thead class="table-light">
            <tr><th>Mã phiên</th><th>Trạng thái</th><th>Tin nhắn cuối</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
            @forelse ($chat_conversations as $conv)
                <tr>
                    <td><span class="fw-bold">#{{ $conv->reference }}</span></td>
                    <td>
                        <span class="badge {{ match($conv->status) { 'open' => 'bg-warning text-dark', 'assigned' => 'bg-primary', 'resolved' => 'bg-success', default => 'bg-secondary' } }}">
                            {{ \App\Models\SupportConversation::STATUS_LABELS[$conv->status] ?? $conv->status }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $conv->last_message_at ? $conv->last_message_at->format('d/m/Y H:i') : '' }}</td>
                    <td><a href="{{ route('admin.support.chat.show', $conv->id) }}" class="btn btn-sm btn-light border py-0 px-2 small">Mở chat</a></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-3">Chưa có phiên live chat nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
