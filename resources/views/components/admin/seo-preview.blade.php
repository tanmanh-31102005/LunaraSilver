@props([
    'titleInputId' => 'seo_title',
    'fallbackTitleInputId' => 'name',
    'descInputId' => 'seo_description',
    'fallbackDescInputId' => 'description',
    'slugInputId' => 'slug',
    'defaultSlug' => '',
    'urlPrefix' => 'https://lunarasilver.infinityfreeapp.com/',
    'titleSuffix' => ' | Lunara Silver',
    'previewId' => 'serpPreviewBox',
])

<div class="admin-card border border-light-subtle rounded-3 p-3 bg-white mt-3" id="{{ $previewId }}">
    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
        <span class="small fw-bold text-uppercase tracking-wider text-muted">
            <i class="bi bi-google me-1 text-primary"></i> Xem trước kết quả Google (SERP Preview)
        </span>
        <span class="badge bg-light text-dark border small fw-normal">Xem thử</span>
    </div>

    {{-- Google Snippet Mockup --}}
    <div class="p-3 bg-light rounded-2 border border-secondary-subtle">
        <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 12px; color: #202124;">
            <span class="badge bg-dark rounded-circle text-white p-1" style="width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;">L</span>
            <div>
                <span class="fw-semibold">Lunara Silver</span>
                <span class="text-muted d-block text-truncate preview-url" style="font-size: 11px;">
                    {{ $urlPrefix }}<span class="preview-slug">...</span>
                </span>
            </div>
        </div>
        <h4 class="mb-1 fw-normal preview-title text-truncate" style="color: #1a0dab; font-size: 17px; cursor: pointer; text-decoration: underline; line-height: 1.3;">
            Tiêu đề trang...
        </h4>
        <p class="mb-0 text-muted preview-desc" style="color: #4d5156; font-size: 13px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            Mô tả trang trích đoạn...
        </p>
    </div>

    {{-- Counters & Guidance --}}
    <div class="row g-2 mt-2 pt-2 border-top small text-muted">
        <div class="col-6">
            <span>Tiêu đề: </span>
            <strong class="title-char-count">0</strong>/60 ký tự
            <span class="title-guidance badge bg-secondary-subtle text-secondary ms-1">Mặc định</span>
        </div>
        <div class="col-6 text-end">
            <span>Mô tả: </span>
            <strong class="desc-char-count">0</strong>/160 ký tự
            <span class="desc-guidance badge bg-secondary-subtle text-secondary ms-1">Mặc định</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const box = document.getElementById('{{ $previewId }}');
    if (!box) return;

    const titleInput = document.getElementById('{{ $titleInputId }}');
    const fallbackTitleInput = document.getElementById('{{ $fallbackTitleInputId }}');
    const descInput = document.getElementById('{{ $descInputId }}');
    const fallbackDescInput = document.getElementById('{{ $fallbackDescInputId }}');
    const slugInput = document.getElementById('{{ $slugInputId }}');

    const previewTitle = box.querySelector('.preview-title');
    const previewDesc = box.querySelector('.preview-desc');
    const previewSlug = box.querySelector('.preview-slug');
    const titleCount = box.querySelector('.title-char-count');
    const descCount = box.querySelector('.desc-char-count');
    const titleGuidance = box.querySelector('.title-guidance');
    const descGuidance = box.querySelector('.desc-guidance');

    function updatePreview() {
        // 1. Title
        let tVal = titleInput ? titleInput.value.trim() : '';
        const isCustomTitle = tVal.length > 0;
        if (!isCustomTitle && fallbackTitleInput) {
            tVal = fallbackTitleInput.value.trim();
            if (tVal.length > 0) tVal += '{{ $titleSuffix }}';
        }
        if (!tVal) tVal = 'Lunara Silver | Trang sức bạc tinh tế';

        previewTitle.textContent = tVal;
        const tLen = titleInput ? titleInput.value.trim().length : 0;
        titleCount.textContent = tLen;

        if (isCustomTitle) {
            if (tLen <= 60) {
                titleGuidance.className = 'badge bg-success-subtle text-success ms-1';
                titleGuidance.textContent = 'Lý tưởng';
            } else {
                titleGuidance.className = 'badge bg-warning-subtle text-warning ms-1';
                titleGuidance.textContent = 'Dài';
            }
        } else {
            titleGuidance.className = 'badge bg-secondary-subtle text-secondary ms-1';
            titleGuidance.textContent = 'Tự động';
        }

        // 2. Description
        let dVal = descInput ? descInput.value.trim() : '';
        const isCustomDesc = dVal.length > 0;
        if (!isCustomDesc && fallbackDescInput) {
            dVal = fallbackDescInput.value.trim();
        }
        if (!dVal) dVal = 'Khám phá thế giới trang sức bạc 925 cao cấp Lunara Silver. Tinh tế, thanh lịch và tỏa sáng theo cách của riêng bạn.';

        previewDesc.textContent = dVal;
        const dLen = descInput ? descInput.value.trim().length : 0;
        descCount.textContent = dLen;

        if (isCustomDesc) {
            if (dLen <= 160) {
                descGuidance.className = 'badge bg-success-subtle text-success ms-1';
                descGuidance.textContent = 'Lý tưởng';
            } else {
                descGuidance.className = 'badge bg-warning-subtle text-warning ms-1';
                descGuidance.textContent = 'Dài';
            }
        } else {
            descGuidance.className = 'badge bg-secondary-subtle text-secondary ms-1';
            descGuidance.textContent = 'Tự động';
        }

        // 3. Slug
        let sVal = slugInput ? slugInput.value.trim() : '{{ $defaultSlug }}';
        if (!sVal && fallbackTitleInput) {
            sVal = fallbackTitleInput.value.toLowerCase().trim()
                .replace(/[áàảãạăắằẳẵặâấầẩẫậ]/g, 'a')
                .replace(/[éèẻẽẹêếềểễệ]/g, 'e')
                .replace(/[íìỉĩị]/g, 'i')
                .replace(/[óòỏõọôốồổỗộơớờởỡợ]/g, 'o')
                .replace(/[úùủũụưứừửữự]/g, 'u')
                .replace(/[ýỳỷỹỵ]/g, 'y')
                .replace(/[đ]/g, 'd')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        }
        previewSlug.textContent = sVal || 'duong-dan';
    }

    [titleInput, fallbackTitleInput, descInput, fallbackDescInput, slugInput].forEach(el => {
        if (el) {
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        }
    });

    updatePreview();
});
</script>
@endpush
