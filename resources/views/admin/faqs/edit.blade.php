@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa câu hỏi FAQ #' . $faq->id)
@section('page_title', 'Chỉnh sửa FAQ')

@section('breadcrumb')
    <li><a href="{{ route('admin.faqs.index') }}">FAQ</a></li>
    <li class="active">Chỉnh sửa #{{ $faq->id }}</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Chỉnh sửa câu hỏi trợ giúp</h2>
            <p class="text-muted small mb-0">Cập nhật nội dung câu hỏi và câu trả lời.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="admin-btn admin-btn--secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="p-4">
                    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="faqCategory" class="form-label small fw-medium text-dark">Danh mục câu hỏi <span class="text-danger">*</span></label>
                            <select name="category" id="faqCategory" class="form-select @error('category') is-invalid @enderror" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $faq->category) === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="faqQuestion" class="form-label small fw-medium text-dark">Câu hỏi <span class="text-danger">*</span></label>
                            <input type="text" name="question" id="faqQuestion" class="form-control @error('question') is-invalid @enderror" value="{{ old('question', $faq->question) }}" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="faqAnswer" class="form-label small fw-medium text-dark">Câu trả lời chi tiết <span class="text-danger">*</span></label>
                            <textarea name="answer" id="faqAnswer" class="form-control @error('answer') is-invalid @enderror" rows="6" required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="faqSortOrder" class="form-label small fw-medium text-dark">Thứ tự hiển thị</label>
                                <input type="number" name="sort_order" id="faqSortOrder" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $faq->sort_order) }}" min="0" required>
                                <small class="text-muted">Số nhỏ hơn sẽ hiển thị lên trước.</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="faqIsActive" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="faqIsActive">
                                        Hiển thị trên Storefront
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.faqs.index') }}" class="admin-btn admin-btn--secondary">Hủy bỏ</a>
                            <button type="submit" class="admin-btn admin-btn--primary">Cập nhật FAQ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
