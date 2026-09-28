{{-- Lunara Silver Concierge / Live Support Widget --}}
<div id="lunaraSupportWidget" class="lunara-support-widget" style="position: fixed; bottom: 24px; right: 24px; z-index: 1050; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    {{-- Launcher Button --}}
    <button id="lunaraChatLauncher"
            class="btn btn-dark rounded-pill shadow-lg d-flex align-items-center gap-2 px-4 py-2 border-0"
            style="letter-spacing: 0.05em; font-size: 0.875rem; background-color: #1a1a1a; transition: all 0.2s ease;"
            type="button"
            aria-label="Mở cửa sổ hỗ trợ trực tuyến">
        <i class="bi bi-chat-dots-fill fs-6 text-white"></i>
        <span class="fw-medium text-white">Cần hỗ trợ?</span>
        <span id="lunaraUnreadBadge" class="badge rounded-pill bg-danger d-none" style="font-size: 0.65rem;">1</span>
    </button>

    {{-- Chat Box Window --}}
    <div id="lunaraChatWindow"
         class="card border rounded-3 shadow-lg overflow-hidden d-none"
         style="width: 360px; max-width: calc(100vw - 32px); height: 500px; max-height: calc(100vh - 120px); position: absolute; bottom: 60px; right: 0; border-color: #e5e0d8 !important; background-color: #ffffff;">
        {{-- Header --}}
        <div class="card-header bg-dark text-white p-3 d-flex align-items-center justify-content-between border-0">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-headset text-white" style="font-size: 0.875rem;"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-medium font-serif" style="letter-spacing: 0.05em; font-size: 0.95rem;">LUNARA CONCIERGE</h6>
                    <small class="text-white-50" style="font-size: 0.725rem;">Hỗ trợ khách hàng trực tuyến</small>
                </div>
            </div>
            <button id="lunaraChatCloseBtn" type="button" class="btn btn-sm btn-link text-white text-decoration-none p-0" aria-label="Đóng cửa sổ chat">
                <i class="bi bi-x-lg fs-6"></i>
            </button>
        </div>

        {{-- Conversation Reference Banner --}}
        <div id="lunaraChatMetaBanner" class="px-3 py-1 bg-light border-bottom text-muted small d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
            <span>Mã phiên: <strong id="lunaraChatRef" class="text-dark">Đang kết nối...</strong></span>
            <span id="lunaraChatStatus" class="badge bg-secondary-subtle text-secondary rounded-pill">Chờ</span>
        </div>

        {{-- Messages Container --}}
        <div id="lunaraChatMessages" class="card-body p-3 overflow-y-auto d-flex flex-column gap-3" style="background-color: #faf9f6; flex-grow: 1;">
            {{-- Welcome message from Lunara --}}
            <div class="d-flex gap-2">
                <div class="p-3 rounded-2 text-dark border" style="max-width: 85%; font-size: 0.85rem; line-height: 1.5; background-color: #ffffff; border-color: #ebe7e0 !important;">
                    <div class="fw-medium small text-muted mb-1">Lunara Concierge</div>
                    Xin chào quý khách. Lunara Silver có thể hỗ trợ quý khách về kích thước trang sức, đơn hàng hoặc chế độ bảo hành?
                </div>
            </div>
        </div>

        {{-- Footer Input Form --}}
        <div class="card-footer bg-white p-2 border-top">
            <form id="lunaraChatForm" class="d-flex align-items-center gap-2">
                <input id="lunaraChatMessageInput"
                       type="text"
                       class="form-control form-control-sm rounded-pill border px-3"
                       placeholder="Nhập tin nhắn..."
                       maxlength="1000"
                       required
                       autocomplete="off"
                       style="font-size: 0.875rem;">
                <button type="submit" class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 34px; height: 34px; flex-shrink: 0;" aria-label="Gửi tin nhắn">
                    <i class="bi bi-arrow-up-short fs-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const launcher = document.getElementById('lunaraChatLauncher');
    const windowEl = document.getElementById('lunaraChatWindow');
    const closeBtn = document.getElementById('lunaraChatCloseBtn');
    const messagesEl = document.getElementById('lunaraChatMessages');
    const formEl = document.getElementById('lunaraChatForm');
    const inputEl = document.getElementById('lunaraChatMessageInput');
    const refEl = document.getElementById('lunaraChatRef');
    const statusEl = document.getElementById('lunaraChatStatus');
    const csrfToken = '{{ csrf_token() }}';

    let isOpen = false;
    let currentRef = null;
    let pollInterval = null;
    let renderedMsgIds = new Set();

    function scrollToBottom() {
        if (messagesEl) {
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }
    }

    function appendMessage(msg) {
        if (renderedMsgIds.has(msg.id)) return;
        renderedMsgIds.add(msg.id);

        const isCustomer = msg.sender_type === 'customer';
        const wrapper = document.createElement('div');
        wrapper.className = isCustomer ? 'd-flex justify-content-end' : 'd-flex gap-2';

        const bubble = document.createElement('div');
        bubble.className = isCustomer
            ? 'p-2 px-3 rounded-2 text-white shadow-sm'
            : 'p-2 px-3 rounded-2 text-dark border shadow-sm';

        bubble.style.maxWidth = '85%';
        bubble.style.fontSize = '0.85rem';
        bubble.style.lineHeight = '1.45';

        if (isCustomer) {
            bubble.style.backgroundColor = '#1a1a1a';
        } else {
            bubble.style.backgroundColor = '#ffffff';
            bubble.style.borderColor = '#ebe7e0';
        }

        const senderLabel = isCustomer ? '' : `<div class="fw-medium small text-muted mb-1">${escapeHtml(msg.sender_name || 'Chuyên viên')}</div>`;
        const timeHtml = msg.time ? `<div class="text-end small ${isCustomer ? 'text-white-50' : 'text-muted'}" style="font-size: 0.68rem; margin-top: 3px;">${escapeHtml(msg.time)}</div>` : '';

        bubble.innerHTML = `${senderLabel}<div>${escapeHtml(msg.message)}</div>${timeHtml}`;
        wrapper.appendChild(bubble);
        messagesEl.appendChild(wrapper);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function openChat() {
        isOpen = true;
        windowEl.classList.remove('d-none');
        launcher.classList.add('d-none');
        if (!currentRef) {
            initSession();
        } else {
            pollMessages();
            startPolling();
        }
        setTimeout(() => {
            scrollToBottom();
            inputEl.focus();
        }, 150);
    }

    function closeChat() {
        isOpen = false;
        windowEl.classList.add('d-none');
        launcher.classList.remove('d-none');
        stopPolling();
    }

    function startPolling() {
        stopPolling();
        if (isOpen && currentRef) {
            // Poll interval 8 seconds
            pollInterval = setInterval(pollMessages, 8000);
        }
    }

    function stopPolling() {
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
    }

    function initSession() {
        fetch('{{ route("support.chat.init") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.conversation) {
                currentRef = data.conversation.reference;
                refEl.textContent = currentRef;
                statusEl.textContent = data.conversation.status_label || data.conversation.status;

                if (Array.isArray(data.messages)) {
                    data.messages.forEach(appendMessage);
                    scrollToBottom();
                }
                startPolling();
            }
        })
        .catch(err => console.error('Chat init error:', err));
    }

    function pollMessages() {
        if (!currentRef || !isOpen) return;

        fetch(`/support/chat/${currentRef}/messages`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.messages)) {
                let hasNew = false;
                data.messages.forEach(msg => {
                    if (!renderedMsgIds.has(msg.id)) {
                        appendMessage(msg);
                        hasNew = true;
                    }
                });
                if (hasNew) {
                    scrollToBottom();
                }
            }
        })
        .catch(err => console.error('Chat polling error:', err));
    }

    launcher.addEventListener('click', openChat);
    closeBtn.addEventListener('click', closeChat);

    formEl.addEventListener('submit', function (e) {
        e.preventDefault();
        const text = inputEl.value.trim();
        if (!text || !currentRef) return;

        inputEl.value = '';

        fetch(`/support/chat/${currentRef}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: text })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.message) {
                appendMessage(data.message);
                scrollToBottom();
            }
        })
        .catch(err => console.error('Send error:', err));
    });

    window.LunaraChat = {
        open: openChat,
        close: closeChat
    };
});
</script>
