<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // Đặt hàng
            [
                'category' => 'Đặt hàng',
                'question' => 'Làm thế nào để đặt hàng tại Lunara Silver?',
                'answer' => 'Quý khách có thể lựa chọn các tuyệt tác trang sức yêu thích, thêm vào giỏ hàng và tiến hành thanh toán qua giao diện trực tuyến tinh giản của Lunara. Chúng tôi hỗ trợ cả đặt hàng bằng tài khoản thành viên hoặc hình thức khách vãng lai (Guest).',
                'sort_order' => 1,
            ],
            [
                'category' => 'Đặt hàng',
                'question' => 'Tôi có thể thay đổi hoặc hủy đơn hàng sau khi đặt không?',
                'answer' => 'Nếu đơn hàng của quý khách đang ở trạng thái "Chờ xác nhận", quý khách có thể liên hệ ngay với bộ phận chăm sóc khách hàng qua Hotline/Live Chat hoặc biểu mẫu Liên hệ để được hỗ trợ điều chỉnh hoặc hủy đơn.',
                'sort_order' => 2,
            ],

            // Thanh toán
            [
                'category' => 'Thanh toán',
                'question' => 'Lunara Silver hỗ trợ những hình thức thanh toán nào?',
                'answer' => 'Lunara Silver hỗ trợ 2 phương thức thanh toán an toàn và tiện lợi: Thanh toán khi nhận hàng (COD) và Thanh toán trực tuyến qua cổng VNPay (hỗ trợ thẻ ATM nội địa, QR Code ngân hàng, và thẻ quốc tế Visa/MasterCard).',
                'sort_order' => 1,
            ],

            // VNPay
            [
                'category' => 'VNPay',
                'question' => 'Nếu thanh toán VNPay gặp sự cố hoặc bị gián đoạn thì xử lý thế nào?',
                'answer' => 'Đơn hàng của quý khách sẽ được giữ lại ở trạng thái "Chờ thanh toán". Quý khách có thể truy cập trang Chi tiết đơn hàng để thực hiện lại thanh toán (Retry VNPay) trong vòng 15 phút hoặc chuyển đổi phương thức sang COD nếu cần thiết.',
                'sort_order' => 1,
            ],
            [
                'category' => 'VNPay',
                'question' => 'Sau khi trừ tiền trong tài khoản nhưng trang báo lỗi thì tôi phải làm sao?',
                'answer' => 'Hệ thống tự động thực hiện đối soát và cập nhật đơn hàng. Quý khách vui lòng lưu lại mã giao dịch ngân hàng và liên hệ với Lunara qua mục Hỗ trợ để chuyên viên kiểm tra và kích hoạt đơn hàng ngay lập tức.',
                'sort_order' => 2,
            ],

            // Giao hàng
            [
                'category' => 'Giao hàng',
                'question' => 'Thời gian và chi phí giao hàng của Lunara Silver như thế nào?',
                'answer' => 'Thời gian giao hàng tiêu chuẩn từ 2-4 ngày làm việc đối với các tỉnh thành trên toàn quốc. Các đơn hàng đều được đóng gói theo quy chuẩn hộp quà trang sức cao cấp và niêm phong bảo mật.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Giao hàng',
                'question' => 'Tôi có được kiểm tra sản phẩm trước khi nhận hàng không?',
                'answer' => 'Quý khách hoàn toàn có quyền đồng kiểm tra ngoại quan hộp bưu kiện và sản phẩm cùng nhân viên giao nhận trước khi thanh toán hoặc ký nhận.',
                'sort_order' => 2,
            ],

            // Đổi trả
            [
                'category' => 'Đổi trả',
                'question' => 'Chính sách đổi trả sản phẩm tại Lunara Silver?',
                'answer' => "Lunara chấp nhận đổi sản phẩm trong vòng 7 ngày kể từ khi quý khách nhận hàng, áp dụng với các sản phẩm còn nguyên tem mác, hộp đựng nguyên vẹn và chưa qua sử dụng. Nếu phát sinh lỗi kỹ thuật chế tác từ Lunara, chúng tôi đổi mới 100% miễn phí vận chuyển.\n\nThông tin liên hệ hỗ trợ chính sách & đổi trả:\n• Hotline CSKH / Đặt hàng: 0971 124 922\n• Email liên hệ: lunaraslivertrangsuc@gmail.com\n• Địa chỉ: 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City\n• Giờ làm việc: Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)",
                'sort_order' => 1,
            ],

            // Tài khoản
            [
                'category' => 'Tài khoản',
                'question' => 'Lợi ích khi đăng ký tài khoản thành viên Lunara?',
                'answer' => 'Tài khoản thành viên giúp quý khách theo dõi chi tiết lịch sử đơn hàng, lưu địa chỉ giao nhận quen thuộc, nhận ưu đãi độc quyền dành riêng cho khách hàng thân thiết và trải nghiệm dịch vụ hỗ trợ ưu tiên.',
                'sort_order' => 1,
            ],

            // Khuyến mãi
            [
                'category' => 'Khuyến mãi',
                'question' => 'Làm sao để áp dụng mã giảm giá khi mua sắm?',
                'answer' => 'Tại trang Giỏ hàng hoặc Thanh toán, quý khách chỉ cần nhập mã ưu đãi vào ô "Mã ưu đãi" và bấm Áp dụng. Hệ thống sẽ tự động tính toán mức khấu trừ phù hợp với giá trị đơn hàng.',
                'sort_order' => 1,
            ],

            // Bảo quản trang sức
            [
                'category' => 'Bảo quản trang sức',
                'question' => 'Làm cách nào để trang sức bạc luôn giữ được độ sáng bóng?',
                'answer' => 'Nên tránh để trang sức bạc 925 tiếp xúc trực tiếp với hóa chất tẩy rửa mạnh, nước hoa hoặc clo trong hồ bơi. Khi không sử dụng, hãy lau khô bằng khăn mềm chuyên dụng và cất giữ trong hộp chống ẩm kèm túi zip kín khí của Lunara.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Bảo quản trang sức',
                'question' => 'Lunara Silver có hỗ trợ làm sáng và đánh bóng trang sức không?',
                'answer' => 'Tất cả sản phẩm chính hãng của Lunara đều được hưởng dịch vụ làm sáng và vệ sinh trang sức miễn phí trọn đời tại hệ thống cửa hàng và xưởng chế tác của chúng tôi.',
                'sort_order' => 2,
            ],
        ];

        foreach ($faqs as $item) {
            Faq::firstOrCreate(
                [
                    'category' => $item['category'],
                    'question' => $item['question'],
                ],
                [
                    'answer' => $item['answer'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
