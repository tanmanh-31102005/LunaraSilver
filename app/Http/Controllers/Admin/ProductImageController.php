<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReorderProductImagesRequest;
use App\Http\Requests\Admin\StoreProductImageRequest;
use App\Http\Requests\Admin\UpdateProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\CloudinaryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductImageController extends Controller
{
    public function __construct(
        protected CloudinaryService $cloudinary
    ) {}

    /**
     * Upload and store product images on Cloudinary.
     */
    public function store(StoreProductImageRequest $request, Product $product): JsonResponse|RedirectResponse
    {
        if (! $this->cloudinary->isConfigured()) {
            $msg = 'Dịch vụ Cloudinary chưa được cấu hình. Vui lòng cấu hình CLOUDINARY_* trong .env.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 500);
            }

            return back()->with('error', $msg);
        }

        $files = $request->file('images', []);
        $targetRole = $request->input('image_role', 'gallery');
        $altText = $request->filled('alt_text') ? trim($request->input('alt_text')) : $product->name;
        $folder = $this->cloudinary->generateFolder('products', $product->sku);

        $uploadedImages = [];
        $errors = [];
        $maxSort = (int) $product->images()->max('sort_order');

        foreach ($files as $index => $file) {
            $currentRole = ($index === 0) ? $targetRole : 'gallery';

            try {
                $uploadResult = $this->cloudinary->uploadFile($file, $folder, null, [
                    'transformation' => [
                        'quality' => 'auto',
                        'fetch_format' => 'auto',
                    ],
                ]);
            } catch (Exception $e) {
                Log::error('Cloudinary product image upload failed', [
                    'product_id' => $product->id,
                    'sku' => $product->sku,
                    'filename' => $file->getClientOriginalName(),
                    'error' => $e->getMessage(),
                ]);
                $errors[] = "Không thể tải lên {$file->getClientOriginalName()}: {$e->getMessage()}";

                continue;
            }

            $publicId = $uploadResult['public_id'];
            $secureUrl = $uploadResult['secure_url'];

            // Persist into database within transaction
            try {
                $createdImage = DB::transaction(function () use ($product, $currentRole, $publicId, $secureUrl, $altText, &$maxSort) {
                    if ($currentRole === 'primary') {
                        $product->images()->where('image_role', 'primary')->update(['image_role' => 'gallery']);
                    } elseif ($currentRole === 'hover') {
                        $product->images()->where('image_role', 'hover')->update(['image_role' => 'gallery']);
                    }

                    $maxSort++;

                    return $product->images()->create([
                        'cloudinary_public_id' => $publicId,
                        'image_url' => $secureUrl,
                        'image_role' => $currentRole,
                        'sort_order' => $maxSort,
                        'alt_text' => $altText,
                    ]);
                });

                $uploadedImages[] = $createdImage;
            } catch (Exception $e) {
                // Cleanup orphaned asset on Cloudinary if DB failed
                Log::error('Database save failed after Cloudinary upload, cleaning up asset', [
                    'product_id' => $product->id,
                    'public_id' => $publicId,
                    'error' => $e->getMessage(),
                ]);

                try {
                    $this->cloudinary->deleteFile($publicId);
                } catch (Exception $cleanupException) {
                    Log::error('Orphan asset cleanup failed', [
                        'public_id' => $publicId,
                        'error' => $cleanupException->getMessage(),
                    ]);
                }

                $errors[] = "Lỗi lưu cơ sở dữ liệu cho {$file->getClientOriginalName()}. Đã hủy ảnh trên đám mây.";
            }
        }

        if (empty($uploadedImages)) {
            $errorMessage = ! empty($errors) ? implode('; ', $errors) : 'Không có hình ảnh nào được tải lên thành công.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $errorMessage, 'errors' => $errors], 422);
            }

            return back()->with('error', $errorMessage);
        }

        $successMsg = 'Đã tải lên thành công '.count($uploadedImages).' hình ảnh.';
        if (! empty($errors)) {
            $successMsg .= ' (Lỗi: '.implode('; ', $errors).')';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'images' => $uploadedImages,
                'errors' => $errors,
            ]);
        }

        return back()->with('success', $successMsg);
    }

    /**
     * Update image role, alt text, or sort order.
     */
    public function update(UpdateProductImageRequest $request, Product $product, ProductImage $image): JsonResponse|RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            abort(404, 'Hình ảnh không thuộc sản phẩm này.');
        }

        DB::transaction(function () use ($request, $product, $image): void {
            if ($request->filled('image_role')) {
                $newRole = $request->input('image_role');

                if ($newRole === 'primary') {
                    $product->images()->where('id', '!=', $image->id)->where('image_role', 'primary')->update(['image_role' => 'gallery']);
                } elseif ($newRole === 'hover') {
                    $product->images()->where('id', '!=', $image->id)->where('image_role', 'hover')->update(['image_role' => 'gallery']);
                }

                $image->image_role = $newRole;
            }

            if ($request->has('alt_text')) {
                $image->alt_text = $request->filled('alt_text') ? trim($request->input('alt_text')) : $product->name;
            }

            if ($request->has('sort_order')) {
                $image->sort_order = (int) $request->input('sort_order');
            }

            $image->save();
        });

        $msg = 'Đã cập nhật thông tin hình ảnh thành công.';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg, 'image' => $image->fresh()]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Safely delete image: delete from Cloudinary if remote, then delete DB record.
     */
    public function destroy(Request $request, Product $product, ProductImage $image): JsonResponse|RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            abort(404, 'Hình ảnh không thuộc sản phẩm này.');
        }

        // If Cloudinary image, delete from Cloudinary first
        if ($image->isCloudinary()) {
            $deleted = $this->cloudinary->deleteFile($image->cloudinary_public_id);
            if (! $deleted) {
                Log::error('Cloudinary asset deletion failed', [
                    'product_id' => $product->id,
                    'public_id' => $image->cloudinary_public_id,
                    'image_id' => $image->id,
                ]);

                $msg = 'Không thể xóa ảnh trên Cloudinary. Thao tác đã dừng để đảm bảo tính nhất quán.';
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 500);
                }

                return back()->with('error', $msg);
            }
        }

        // Legacy local images are kept intact on filesystem, only mapping is deleted
        $image->delete();

        $msg = 'Đã xóa hình ảnh thành công.';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Reorder images for the product.
     */
    public function reorder(ReorderProductImagesRequest $request, Product $product): JsonResponse|RedirectResponse
    {
        $order = $request->input('order', []);

        DB::transaction(function () use ($product, $order): void {
            foreach ($order as $index => $imageId) {
                $product->images()
                    ->where('id', $imageId)
                    ->update(['sort_order' => $index + 1]);
            }
        });

        $msg = 'Đã cập nhật thứ tự hình ảnh thành công.';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }
}
