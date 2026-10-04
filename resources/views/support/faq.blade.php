@extends('layouts.app')

@section('title', 'Trung Tâm Hỗ Trợ & Câu Hỏi Thường Gặp (FAQ) — Lunara Silver')
@section('meta_description', 'Trung tâm hỗ trợ khách hàng và giải đáp câu hỏi thường gặp về sản phẩm bạc 925, đặt hàng, thanh toán VNPay, chính sách bảo hành tại Lunara Silver.')
@section('canonical', route('support.faq'))
@section('main_class', 'support-main')

@if(filled($searchQuery) || filled($selectedCategory))
@section('robots', 'noindex,follow')
@endif

@section('content')
<div class="lunara-support-page">
    <div class="lunara-container" style="max-width: 1080px;">
        {{-- Hero Header --}}
        <div class="faq-hero">
            <span class="faq-eyebrow">✦ LUNARA HELP CENTER ✦</span>
            <h1 class="faq-title">Trung Tâm Hỗ Trợ</h1>
            <p class="faq-desc">
                Quý khách cần giải đáp thông tin về sản phẩm bạc 925, chính sách thanh toán hay chế độ bảo hành? Khám phá các câu hỏi thường gặp dưới đây hoặc kết nối trực tiếp với chuyên viên tư vấn.
            </p>

            {{-- Editorial Search Box --}}
            <form action="{{ route('support.faq') }}" method="GET" class="faq-search-box">
                @if($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <i class="bi bi-search text-muted fs-6 me-2" aria-hidden="true"></i>
                <input type="search"
                       name="q"
                       value="{{ $searchQuery }}"
                       class="faq-search-input"
                       placeholder="Tìm kiếm câu hỏi (đặt hàng, VNPay, đổi trả, kích thước...)"
                       aria-label="Tìm kiếm câu hỏi">
                <button class="faq-search-btn" type="submit">
                    <span>Tìm kiếm</span>
                </button>
            </form>
        </div>

        {{-- Category Filter Chips --}}
        <div class="faq-chip-group">
            <a href="{{ route('support.faq', $searchQuery ? ['q' => $searchQuery] : []) }}"
               class="faq-chip {{ empty($selectedCategory) ? 'is-active' : '' }}">
                Tất cả chủ đề
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('support.faq', array_filter(['category' => $cat, 'q' => $searchQuery])) }}"
                   class="faq-chip {{ $selectedCategory === $cat ? 'is-active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- FAQ Accordion List --}}
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                @if($faqs->isEmpty())
                    <div class="text-center py-5 px-4 border rounded-3 bg-white shadow-sm my-4">
                        <i class="bi bi-question-circle fs-1 text-muted d-block mb-3"></i>
                        <h2 class="h5 text-dark mb-2">Không tìm thấy câu hỏi phù hợp</h2>
                        <p class="text-muted small mb-4 mx-auto" style="max-width: 480px;">
                            Không có kết quả nào trùng khớp với từ khóa "{{ $searchQuery }}". Quý khách vui lòng thử tìm kiếm với từ khóa khác hoặc liên hệ trực tiếp với chúng tôi.
                        </p>
                        <a href="{{ route('support.faq') }}" class="lunara-button lunara-button--outline py-2 px-4">
                            Xem tất cả câu hỏi
                        </a>
                    </div>
                @else
                    @foreach($faqs as $categoryName => $categoryFaqs)
                        <div class="mb-5">
                            {{-- Category Section Header --}}
                            <div class="faq-category-header">
                                <span class="faq-category-header__tag">{{ $categoryName }}</span>
                                <span class="faq-category-header__count">{{ count($categoryFaqs) }} câu hỏi</span>
                            </div>

                            <div class="faq-accordion-list" id="faqAccordion-{{ Str::slug($categoryName) }}">
                                @foreach($categoryFaqs as $index => $faq)
                                    @php $collapseId = 'collapse-' . $faq->id; @endphp
                                    <div class="faq-card">
                                        <h3 class="m-0" id="heading-{{ $faq->id }}">
                                            <button class="faq-card__trigger collapsed"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseId }}"
                                                    aria-expanded="false"
                                                    aria-controls="{{ $collapseId }}">
                                                <span>{{ $faq->question }}</span>
                                                <span class="faq-card__chevron">
                                                    <i class="bi bi-chevron-down"></i>
                                                </span>
                                            </button>
                                        </h3>
                                        <div id="{{ $collapseId }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $faq->id }}">
                                            <div class="faq-card__body">
                                                {!! nl2br(e($faq->answer)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- Bottom Contact CTA Card --}}
                <div class="faq-cta-card">
                    <span class="faq-cta-card__eyebrow">✦ DỊCH VỤ KHÁCH HÀNG ✦</span>
                    <h2 class="faq-cta-card__title">Quý khách vẫn cần hỗ trợ thêm?</h2>
                    <p class="faq-cta-card__desc">
                        Đội ngũ chăm sóc khách hàng của Lunara Silver luôn sẵn sàng lắng nghe, tư vấn kích thước và giải đáp mọi yêu cầu của quý khách.
                    </p>
                    <div class="faq-cta-card__actions">
                        <a href="{{ route('contact') }}" class="lunara-button lunara-button--dark py-2 px-4">
                            <span>Gửi yêu cầu liên hệ</span>
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <button type="button" class="lunara-button lunara-button--outline py-2 px-4" onclick="window.LunaraChat && window.LunaraChat.open()">
                            <i class="bi bi-chat-dots me-1"></i>
                            <span>Trò chuyện trực tuyến</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
