<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Post Categories
        $categories = [
            [
                'name' => 'Bảo quản bạc 925',
                'slug' => 'bao-quan-bac-925',
                'description' => 'Mẹo vệ sinh, chăm sóc và giữ trang sức bạc 925 luôn sáng bóng tinh khiết như mới.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Bộ sưu tập & Phong cách',
                'slug' => 'bo-suu-tap-phong-cach',
                'description' => 'Khám phá cảm hứng sáng tạo, xu hướng trang sức Quiet Luxury và bí quyết phối đồ sang trọng.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Cẩm nang trang sức',
                'slug' => 'cam-nang-trang-suc',
                'description' => 'Kiến thức chọn size nhẫn, ý nghĩa biểu tượng mặt trăng tinh tú và câu chuyện kim hoàn.',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = PostCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        // Author
        $author = User::where('role', User::ROLE_ADMIN)->first() ?? User::first();

        // 2. Sample Editorial Articles
        $posts = [
            [
                'title' => 'Bí Quyết Bảo Quản Trang Sức Bạc 925 Sáng Bóng Tại Nhà',
                'slug' => 'bi-quyet-bao-quan-trang-suc-bac-925-sang-bong-tai-nha',
                'post_category_id' => $categoryModels['bao-quan-bac-925']->id,
                'author_id' => $author?->id,
                'excerpt' => 'Trang sức bạc 925 bị xỉn màu là hiện tượng hóa học tự nhiên. Khám phá 5 cách làm sáng bạc đơn giản, hiệu quả ngay tại nhà mà không làm trầy xước bề mặt.',
                'content' => '<h2>Vì sao trang sức bạc 925 bị xuống màu?</h2>
<p>Nhiều người lầm tưởng rằng bạc bị đen hay xỉn màu là do bạc kém chất lượng. Tuy nhiên trên thực tế, <strong>bạc nguyên chất hoặc bạc 925 chuẩn quốc tế</strong> phản ứng tự nhiên với lưu huỳnh (lưu huỳnh có trong không khí, mồ hui và các loại hóa mỹ phẩm) tạo thành kết tủa bạc sunfua màu đen bám trên bề mặt.</p>
<blockquote>Chỉ cần biết cách chăm sóc đúng điệu, món trang sức bạc của bạn sẽ luôn giữ được vẹn nguyên ánh sáng thuần khiết như thuở ban đầu.</blockquote>
<h2>5 Cách làm sáng bạc 925 tại nhà đơn giản và hiệu quả</h2>
<h3>1. Dùng khăn lau bạc chuyên dụng Lunara</h3>
<p>Mỗi đơn hàng tại Lunara Silver đều được gửi kèm khăn lau bạc chuyên dụng chứa hoạt chất làm sạch và bảo vệ bề mặt. Bạn chỉ cần lau nhẹ nhàng trực tiếp lên bề mặt trang sức, vết xỉn màu sẽ nhanh chóng biến mất mà không gây trầy xước.</p>
<h3>2. Sử dụng dung dịch baking soda và muối ấm</h3>
<ul>
<li>Chuẩn bị một bát nước ấm có lót một lớp giấy bạc (aluminum foil).</li>
<li>Cho vào 1 thìa baking soda và 1 thìa muối tinh.</li>
<li>Ngâm trang sức bạc trong khoảng 5-10 phút để phản ứng điện hóa loại bỏ lớp sunfua đen.</li>
<li>Rửa lại bằng nước sạch và lau khô bằng khăn mềm.</li>
</ul>
<h3>3. Bảo quản trong hộp kín hoặc túi zip</h3>
<p>Khi không sử dụng, hãy cất giữ trang sức trong hộp đựng Lunara có lót nhung êm ái hoặc túi zip kín gió. Tránh để trang sức tiếp xúc trực tiếp với không khí ẩm ướt hoặc ánh nắng mặt trời gắt gao.</p>',
                'cover_image_url' => 'media/banner.jpg',
                'image_url' => 'media/banner.jpg',
                'status' => Post::STATUS_PUBLISHED,
                'is_published' => true,
                'is_featured' => true,
                'reading_time_minutes' => 4,
                'seo_title' => 'Bí Quyết Bảo Quản Trang Sức Bạc 925 Sáng Bóng Tại Nhà | Lunara',
                'seo_description' => 'Mẹo làm sáng trang sức bạc 925 tại nhà đơn giản, hiệu quả với baking soda và khăn lau bạc chuyên dụng. Giữ trang sức Lunara luôn rực rỡ.',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Nghệ Thuật Phối Lớp (Layering) Dây Chuyền Bạc Chuẩn Quiet Luxury',
                'slug' => 'nghe-thuat-phoi-lop-layering-day-chuyen-bac-chuan-quiet-luxury',
                'post_category_id' => $categoryModels['bo-suu-tap-phong-cach']->id,
                'author_id' => $author?->id,
                'excerpt' => 'Cách xếp lớp nhiều sợi dây chuyền bạc thanh mảnh tạo điểm nhấn sang trọng cho phần xương quai xanh mà không hề rối mắt hay nặng nề.',
                'content' => '<h2>Quy tắc độ dài so le (Graduated Lengths)</h2>
<p>Nguyên tắc vàng đầu tiên khi phối nhiều sợi dây chuyền là lựa chọn các độ dài khác nhau. Một combo phối lớp hoàn hảo thường bao gồm 2 đến 3 sợi:</p>
<ul>
<li><strong>Sợi ngắn nhất (38 - 40cm):</strong> Dây chuyền choker thanh mảnh ôm sát chân cổ hoặc sợi xích mảnh tối giản.</li>
<li><strong>Sợi trung tâm (42 - 45cm):</strong> Dây chuyền có mặt điểm xuyết như mặt trăng khuyết Lunara Crescent Moon hoặc viên đá zircon sáng lấp lánh.</li>
<li><strong>Sợi dài nhất (50 - 55cm):</strong> Mặt dây chuyền hình giọt nước hoặc biểu tượng ngôi sao thả dài nhẹ nhàng.</li>
</ul>
<blockquote>Sự tinh tế của phong cách Quiet Luxury không nằm ở kích thước phô trương, mà nằm ở độ tỉ mỉ trong từng đường nét cắt gọt và sự hài hòa giữa các tầng lớp.</blockquote>
<h2>Kết hợp các kết cấu sợi dây (Textural Contrast)</h2>
<p>Đừng ngần ngại kết hợp sợi dây chuyền trơn bóng (Snake Chain) cùng sợi mắt xích mảnh (Cable Chain). Sự tương phản nhẹ nhàng về mặt xúc giác tạo nên chiều sâu cuốn hút mà vẫn giữ trọn vẻ đẹp thanh lịch vượt thời gian.</p>',
                'cover_image_url' => 'media/banner2.jpg',
                'image_url' => 'media/banner2.jpg',
                'status' => Post::STATUS_PUBLISHED,
                'is_published' => true,
                'is_featured' => false,
                'reading_time_minutes' => 3,
                'seo_title' => 'Nghệ Thuật Phối Lớp Dây Chuyền Bạc Chuẩn Quiet Luxury | Lunara',
                'seo_description' => 'Hướng dẫn phối lớp (layering) dây chuyền bạc 925 thanh lịch, tinh tế tôn vinh vẻ đẹp kiêu sa và thanh lịch của phái nữ.',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Ý Nghĩa Biểu Tượng Mặt Trăng Và Vì Sao Trong Trang Sức Lunara',
                'slug' => 'y-nghia-bieu-tuong-mat-trang-va-vi-sao-trong-trang-suc-lunara',
                'post_category_id' => $categoryModels['cam-nang-trang-suc']->id,
                'author_id' => $author?->id,
                'excerpt' => 'Mặt trăng biểu trưng cho sự dịu dàng và tái sinh, trong khi vì sao mang đến hy vọng và định hướng. Lắng nghe câu chuyện đằng sau từng thiết kế Lunara.',
                'content' => '<h2>Mặt trăng — Biểu tượng của vẻ đẹp nội tâm và sự chữa lành</h2>
<p>Từ thời cổ đại, mặt trăng đã luôn gắn liền với tính nữ, trực giác và chu kỳ tái sinh dịu dàng của tự nhiên. Dưới ánh trăng, mọi ồn ào của ban ngày dường như nhường chỗ cho sự tĩnh lặng và an yên.</p>
<p>Tại Lunara Silver, mỗi tạo tác trang sức bạc mang hình tượng trăng khuyết (Crescent Moon) đều gửi gắm thông điệp:</p>
<blockquote>"Bạn không cần phải luôn rực rỡ và tròn đầy như trăng rằm mới được xem là hoàn hảo. Ở bất kỳ giai đoạn nào của cuộc đời, bạn đều sở hữu một nét đẹp độc bản và xứng đáng được trân quý."</blockquote>
<h2>Ngôi sao Bắc Đẩu — Ánh sáng dẫn lối niềm hy vọng</h2>
<p>Đồng hành cùng ánh trăng là những vì tinh tú lấp lánh giữa màn đêm. Biểu tượng ngôi sao 4 cánh và 8 cánh đính đá Zirconia cao cấp tượng trưng cho niềm hy vọng kiên định và ngọn hải đăng soi sáng con đường bạn lựa chọn bước đi.</p>',
                'cover_image_url' => 'media/banner3.jpg',
                'image_url' => 'media/banner3.jpg',
                'status' => Post::STATUS_PUBLISHED,
                'is_published' => true,
                'is_featured' => false,
                'reading_time_minutes' => 3,
                'seo_title' => 'Ý Nghĩa Biểu Tượng Mặt Trăng Và Vì Sao | Lunara Silver',
                'seo_description' => 'Khám phá ý nghĩa phong thủy và tinh thần của trang sức mặt trăng và vì sao bạc 925 tại Lunara Silver.',
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Bản Nháp: Xu Hướng Trang Sức Tối Giản Mùa Thu Đông 2026',
                'slug' => 'ban-nhap-xu-huong-trang-suc-toi-gian-mua-thu-dong-2026',
                'post_category_id' => $categoryModels['bo-suu-tap-phong-cach']->id,
                'author_id' => $author?->id,
                'excerpt' => 'Bài viết bản nháp đang trong quá trình biên tập nội dung, chỉ quản trị viên có quyền xem trước trên giao diện.',
                'content' => '<p>Đây là bài viết bản nháp kiểm tra tính năng bảo mật phân quyền. Chỉ quản trị viên mới có thể xem trước bài viết này tại storefront.</p>',
                'cover_image_url' => 'media/Collection/set 1(1).jpg.png',
                'image_url' => 'media/Collection/set 1(1).jpg.png',
                'status' => Post::STATUS_DRAFT,
                'is_published' => false,
                'is_featured' => false,
                'reading_time_minutes' => 1,
                'seo_title' => null,
                'seo_description' => null,
                'published_at' => null,
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );
        }
    }
}
