@extends('layouts.app')

@section('title', 'Trung Tâm Hỗ Trợ & Câu Hỏi Thường Gặp (FAQ) — Lunara Silver')

@section('content')
<div class="lunara-support-page py-5">
    <div class="lunara-container">
        {{-- Hero Header --}}
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-uppercase tracking-widest small text-muted d-block mb-2">Lunara Customer Care</span>
            <h1 class="display-6 font-serif fw-normal mb-3">Trung Tâm Hỗ Trợ</h1>
            <p class="text-muted leading-relaxed">
                Quý khách cần giải đáp thông tin về sản phẩm, chính sách thanh toán hay chế độ bảo hành? Khám phá các câu hỏi thường gặp dưới đây hoặc kết nối trực tiếp với chuyên viên tư vấn.
            </p>

            {{-- Search Box --}}
            <form action="{{ route('support.faq') }}" method="GET" class="mt-4 mx-auto" style="max-width: 540px;">
                @if($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <div class="input-group input-group-lg shadow-none border border-dark-subtle rounded-0 overflow-hidden bg-white">
                    <input type="search" name="q" value="{{ $searchQuery }}" class="form-control border-0 rounded-0 ps-4 fs-6" placeholder="Tìm kiếm câu hỏi (đặt hàng, VNPay, đổi trả...)" aria-label="Tìm kiếm câu hỏi">
                    <button class="btn btn-dark rounded-0 px-4 text-uppercase tracking-wider fs-7" type="submit">
                        <i class="bi bi-search me-1"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        {{-- Category Pills --}}
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <a href="{{ route('support.faq', $searchQuery ? ['q' => $searchQuery] : []) }}"
               class="btn btn-sm rounded-pill px-3 py-2 {{ empty($selectedCategory) ? 'btn-dark' : 'btn-outline-secondary' }}">
                Tất cả chủ đề
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('support.faq', array_filter(['category' => $cat, 'q' => $searchQuery])) }}"
                   class="btn btn-sm rounded-pill px-3 py-2 {{ $selectedCategory === $cat ? 'btn-dark' : 'btn-outline-secondary' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- FAQ Accordion List --}}
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                @if($faqs->isEmpty())
                    <div class="text-center py-5 border border-dashed rounded-2 bg-light-subtle">
                        <i class="bi bi-question-circle fs-1 text-muted d-block mb-3"></i>
                        <h2 class="h5 text-dark mb-2">Không tìm thấy câu hỏi phù hợp</h2>
                        <p class="text-muted small mb-4">Không có kết quả nào trùng khớp với từ khóa "{{ $searchQuery }}". Quý khách vui lòng thử tìm kiếm với từ khóa khác hoặc liên hệ trực tiếp với chúng tôi.</p>
                        <a href="{{ route('support.faq') }}" class="btn btn-sm btn-outline-dark">Xem tất cả câu hỏi</a>
                    </div>
                @else
                    @foreach($faqs as $categoryName => $categoryFaqs)
                        <div class="mb-5">
                            <h2 class="h6 text-uppercase tracking-widest text-muted border-bottom pb-2 mb-3">
                                {{ $categoryName }}
                            </h2>

                            <div class="accordion accordion-flush" id="faqAccordion-{{ Str::slug($categoryName) }}">
                                @foreach($categoryFaqs as $index => $faq)
                                    @php $collapseId = 'collapse-' . $faq->id; @endphp
                                    <div class="accordion-item border-bottom mb-2 bg-transparent">
                                        <h3 class="accordion-header" id="heading-{{ $faq->id }}">
                                            <button class="accordion-button collapsed px-3 py-3 fw-medium text-dark bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}" style="font-size: 0.98rem;">
                                                <span class="me-2 text-muted">&bull;</span> {{ $faq->question }}
                                            </button>
                                        </h3>
                                        <div id="{{ $collapseId }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $faq->id }}">
                                            <div class="accordion-body px-4 pb-4 pt-1 text-secondary" style="font-size: 0.925rem; line-height: 1.7;">
                                                {!! nl2br(e($faq->answer)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- Contact CTA Card --}}
                <div class="mt-5 p-4 p-md-5 border border-light-subtle text-center" style="background-color: #fbfaf8;">
                    <h3 class="font-serif fs-4 mb-2">Quý khách cần hỗ trợ thêm?</h3>
                    <p class="text-muted small mb-4 mx-auto" style="max-width: 500px;">
                        Đội ngũ chăm sóc khách hàng của Lunara Silver luôn sẵn sàng lắng nghe và giải đáp mọi yêu cầu của quý khách.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-dark rounded-0 px-4 py-2 text-uppercase tracking-wider fs-7">
                            Gửi yêu cầu liên hệ
                        </a>
                        <button type="button" class="btn btn-outline-dark rounded-0 px-4 py-2 text-uppercase tracking-wider fs-7" onclick="window.LunaraChat && window.LunaraChat.open()">
                            <i class="bi bi-chat-dots me-1"></i> Trò chuyện trực tuyến
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
