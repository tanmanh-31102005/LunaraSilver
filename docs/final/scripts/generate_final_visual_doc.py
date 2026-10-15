import os
import sys
import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from report_builder_core import (
    add_header, add_body, add_bullet, add_image_with_caption,
    add_landscape_diagram_page, add_code_block, create_table, ASSET_DIR
)

sys.stdout.reconfigure(encoding='utf-8')

OUTPUT_FINAL_DOCX = os.path.abspath("docs/final/Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.docx")

def build_full_academic_report():
    print("Building full academic report docx...")
    doc = docx.Document()

    # Set standard academic page margins: Left=3.0cm, Right=2.0cm, Top=2.5cm, Bottom=2.5cm
    section = doc.sections[0]
    section.left_margin = Inches(1.18)    # 3.0 cm
    section.right_margin = Inches(0.79)   # 2.0 cm
    section.top_margin = Inches(0.98)     # 2.5 cm
    section.bottom_margin = Inches(0.98)  # 2.5 cm

    # =========================================================================
    # TRANG BÌA (COVER PAGE)
    # =========================================================================
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(2)
    r = p.add_run("BỘ GIÁO DỤC VÀ ĐÀO TẠO\nTRƯỜNG ĐẠI HỌC [TÊN TRƯỜNG]\nKHOA CÔNG NGHỆ THÔNG TIN / THƯƠNG MẠI ĐIỆN TỬ")
    r.font.name = 'Times New Roman'
    r.font.size = Pt(13)
    r.bold = True

    p_line = doc.add_paragraph()
    p_line.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_line.paragraph_format.space_after = Pt(40)
    r_line = p_line.add_run("-----------------------------------")
    r_line.font.name = 'Times New Roman'
    r_line.bold = True

    p_title = doc.add_paragraph()
    p_title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_title.paragraph_format.space_before = Pt(40)
    p_title.paragraph_format.space_after = Pt(15)
    r_t1 = p_title.add_run("BÁO CÁO ĐỒ ÁN MÔN HỌC\n")
    r_t1.font.name = 'Times New Roman'
    r_t1.font.size = Pt(16)
    r_t1.bold = True
    r_t2 = p_title.add_run("LẬP TRÌNH MÃ NGUỒN MỞ\n\n")
    r_t2.font.name = 'Times New Roman'
    r_t2.font.size = Pt(18)
    r_t2.bold = True
    r_t2.font.color.rgb = RGBColor(26, 28, 44)

    p_subject = doc.add_paragraph()
    p_subject.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_subject.paragraph_format.space_after = Pt(60)
    r_sub = p_subject.add_run("ĐỀ TÀI:\nXÂY DỰNG WEBSITE THƯƠNG MẠI ĐIỆN TỬ\nLUNARA SILVER\nSỬ DỤNG FRAMEWORK LARAVEL VÀ MYSQL")
    r_sub.font.name = 'Times New Roman'
    r_sub.font.size = Pt(17)
    r_sub.bold = True
    r_sub.font.color.rgb = RGBColor(160, 40, 40)

    p_info = doc.add_paragraph()
    p_info.paragraph_format.space_before = Pt(50)
    p_info.paragraph_format.space_after = Pt(70)
    p_info.paragraph_format.line_spacing = 1.3
    p_info.paragraph_format.left_indent = Inches(2.0)
    
    r_info = p_info.add_run(
        "Giảng viên hướng dẫn: [GIẢNG VIÊN HƯỚNG DẪN]\n"
        "Sinh viên thực hiện:  [HỌ VÀ TÊN SINH VIÊN]\n"
        "Mã số sinh viên:      [MSSV]\n"
        "Lớp:                  [LỚP]\n"
        "Khóa học:             2022 – 2026"
    )
    r_info.font.name = 'Times New Roman'
    r_info.font.size = Pt(13)
    r_info.bold = True

    p_footer = doc.add_paragraph()
    p_footer.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_footer.paragraph_format.space_before = Pt(30)
    r_foot = p_footer.add_run("TP. HỒ CHÍ MINH, NĂM 2026")
    r_foot.font.name = 'Times New Roman'
    r_foot.font.size = Pt(12)
    r_foot.bold = True

    doc.add_page_break()

    # =========================================================================
    # LỜI CAM ĐOAN
    # =========================================================================
    add_header(doc, "LỜI CAM ĐOAN", level=1)
    add_body(doc, "Tôi xin cam đoan rằng Báo cáo đồ án môn học với đề tài “Xây dựng Website Thương mại Điện tử Lunara Silver sử dụng Framework Laravel và MySQL” là công trình nghiên cứu và phát triển độc lập của riêng tôi dưới sự hướng dẫn khoa học của quý Thầy/Cô bộ môn.")
    add_body(doc, "Toàn bộ mã nguồn, cấu trúc cơ sở dữ liệu, các giải thuật nghiệp vụ (quản lý tồn kho bộ quà tặng, máy trạng thái đơn hàng, đối soát thanh toán điện tử VNPay), giao diện người dùng và các kết quả kiểm thử được trình bày trong báo cáo này đều phản ánh trung thực quá trình thực nghiệm trực tiếp trên hệ thống mã nguồn dự án Lunara Silver.")
    add_body(doc, "Các tài liệu tham khảo, thư viện mã nguồn mở và dịch vụ đám mây tích hợp bên ngoài đều được trích dẫn nguồn gốc rõ ràng, tuân thủ nghiêm ngặt giấy phép phần mềm (MIT, BSD, GPL) và chuẩn mực đạo đức học thuật.")
    
    p_sign = doc.add_paragraph()
    p_sign.alignment = WD_ALIGN_PARAGRAPH.RIGHT
    p_sign.paragraph_format.space_before = Pt(30)
    r_sign = p_sign.add_run("TP. Hồ Chí Minh, ngày 08 tháng 10 năm 2026\nSinh viên cam đoan\n\n\n\n[HỌ VÀ TÊN SINH VIÊN]")
    r_sign.font.name = 'Times New Roman'
    r_sign.font.size = Pt(13)
    r_sign.italic = True

    doc.add_page_break()

    # =========================================================================
    # LỜI CẢM ƠN
    # =========================================================================
    add_header(doc, "LỜI CẢM ƠN", level=1)
    add_body(doc, "Lời đầu tiên, em xin bày tỏ lòng biết ơn chân thành và sâu sắc nhất đến toàn thể quý Thầy/Cô Khoa Công nghệ Thông tin đã tận tình truyền đạt những tri thức nền tảng và chuyên sâu quý báu về kỹ thuật lập trình mã nguồn mở, kiến trúc phân lớp phần mềm và xây dựng hệ thống thương mại điện tử.")
    add_body(doc, "Đặc biệt, em xin gửi lời cảm ơn sâu sắc nhất đến Thầy/Cô Giảng viên phụ trách môn học Lập trình Mã nguồn mở đã tận tâm định hướng, theo sát và đưa ra những lời nhận xét chuyên môn sắc sảo trong suốt quá trình hoàn thiện đồ án.")
    add_body(doc, "Mặc dù đã đầu tư tối đa nỗ lực và thời gian nghiên cứu thực nghiệm, hệ thống và báo cáo khó tránh khỏi những thiếu sót nhất định do hạn chế về kinh nghiệm thực tế. Kính mong nhận được những ý kiến đóng góp quý báu từ quý Thầy/Cô Hội đồng để sản phẩm ngày càng hoàn thiện hơn.")

    doc.add_page_break()

    # =========================================================================
    # TÓM TẮT ĐỀ TÀI (ABSTRACT)
    # =========================================================================
    add_header(doc, "TÓM TẮT ĐỀ TÀI", level=1)
    add_header(doc, "1. Tóm tắt tiếng Việt", level=2)
    add_body(doc, "Đề tài tập trung nghiên cứu, thiết kế kiến trúc và phát triển toàn diện hệ thống thương mại điện tử chuyên ngành trang sức bạc Ý 925 cao cấp và quà tặng mang tên Lunara Silver trên nền tảng khung phát triển Laravel 12 và hệ quản trị cơ sở dữ liệu quan hệ MySQL/MariaDB.")
    add_body(doc, "Hệ thống giải quyết triệt để 5 bài toán nghiệp vụ cốt lõi của ngành trang sức bán lẻ:")
    add_bullet(doc, "Xây dựng trải nghiệm mua sắm xa xỉ (Luxury Storefront) theo phong cách Celestial Luxury Minimalism, tối ưu hóa khả năng tiếp cận WCAG 2.2 AA và tìm kiếm thời gian thực với độ trễ thấp.", "1. Trải nghiệm Khách hàng: ")
    add_bullet(doc, "Giải thuật quản lý tồn kho bộ quà tặng (Bundle Inventory Engine) giải quyết bài toán tồn kho ảo bằng công thức min(floor(Stock/Req)), khóa bi quan (Pessimistic Locking) chống bán vượt (overselling) và khôi phục kho idempotent đúng 1 lần.", "2. Tồn kho Thông minh: ")
    add_bullet(doc, "Tích hợp cổng thanh toán VNPay Sandbox với mã hóa chữ ký số HMAC-SHA512, cơ chế đối soát kép chủ động (QueryDr API) kết hợp Webhook IPN xử lý bất đồng bộ.", "3. Thanh toán Trực tuyến: ")
    add_bullet(doc, "Hệ thống đánh giá có xác thực mua hàng (Verified Purchase Reviews) gắn chặt với từng order item, hỗ trợ đính kèm hình ảnh Cloudinary và che giấu danh tính bảo vệ quyền riêng tư.", "4. Đánh giá Xác thực: ")
    add_bullet(doc, "Trung tâm điều hành doanh nghiệp (Admin Intelligence & Customer 360) với 5 chỉ số tài chính chuẩn xác (Gross Sales, Net Revenue, Refund, AOV, Units Sold) và kiến trúc Tab tải lười (Lazy Tabs) đạt tốc độ dưới 20ms.", "5. Quản trị Thông minh: ")
    add_body(doc, "Hệ thống đã được kiểm thử tự động nghiêm ngặt bằng PHPUnit với 367 bài kiểm thử, 0 failure, 3 risky tests và 1.762 assertions, đồng thời được triển khai thực nghiệm thành công trên hạ tầng máy chủ trực tuyến.")

    add_header(doc, "2. English Abstract", level=2)
    add_body(doc, "This academic project focuses on researching, architecting, and developing an end-to-end B2C e-commerce platform dedicated to 925 Italian silver jewelry and luxury gift sets named Lunara Silver, utilizing Laravel 12 framework and MySQL/MariaDB relational database.")
    add_body(doc, "The platform addresses 5 fundamental retail engineering challenges:")
    add_bullet(doc, "Celestial Luxury Minimalist aesthetic with WCAG 2.2 AA accessibility, real-time live search suggestions with debounced cancellation.", "1. Storefront Experience: ")
    add_bullet(doc, "Dynamic virtual inventory calculation for gift sets using min(floor(Stock/Req)), pessimistic concurrency locking (lockForUpdate), and idempotent stock restoration.", "2. Bundle Inventory Engine: ")
    add_bullet(doc, "Dual-channel payment lifecycle integrating VNPay Sandbox with HMAC-SHA512 cryptographic signatures, proactive server-to-server QueryDr reconciliation, and asynchronous IPN webhooks.", "3. Electronic Payments: ")
    add_bullet(doc, "Fraud-proof verified purchase reviews tied directly to completed order items, supporting Cloudinary image uploads and customer privacy name masking.", "4. Verified Reviews: ")
    add_bullet(doc, "Executive dashboard featuring precise financial metrics (Gross Sales, Net Revenue, Refunds, AOV) and a 360-degree customer relationship profile powered by AJAX lazy-loaded tabs under 20ms.", "5. Executive Intelligence: ")
    add_body(doc, "The codebase is verified by 367 automated tests (0 failures, 3 risky, 1,762 assertions) and successfully deployed to a live production environment.")

    doc.add_page_break()

    # =========================================================================
    # MỤC LỤC & DANH MỤC
    # =========================================================================
    add_header(doc, "MỤC LỤC TỔNG QUÁT", level=1)
    toc_items = [
        ("LỜI CAM ĐOAN", "ii"),
        ("LỜI CẢM ƠN", "iii"),
        ("TÓM TẮT ĐỀ TÀI", "iv"),
        ("MỤC LỤC TỔNG QUÁT", "v"),
        ("DANH MỤC HÌNH ẢNH", "vi"),
        ("DANH MỤC BẢNG BIỂU", "vii"),
        ("CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI", "1"),
        ("CHƯƠNG 2. CƠ SỞ LÝ THUYẾT VÀ CÔNG NGHỆ ÁP DỤNG", "8"),
        ("CHƯƠNG 3. PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG", "22"),
        ("CHƯƠNG 4. XÂY DỰNG VÀ TRIỂN KHAI HỆ THỐNG", "42"),
        ("CHƯƠNG 5. KIỂM THỬ VÀ ĐÁNH GIÁ KẾT QUẢ", "62"),
        ("CHƯƠNG 6. KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN", "74"),
        ("TÀI LIỆU THAM KHẢO", "77"),
        ("PHỤ LỤC A. CẤU TRÚC MÃ NGUỒN HỆ THỐNG", "79"),
        ("PHỤ LỤC B. MỘT SỐ ĐOẠN MÃ LARAVEL TIÊU BIỂU", "81"),
        ("PHỤ LỤC C. DANH MỤC 35 BẢNG CƠ SỞ DỮ LIỆU", "84"),
        ("PHỤ LỤC D. HƯỚNG DẪN CÀI ĐẶT VÀ VẬN HÀNH NHANH", "87"),
        ("PHỤ LỤC E. DANH MỤC TEST CASES MỞ RỘNG", "89"),
        ("PHỤ LỤC F. BẢNG ĐỐI CHIẾU CHUẨN ĐẦU RA MÔN HỌC", "92"),
        ("PHỤ LỤC G. DANH MỤC THƯ THỰC THƯ VIỆN MÃ NGUỒN MỞ", "94"),
        ("PHỤ LỤC H. CẨM NANG DÀNH CHO KHÁCH HÀNG", "96"),
        ("PHỤ LỤC I. CẨM NANG VẬN HÀNH DÀNH CHO QUẢN TRỊ VIÊN", "98"),
    ]
    for title, pg in toc_items:
        p_toc = doc.add_paragraph()
        p_toc.paragraph_format.space_before = Pt(2)
        p_toc.paragraph_format.space_after = Pt(2)
        r_t = p_toc.add_run(title)
        r_t.font.name = 'Times New Roman'
        r_t.font.size = Pt(12)
        if title.startswith("CHƯƠNG") or title.startswith("TÀI") or title.startswith("PHỤ"):
            r_t.bold = True
        
        # Leader dots
        dots_count = max(5, 75 - len(title))
        r_dots = p_toc.add_run(" " + "." * dots_count + " ")
        r_dots.font.name = 'Times New Roman'
        r_dots.font.size = Pt(11)
        r_dots.font.color.rgb = RGBColor(180, 180, 180)
        
        r_p = p_toc.add_run(pg)
        r_p.font.name = 'Times New Roman'
        r_p.font.size = Pt(12)
        r_p.bold = True

    doc.add_page_break()

    # DANH MỤC HÌNH ẢNH
    add_header(doc, "DANH MỤC HÌNH ẢNH", level=1)
    figures_list = [
        ("Hình 1.1", "Sơ đồ Kiến trúc Phân lớp Tổng quát của Hệ thống Lunara Silver"),
        ("Hình 3.1", "Sơ đồ Use Case Tổng quát Hệ thống Lunara Silver"),
        ("Hình 3.2", "Sơ đồ Use Case Phân hệ Khách hàng (Storefront)"),
        ("Hình 3.3", "Sơ đồ Use Case Phân hệ Quản trị (Admin Portal)"),
        ("Hình 3.4", "Sơ đồ Hoạt động (Activity Diagram) Quy trình Đặt hàng"),
        ("Hình 3.5", "Sơ đồ Hoạt động (Activity Diagram) Thanh toán & Đối soát VNPay"),
        ("Hình 3.6", "Sơ đồ Tuần tự (Sequence Diagram) Đăng nhập & Gộp Giỏ hàng"),
        ("Hình 3.7", "Sơ đồ Tuần tự (Sequence Diagram) Đặt hàng với Pessimistic Locking"),
        ("Hình 3.8", "Sơ đồ Tuần tự (Sequence Diagram) Thanh toán Kép & QueryDr"),
        ("Hình 3.9", "Sơ đồ Thực thể Quan hệ Tổng quan (ERD Diagram)"),
        ("Hình 3.10", "Sơ đồ Thực thể Chi tiết Phân hệ Sản phẩm & Tồn kho"),
        ("Hình 3.11", "Sơ đồ Thực thể Chi tiết Phân hệ Đơn hàng & Thanh toán"),
        ("Hình 4.1", "Giao diện Trang chủ Thương hiệu Trang sức Lunara Silver"),
        ("Hình 4.2", "Danh mục Sản phẩm & Bộ lọc Đa tiêu chí"),
        ("Hình 4.3", "Tìm kiếm Gợi ý Thời gian thực (Live Search)"),
        ("Hình 4.4", "Trang Chi tiết Sản phẩm & Gallery Đa góc nhìn"),
        ("Hình 4.5", "Sơ đồ Minh họa Giải thuật Tồn kho Khả dụng Bộ Quà tặng Combo"),
        ("Hình 4.6", "Chi tiết Bộ Quà Tặng & Danh sách Linh kiện Thành phần"),
        ("Hình 4.7", "Giao diện Giỏ hàng & Cá nhân hóa Thiệp Quà tặng"),
        ("Hình 4.8", "Trang Đặt hàng & Lựa chọn Cổng Thanh toán"),
        ("Hình 4.9", "Sơ đồ Máy Trạng thái Vòng đời Đơn hàng & Phục hồi Tồn kho An toàn"),
        ("Hình 4.10", "Hóa đơn Điện tử & Theo dõi Vòng đời Đơn hàng"),
        ("Hình 4.11", "Bảng điều khiển Trung tâm & Các chỉ số KPI Tài chính"),
        ("Hình 4.12", "Thanh Điều hướng Nhanh Command Palette (Ctrl+K)"),
        ("Hình 4.13", "Bảng Quản trị Sản phẩm & Điều phối Tồn kho"),
        ("Hình 4.14", "Biểu mẫu Khởi tạo & Cấu hình Sản phẩm"),
        ("Hình 4.15", "Quản trị Danh mục Sản phẩm Phân cấp"),
        ("Hình 4.16", "Danh sách Quản lý Đơn hàng & Bộ lọc Vận hành"),
        ("Hình 4.17", "Chi tiết Vận hành Đơn hàng, Đối soát & Hoàn tiền"),
        ("Hình 4.18", "Danh sách Khách hàng & Thống kê Tương tác"),
        ("Hình 4.19", "Hồ sơ Khách hàng 360 & Kiến trúc Tab Tải lười"),
        ("Hình 4.20", "Quản lý Mã Giảm Giá & Thiết lập Quy tắc Khuyến mãi"),
        ("Hình 4.21", "Hàng chờ Kiểm duyệt Đánh giá Khách hàng"),
        ("Hình 4.22", "Hệ thống Lunara Silver Triển khai trên Môi trường Hosting Sản xuất"),
        ("Hình 5.1", "Kết quả Thực thi Bộ Kiểm thử Tự động PHPUnit trên Terminal"),
    ]

    for f_id, f_desc in figures_list:
        p_f = doc.add_paragraph()
        p_f.paragraph_format.space_before = Pt(2)
        p_f.paragraph_format.space_after = Pt(2)
        r_id = p_f.add_run(f_id + ": ")
        r_id.font.name = 'Times New Roman'
        r_id.font.size = Pt(12)
        r_id.bold = True
        r_desc = p_f.add_run(f_desc)
        r_desc.font.name = 'Times New Roman'
        r_desc.font.size = Pt(12)

    doc.add_page_break()

    # DANH MỤC BẢNG BIỂU
    add_header(doc, "DANH MỤC BẢNG BIỂU", level=1)
    tables_list = [
        ("Bảng 2.1", "Tổng hợp Công nghệ & Thư viện Mã Nguồn Mở Tích hợp"),
        ("Bảng 3.1", "Bảng Yêu cầu Chức năng Hệ thống (Functional Requirements F01 - F31)"),
        ("Bảng 3.2", "Bảng Yêu cầu Phi chức năng Hệ thống (Non-Functional Requirements)"),
        ("Bảng 3.3", "Đặc tả Use Case: Xác thực Đăng nhập Hệ thống"),
        ("Bảng 3.4", "Đặc tả Use Case: Quản lý Danh mục & Sản phẩm"),
        ("Bảng 3.5", "Đặc tả Use Case: Quản lý Giỏ hàng & Lời chúc Thiệp"),
        ("Bảng 3.6", "Đặc tả Use Case: Quy trình Đặt hàng (Checkout)"),
        ("Bảng 3.7", "Đặc tả Use Case: Thanh toán Điện tử Cổng VNPay"),
        ("Bảng 3.8", "Đặc tả Use Case: Vận hành & Đổi trạng thái Đơn hàng"),
        ("Bảng 3.9", "Cấu trúc Bảng CSDL: users"),
        ("Bảng 3.10", "Cấu trúc Bảng CSDL: categories"),
        ("Bảng 3.11", "Cấu trúc Bảng CSDL: products"),
        ("Bảng 3.12", "Cấu trúc Bảng CSDL: bundle_items"),
        ("Bảng 3.13", "Cấu trúc Bảng CSDL: orders"),
        ("Bảng 3.14", "Cấu trúc Bảng CSDL: order_items"),
        ("Bảng 3.15", "Cấu trúc Bảng CSDL: payments"),
        ("Bảng 3.16", "Cấu trúc Bảng CSDL: payment_refunds"),
        ("Bảng 3.17", "Cấu trúc Bảng CSDL: coupons"),
        ("Bảng 3.18", "Cấu trúc Bảng CSDL: reviews"),
        ("Bảng 4.1", "Danh mục Các Module Đạt Chuẩn Full CRUD trong Hệ thống"),
        ("Bảng 4.2", "Quy tắc 7 Tầng Thẩm định Mã Giảm Giá (Coupon Validation Rules)"),
        ("Bảng 4.3", "Công thức Tính toán Chỉ số KPI Tài chính trên Dashboard"),
        ("Bảng 5.1", "Danh mục Test Cases Kiểm thử Tự động Tiêu biểu (28 Ca Kiểm thử)"),
        ("Bảng 5.2", "Tổng hợp Kết quả Kiểm thử Tự động Toàn diện"),
    ]
    for t_id, t_desc in tables_list:
        p_t = doc.add_paragraph()
        p_t.paragraph_format.space_before = Pt(2)
        p_t.paragraph_format.space_after = Pt(2)
        r_id = p_t.add_run(t_id + ": ")
        r_id.font.name = 'Times New Roman'
        r_id.font.size = Pt(12)
        r_id.bold = True
        r_desc = p_t.add_run(t_desc)
        r_desc.font.name = 'Times New Roman'
        r_desc.font.size = Pt(12)

    doc.add_page_break()

    # =========================================================================
    # CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI
    # =========================================================================
    add_header(doc, "CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI", level=1)
    
    add_header(doc, "1.1. Lý do chọn đề tài", level=2)
    add_body(doc, "Trong bối cảnh nền kinh tế số và thương mại điện tử (E-Commerce) bùng nổ mạnh mẽ tại Việt Nam, nhu cầu mua sắm trực tuyến không còn dừng lại ở các mặt hàng thiết yếu hay đồ gia dụng phổ thông, mà đã mở rộng sang phân khúc hàng hóa cao cấp, đặc biệt là trang sức bạc và phụ kiện thời trang tinh xảo.")
    add_body(doc, "Khác với các ngành hàng điện tử tiêu dùng vốn cạnh tranh chủ yếu dựa trên thông số kỹ thuật thuần túy, ngành trang sức bạc đòi hỏi một nền tảng thương mại điện tử chuyên biệt mang đậm tính thẩm mỹ, cảm xúc và niềm tin:")
    add_bullet(doc, "Trang sức là mặt hàng quà tặng có giá trị tinh thần lớn. Khách hàng mong muốn có trải nghiệm cá nhân hóa sâu sắc như viết thiệp chúc mừng riêng biệt, lựa chọn hộp quà cao cấp.", "Tính biểu trưng và quà tặng: ")
    add_bullet(doc, "Một bộ quà tặng (Gift Box) thường được cấu thành từ nhiều linh kiện độc lập (ví dụ: dây chuyền, nhẫn, hoa tai). Các hệ thống bán lẻ truyền thống thường gặp lỗi lệch kho hoặc bán quá số lượng (overselling) khi cùng bán món lẻ và bán theo combo.", "Thách thức tồn kho bộ combo: ")
    add_bullet(doc, "Khách hàng mua trang sức cao cấp cần sự đảm bảo tuyệt đối về tính minh bạch của giao dịch, sự an toàn của cổng thanh toán trực tuyến và những đánh giá thật từ người đã thực sự mua hàng.", "Độ tin cậy và minh bạch: ")
    add_body(doc, "Từ thực tế đó, đề tài “Xây dựng Website Thương mại Điện tử Lunara Silver sử dụng Framework Laravel và MySQL” được lựa chọn nhằm vận dụng toàn diện kiến thức của học phần Lập trình Mã nguồn mở vào giải quyết một bài toán thương mại thực tế, xây dựng một hệ thống hoàn chỉnh từ giao diện khách hàng (Storefront) đến cổng quản trị điều hành (Admin Portal).")

    add_header(doc, "1.2. Mục tiêu đề tài", level=2)
    add_body(doc, "Đề tài hướng tới các mục tiêu cụ thể sau:")
    add_bullet(doc, "Ứng dụng khung phát triển mã nguồn mở hiện đại nhất Laravel 12 kết hợp hệ quản trị cơ sở dữ liệu quan hệ MySQL/MariaDB để xây dựng hệ thống theo mô hình kiến trúc phân lớp chuẩn mực (Layered MVC + Service Layer Pattern).", "Về mặt công nghệ: ")
    add_bullet(doc, "Hoàn thiện đầy đủ các phân hệ thương mại điện tử: Quản lý danh mục, tìm kiếm gợi ý tức thì, giỏ hàng trực tuyến, thanh toán VNPay, theo dõi vòng đời đơn hàng, đánh giá xác thực, blog cẩm nang và quản trị toàn diện.", "Về mặt chức năng: ")
    add_bullet(doc, "Nghiên cứu và triển khai giải thuật quản lý tồn kho ảo cho sản phẩm combo/gift set; cơ chế khóa bi quan (Pessimistic Locking) trong Database Transaction bảo vệ tính toàn vẹn dữ liệu đặt hàng; và cơ chế đối soát kép hai kênh (QueryDr & IPN Webhook) trên cổng thanh toán VNPay.", "Về mặt giải thuật và an toàn dữ liệu: ")
    add_bullet(doc, "Xây dựng hệ thống kiểm thử tự động toàn diện với trên 360 bài test nhằm đảm bảo 100% không phát sinh lỗi hồi quy (regressions); tuân thủ chuẩn mã nguồn PSR-12 thông qua Laravel Pint.", "Về mặt chất lượng phần mềm: ")

    add_header(doc, "1.3. Đối tượng nghiên cứu", level=2)
    add_body(doc, "Đối tượng nghiên cứu của đề tài bao gồm:")
    add_bullet(doc, "Framework Laravel phiên bản 12.x, ngôn ngữ lập trình PHP 8.2+, hệ quản trị cơ sở dữ liệu quan hệ MariaDB/MySQL và công cụ đóng gói tài nguyên Vite.", "Đối tượng công nghệ: ")
    add_bullet(doc, "Quy trình mua sắm trực tuyến, quy trình tạo đơn hàng, trừ kho linh kiện theo thời gian thực, quy trình ký số bảo mật và đối soát hoàn tiền của cổng thanh toán điện tử VNPay.", "Đối tượng nghiệp vụ: ")
    add_bullet(doc, "Khách vãng lai (Guest), Khách hàng đã đăng ký (Customer), Quản trị viên hệ thống (Admin) và Cổng dịch vụ bên thứ ba (VNPay Gateway, Cloudinary CDN).", "Đối tượng người dùng và tác nhân: ")

    add_header(doc, "1.4. Phạm vi đề tài", level=2)
    add_body(doc, "Phạm vi nghiên cứu và triển khai của đề tài được xác định rõ ràng:")
    add_bullet(doc, "Xây dựng ứng dụng web đáp ứng đa thiết bị (Responsive Web Application) phục vụ mô hình B2C (Doanh nghiệp tới Khách hàng cá nhân).", "Phạm vi nền tảng: ")
    add_bullet(doc, "Hệ thống bao gồm phân hệ Storefront (trưng bày, tìm kiếm, giỏ hàng, đặt hàng, đánh giá, tài khoản) và phân hệ Admin Portal (dashboard tài chính, quản lý sản phẩm, đơn hàng, khách hàng 360, mã giảm giá, kiểm duyệt đánh giá, xuất báo cáo).", "Phạm vi chức năng: ")
    add_bullet(doc, "Đề tài tập trung vào việc hiện thực hóa mã nguồn đóng băng hoàn chỉnh trên môi trường máy chủ cục bộ (Local Development) và triển khai thực nghiệm trên hạ tầng máy chủ miễn phí (InfinityFree Hosting) cùng môi trường cổng thanh toán thử nghiệm (VNPay Sandbox).", "Phạm vi hạ tầng: ")

    add_header(doc, "1.5. Phương pháp thực hiện", level=2)
    add_body(doc, "Đề tài áp dụng các phương pháp nghiên cứu và phát triển phần mềm sau:")
    add_bullet(doc, "Thu thập và phân tích các yêu cầu chức năng và phi chức năng đặc thù của ngành trang sức bạc từ các hệ thống bán lẻ thực tế.", "1. Phương pháp khảo sát và phân tích yêu cầu: ")
    add_bullet(doc, "Sử dụng ngôn ngữ mô hình hóa UML để vẽ các sơ đồ kiến trúc, sơ đồ Use Case, sơ đồ Hoạt động (Activity Diagram), sơ đồ Tuần tự (Sequence Diagram) và sơ đồ Thực thể Quan hệ (ERD).", "2. Phương pháp thiết kế hướng đối tượng: ")
    add_bullet(doc, "Xây dựng mã nguồn theo mô hình MVC kết hợp Service Layer Pattern, tách biệt hoàn toàn tầng điều khiển HTTP (Controllers), tầng nghiệp vụ miền (Services) và tầng dữ liệu (Eloquent Models).", "3. Phương pháp phát triển phần mềm: ")
    add_bullet(doc, "Áp dụng phương pháp kiểm thử tự động với PHPUnit Framework, viết kiểm thử tích hợp (Feature Test) và kiểm thử đơn vị (Unit Test) cho mọi luồng nghiệp vụ trọng yếu trước khi hoàn thiện.", "4. Phương pháp kiểm thử và đảm bảo chất lượng: ")

    add_header(doc, "1.6. Kết quả đạt được", level=2)
    add_body(doc, "Sau quá trình nghiên cứu và lập trình nghiêm túc, đề tài đã đạt được các kết quả nổi bật:")
    add_bullet(doc, "Hoàn thành toàn diện 13 phân hệ chức năng với 143 tuyến đường (routes), 37 controllers, 27 services nghiệp vụ và 29 Eloquent models.", "Quy mô hệ thống: ")
    add_bullet(doc, "Hiện thực hóa 7 phân hệ đạt chuẩn Full CRUD hoàn chỉnh (Product, Category, Post, PostCategory, Faq, Coupon, Address) cùng các luồng nghiệp vụ vòng đời nâng cao (Order, Payment, Refund, Review Moderation).", "Chuẩn hóa CRUD: ")
    add_bullet(doc, "Giải quyết thành công bài toán tồn kho combo, khóa dữ liệu đặt hàng chống race condition, đối soát thanh toán kép VNPay và xuất báo cáo luồng Streaming CSV tối ưu bộ nhớ RAM dưới 16MB.", "Kỹ thuật chuyên sâu: ")
    add_bullet(doc, "Đạt 367 bài kiểm thử tự động với 1.762 assertions (0 failure), đạt chuẩn PSR-12 của Laravel Pint và đã triển khai hoạt động trực tuyến trên Internet.", "Chất lượng và triển khai: ")

    add_header(doc, "1.7. Quy trình nghiệp vụ tổng quát", level=2)
    add_body(doc, "Quy trình nghiệp vụ tổng quát của hệ thống Lunara Silver diễn ra theo chu trình khép kín:")
    add_body(doc, "1. Khách hàng truy cập hệ thống, khám phá các bộ sưu tập trang sức, tìm kiếm hoặc lọc sản phẩm theo các tiêu chí chất liệu và loại đá.")
    add_body(doc, "2. Khách hàng thêm sản phẩm đơn lẻ hoặc bộ quà tặng vào giỏ hàng, tùy chọn nhập lời chúc viết tay vào thiệp Lunara, áp dụng mã giảm giá và chuyển sang trang Đặt hàng.")
    add_body(doc, "3. Tại trang Checkout, khách hàng chọn phương thức thanh toán (COD hoặc VNPay). Hệ thống kích hoạt giao dịch CSDL với cơ chế khóa bi quan (lockForUpdate) để thẩm tra và trừ tồn kho chính xác.")
    add_body(doc, "4. Nếu chọn VNPay, khách hàng được chuyển tiếp an toàn sang cổng VNPay Sandbox để thanh toán. Khi hoàn tất, hệ thống tự động kích hoạt đối soát kép qua API QueryDr và cập nhật trạng thái đơn hàng.")
    add_body(doc, "5. Đơn hàng chuyển sang trạng thái chờ xử lý (Processing). Quản trị viên tại Admin Portal tiến hành xác nhận, đóng gói và bàn giao bưu tá chuyển phát.")
    add_body(doc, "6. Khi đơn hàng hoàn thành (Completed), khách hàng được cấp quyền gửi đánh giá có xác thực (Verified Review) kèm hình ảnh thực tế.")

    add_header(doc, "1.8. Kiến trúc triển khai tổng quát", level=2)
    add_body(doc, "Hệ thống Lunara Silver được thiết kế theo mô hình kiến trúc phân lớp (Layered Architecture) trên nền tảng Laravel 12. Mọi yêu cầu HTTP gửi đến từ trình duyệt đều đi qua điểm tiếp nhận duy nhất public/index.php, được xử lý qua chuỗi Middleware bảo mật và định tuyến, chuyển tiếp đến Controller, gọi các Service nghiệp vụ tương ứng và tương tác với cơ sở dữ liệu MariaDB/MySQL thông qua Eloquent ORM.")
    add_landscape_diagram_page(doc, "diagrams/system-architecture.png", "Hình 1.1. Sơ đồ Kiến trúc Phân lớp Tổng quát của Hệ thống Lunara Silver", width_inches=10.2, max_height_inches=6.6)

    add_header(doc, "1.9. Tiêu chí đánh giá", level=2)
    add_body(doc, "Hệ thống được đánh giá dựa trên 5 nhóm tiêu chí chính thức của môn học Lập trình Mã nguồn mở:")
    add_bullet(doc, "Tuân thủ nghiêm ngặt quy ước đặt tên của Laravel, phân tách tầng Controller - Service - Model rõ ràng, sử dụng Migration và Seeder bài bản, mã nguồn tuân thủ PSR-12.", "1. Tính chuẩn mực của mã nguồn mở: ")
    add_bullet(doc, "Đáp ứng đầy đủ các yêu cầu về CRUD (tối thiểu 2 bảng có quan hệ phân cấp), có phân quyền rõ ràng giữa User và Admin, có chức năng tìm kiếm, phân trang và xác thực dữ liệu.", "2. Tính đầy đủ về mặt chức năng: ")
    add_bullet(doc, "Áp dụng thành công các kỹ thuật giao tiếp AJAX, tối ưu hóa câu truy vấn chống N+1, tích hợp API bên thứ ba (Cổng thanh toán VNPay, Đám mây Cloudinary).", "3. Tính nâng cao về mặt kỹ thuật: ")
    add_bullet(doc, "Giao diện thẩm mỹ cao, hiển thị tối ưu trên màn hình điện thoại, máy tính bảng và máy tính để bàn (Responsive Web Design).", "4. Trải nghiệm người dùng (UX/UI): ")
    add_bullet(doc, "Có bộ kiểm thử tự động phong phú, tỷ lệ vượt qua cao, có tài liệu hướng dẫn vận hành chi tiết và có thể triển khai chạy thực tế trên Internet.", "5. Tính tin cậy và khả năng kiểm thử: ")

    doc.add_page_break()

    # =========================================================================
    # CHƯƠNG 2. CƠ SỞ LÝ THUYẾT VÀ CÔNG NGHỆ ÁP DỤNG
    # =========================================================================
    add_header(doc, "CHƯƠNG 2. CƠ SỞ LÝ THUYẾT VÀ CÔNG NGHỆ ÁP DỤNG", level=1)
    
    add_header(doc, "2.1. Ngôn ngữ lập trình PHP (PHP: Hypertext Preprocessor)", level=2)
    add_body(doc, "PHP là ngôn ngữ kịch bản máy chủ mã nguồn mở phổ biến hàng đầu thế giới trong phát triển ứng dụng web. Phiên bản được sử dụng trong dự án Lunara Silver là PHP 8.2.12 (yêu cầu từ ^8.2 trong composer.json). PHP 8.2 mang lại hiệu năng xử lý vượt trội nhờ trình biên dịch JIT (Just-In-Time), hỗ trợ kiểu dữ liệu nghiêm ngặt (Strict Types), các lớp chỉ đọc (Readonly Classes), kiểu hợp nhất (Union Types) và cơ chế bẫy lỗi hiện đại giúp mã nguồn hệ thống an toàn và dễ bảo trì.")

    add_header(doc, "2.2. Khung phát triển Laravel Framework", level=2)
    add_body(doc, "Laravel là khung phát triển ứng dụng web mã nguồn mở theo mô hình MVC hàng đầu dành cho ngôn ngữ PHP, được phát triển bởi Taylor Otwell. Dự án Lunara Silver sử dụng phiên bản mới nhất Laravel 12 (chính xác là laravel/framework v12.69.2 được ghi nhận từ composer.lock). Laravel cung cấp hệ sinh thái phong phú với cú pháp thanh lịch, hệ thống DI Container mạnh mẽ, cơ chế ORM Eloquent trực quan và khả năng mở rộng kiến trúc linh hoạt.")

    add_header(doc, "2.3. Mô hình kiến trúc MVC (Model - View - Controller)", level=2)
    add_body(doc, "Mô hình MVC là kiến trúc chuẩn mực giúp phân tách ứng dụng thành ba thành phần độc lập: Model đại diện cho cấu trúc dữ liệu và quy tắc nghiệp vụ; View quản lý giao diện hiển thị cho người dùng; và Controller đóng vai trò điều phối luồng thông tin giữa Model và View. Trong Lunara Silver, mô hình này được nâng cấp thành Layered Architecture với sự bổ sung của Service Domain Layer nằm giữa Controller và Model nhằm triệt tiêu hiện tượng 'Fat Controller'.")

    add_header(doc, "2.4. Hệ thống Định tuyến (Routing)", level=2)
    add_body(doc, "Hệ thống định tuyến trong tệp routes/web.php quản lý 143 tuyến đường, ánh xạ chính xác các phương thức HTTP (GET, POST, PUT, DELETE) đến các hành động tương ứng trong Controller. Dự án áp dụng phân nhóm định tuyến (Route Groups), tiền tố URL (Prefixes), đặt tên tuyến đường (Named Routes) và gắn kết Model ẩn (Implicit Route Model Binding).")

    add_header(doc, "2.5. Tầng Điều khiển (Controllers)", level=2)
    add_body(doc, "Hệ thống bao gồm 37 Controllers được phân chia thành các thư mục rõ ràng: App\\Http\\Controllers (Storefront và Auth) và App\\Http\\Controllers\\Admin (Quản trị). Các Controller đóng vai trò tiếp nhận HTTP Request, gọi các Form Request để kiểm tra tính hợp lệ của dữ liệu, ủy quyền xử lý nghiệp vụ cho Service Layer và trả về HTTP Response (View HTML hoặc JSON).")

    add_header(doc, "2.6. Tầng Dịch vụ Nghiệp vụ (Service Layer Pattern)", level=2)
    add_body(doc, "Để đảm bảo nguyên tắc Single Responsibility Principle (SRP) trong SOLID, toàn bộ các giải thuật nghiệp vụ phức tạp của Lunara Silver được đóng gói trong 27 Services tại thư mục app/Services/. Tiêu biểu như: CartService (quản lý giỏ hàng và gộp giỏ), OrderInventoryService (quản lý tồn kho combo), VNPayService (ký số và tạo URL thanh toán), PaymentReconciliationService (đối soát QueryDr) và AnalyticsService (tính toán các chỉ số tài chính).")

    add_header(doc, "2.7. Đối tượng quan hệ ánh xạ Eloquent ORM", level=2)
    add_body(doc, "Eloquent là hệ thống ORM trực quan của Laravel sử dụng mẫu Active Record. Lunara Silver xây dựng 29 Models trong thư mục app/Models/, khai báo đầy đủ các mối quan hệ đa dạng: hasMany, belongsTo, belongsToMany, hasOne. Eloquent giúp các thao tác truy vấn cơ sở dữ liệu trở nên trong sáng, đồng thời hỗ trợ cơ chế Eager Loading (with) để loại bỏ triệt để vấn đề N+1 query.")

    add_header(doc, "2.8. Hệ thống Quản lý Phiên bản CSDL (Migrations)", level=2)
    add_body(doc, "Migrations đóng vai trò như hệ thống kiểm soát phiên bản (VCS) cho cơ sở dữ liệu. Dự án sở hữu 17 migration files trong database/migrations/, định nghĩa chi tiết cấu trúc của 35 bảng, các trường dữ liệu, khóa chính, khóa ngoại, chỉ mục phức hợp (composite indexes) và các ràng buộc toàn vẹn mà không cần viết mã SQL thủ công.")

    add_header(doc, "2.9. Khởi tạo Dữ liệu Mẫu (Seeders & Factories)", level=2)
    add_body(doc, "Seeders cho phép khởi tạo dữ liệu ban đầu cho hệ thống một cách nhanh chóng và tự động. Lunara Silver cung cấp CatalogSeeder, AdminUserSeeder và BlogSeeder để nạp danh mục trang sức, sản phẩm đơn lẻ, các bộ sưu tập combo, hình ảnh, tài khoản quản trị và bài viết tin tức sẵn sàng cho việc phát triển và kiểm thử.")

    add_header(doc, "2.10. Động cơ Giao diện Blade Template", level=2)
    add_body(doc, "Blade là công cụ tạo mẫu giao diện mạnh mẽ nhưng nhẹ nhàng của Laravel. Blade biên dịch trực tiếp sang mã PHP thuần giúp tối ưu tốc độ. Dự án sử dụng cấu trúc kế thừa Layout (@extends), nạp khối nội dung (@section), chèn các thành phần tái sử dụng (@include) và tự động mã hóa đầu ra (htmlspecialchars qua {{ }}) để ngăn chặn tấn công XSS.")

    add_header(doc, "2.11. Lớp lọc Trung gian (Middleware)", level=2)
    add_body(doc, "Middleware cung cấp cơ chế thuận tiện để lọc và chặn các yêu cầu HTTP đi vào ứng dụng. Lunara Silver xây dựng 3 Middleware tùy biến cốt lõi: EnsureUserIsAdmin (kiểm tra quyền truy cập khu vực quản trị), SecurityHeadersMiddleware (bổ sung các tiêu đề bảo mật CSP, X-Frame-Options, nosniff) và SeoRedirectMiddleware (tự động chuyển hướng mã 301 cho các đường dẫn cũ).")

    add_header(doc, "2.12. Thẩm định Dữ liệu (Validation & Form Requests)", level=2)
    add_body(doc, "Mọi dữ liệu đầu vào từ người dùng đều được thẩm định nghiêm ngặt thông qua các lớp Form Request chuyên biệt (như CheckoutRequest, ProductRequest, CouponRequest). Cơ chế thẩm định đảm bảo kiểu dữ liệu, độ dài, tính duy nhất trong CSDL và phát sinh thông báo lỗi tiếng Việt thân thiện khi dữ liệu không hợp lệ.")

    add_header(doc, "2.13. Xác thực Người dùng (Authentication)", level=2)
    add_body(doc, "Hệ thống xác thực quản lý việc đăng ký, đăng nhập và đăng xuất. Mật khẩu người dùng được băm an toàn bằng thuật toán Bcrypt 12 rounds. Khi đăng nhập thành công, hệ thống tự động tái tạo Session ID ($request->session()->regenerate()) nhằm triệt tiêu hoàn toàn nguy cơ tấn công cố định phiên (Session Fixation).")

    add_header(doc, "2.14. Phân quyền và Kiểm soát Truy cập (Authorization & Policies)", level=2)
    add_body(doc, "Hệ thống áp dụng mô hình phân quyền dựa trên vai trò (Role-Based Access Control - RBAC) với 2 vai trò: user và admin. Ngoài Middleware kiểm tra vai trò quản trị, hệ thống sử dụng các lớp Policy (OrderPolicy, AddressPolicy) để ngăn chặn lỗ hổng IDOR (Insecure Direct Object References), bảo đảm khách hàng chỉ có quyền xem và sửa đơn hàng của chính mình.")

    add_header(doc, "2.15. Giao thức HTTP và Đối tượng Request/Response", level=2)
    add_body(doc, "Mọi giao tiếp mạng đều tuân thủ chuẩn giao thức HTTP/1.1 và HTTPS. Laravel đóng gói các yêu cầu mạng thành đối tượng Illuminate\\Http\\Request và phản hồi qua Illuminate\\Http\\Response, hỗ trợ trả về đa dạng kiểu dữ liệu: HTML View, JSON phản hồi cho AJAX, tệp tải về và luồng dữ liệu (StreamedResponse).")

    add_header(doc, "2.16. Quản lý Phiên làm việc và Cookie (Session Management)", level=2)
    add_body(doc, "Hệ thống sử dụng cơ chế lưu trữ phiên trên tệp (File Session Driver) hoặc cơ sở dữ liệu (Database Session). Cookie của phiên được cấu hình an toàn với các cờ HttpOnly (chống truy cập bằng JavaScript), SameSite=Lax (chống CSRF) và Secure trên môi trường sản xuất.")

    add_header(doc, "2.17. Giao dịch Cơ sở Dữ liệu (Database Transactions)", level=2)
    add_body(doc, "Database Transactions đảm bảo 4 tính chất ACID (Atomicity, Consistency, Isolation, Durability) khi xử lý các nghiệp vụ tài chính và kho hàng. Toàn bộ tiến trình tạo đơn hàng, trừ kho nhiều sản phẩm và tạo bản ghi thanh toán được bọc trong khối DB::transaction(). Nếu xảy ra bất kỳ ngoại lệ nào, hệ thống tự động Rollback toàn bộ dữ liệu.")

    add_header(doc, "2.18. Khóa Bi quan (Pessimistic Locking / lockForUpdate)", level=2)
    add_body(doc, "Để ngăn chặn hiện tượng Race Condition khi nhiều khách hàng cùng đặt mua sản phẩm cuối cùng trong kho tại cùng một thời điểm, Lunara Silver sử dụng phương thức lockForUpdate() của Eloquent. Phương thức này phát sinh mệnh đề SQL SELECT ... FOR UPDATE, khóa các dòng dữ liệu liên quan ở mức cơ sở dữ liệu cho đến khi giao dịch hiện tại hoàn tất.")

    add_header(doc, "2.19. Kỹ thuật Giao tiếp Bất đồng bộ (AJAX, Axios & Fetch API)", level=2)
    add_body(doc, "Giao diện Lunara Silver mang lại trải nghiệm mượt mà không cần nạp lại toàn bộ trang web nhờ kỹ thuật AJAX. Fetch API và thư viện Axios được sử dụng trong các tác vụ: Cập nhật số lượng giỏ hàng, nạp gợi ý tìm kiếm tức thời (Live Search) và tải lười các tab trong hồ sơ khách hàng 360 (Lazy Tabs).")

    add_header(doc, "2.20. Khung Giao diện Bootstrap 5.3 & Thiết kế Đáp ứng", level=2)
    add_body(doc, "Hệ thống sử dụng Bootstrap 5.3.8 kết hợp Bootstrap Icons 1.13.1 và bộ Design Tokens CSS độc quyền. Hệ thống lưới linh hoạt (Grid System) đảm bảo trang web hiển thị hoàn hảo và cân đối trên mọi kích thước màn hình từ điện thoại di động (Mobile), máy tính bảng (Tablet) đến máy tính để bàn (Desktop).")

    add_header(doc, "2.21. Công cụ Đóng gói Tài nguyên Vite", level=2)
    add_body(doc, "Vite 7.3.6 là công cụ đóng gói tài nguyên frontend thế hệ mới với tốc độ vượt trội. Vite biên dịch các tệp SCSS/CSS và JavaScript thành các tệp xuất xưởng tối ưu được gán mã băm (content hash) tại thư mục public/build/, hỗ trợ tính năng Hot Module Replacement (HMR) trong quá trình phát triển.")

    add_header(doc, "2.22. Thư viện Trực quan hóa Dữ liệu Chart.js", level=2)
    add_body(doc, "Chart.js phiên bản 4.4.x được sử dụng để vẽ biểu đồ trực quan hóa doanh thu theo ngày và tỷ lệ cơ cấu phương thức thanh toán trên Admin Dashboard. Thư viện được nạp lười (Lazy Loaded) chỉ tại trang Dashboard để không làm tăng dung lượng tải trang của các màn hình quản trị khác.")

    add_header(doc, "2.23. Dịch vụ Lưu trữ Truyền thông Đám mây Cloudinary", level=2)
    add_body(doc, "Dự án tích hợp bộ công cụ Cloudinary PHP SDK v3.1.3 nhằm lưu trữ và phân phối hình ảnh trang sức qua mạng lưới máy chủ biên toàn cầu (CDN). Hình ảnh được tự động nén định dạng WebP tối ưu. Đồng thời, hệ thống xây dựng cơ chế Fallback an toàn: Tự động chuyển đổi giữa ảnh local và ảnh Cloudinary mà không làm vỡ giao diện.")

    add_header(doc, "2.24. Cổng Thanh toán Điện tử VNPay", level=2)
    add_body(doc, "Cổng thanh toán VNPay Sandbox v2.1.0 được tích hợp sâu vào quy trình thanh toán. Giao tiếp giữa Lunara Silver và VNPay được bảo vệ bằng chữ ký số HMAC-SHA512. Hệ thống áp dụng cơ chế xác thực kép: Vừa kiểm tra tham số trả về tại Return URL, vừa thực hiện gọi API QueryDr sang máy chủ VNPay để đối soát tính hợp lệ.")

    add_header(doc, "2.25. Giao thức Thư điện tử Đơn giản (SMTP Mailer)", level=2)
    add_body(doc, "Hệ thống sử dụng giao thức SMTP mã hóa TLS cổng 587 kết nối với máy chủ Google Mail (smtp.gmail.com) để gửi thư xác nhận đơn hàng tự động đến khách hàng. Tiến trình gửi thư được thiết kế an toàn trong khối try-catch, bảo đảm lỗi mạng gửi email không làm gián đoạn việc tạo đơn hàng của khách.")

    add_header(doc, "2.26. Hệ thống Kiểm soát Phiên bản Git", level=2)
    add_body(doc, "Toàn bộ mã nguồn dự án được quản lý phiên bản bằng Git. Quy trình làm việc áp dụng Feature Branch Workflow, thực hiện kiểm thử tự động và kiểm tra định dạng mã nguồn trước mỗi lần cam kết (commit) nhằm bảo đảm tính ổn định tuyệt đối của nhánh chính (main).")

    # Bảng 2.1 Tổng hợp Công nghệ Mã nguồn mở
    add_header(doc, "2.27. Bảng Tổng hợp Công nghệ & Thư viện Mã Nguồn Mở Tích hợp", level=2)
    add_body(doc, "Dưới đây là ma trận chi tiết các công nghệ và thư viện mã nguồn mở được tích hợp trong hệ thống Lunara Silver, được trích xuất trực tiếp từ các tệp khóa phiên bản composer.lock và package-lock.json:")
    
    headers_tech = ["Tên công nghệ / Thư viện", "Phiên bản thực tế", "Giấy phép (License)", "Loại phân loại", "Vai trò & Vị trí sử dụng"]
    rows_tech = [
        ["laravel/framework", "12.69.2", "MIT License", "PHP Backend Core", "Khung kiến trúc MVC, DI Container, Eloquent ORM, Routing"],
        ["cloudinary/cloudinary_php", "3.1.3", "MIT License", "PHP SDK Cloud", "Kết nối API Cloudinary lưu trữ và phân phối ảnh WebP"],
        ["laravel/tinker", "2.11.1", "MIT License", "PHP Dev Tool", "Môi trường dòng lệnh REPL tương tác với Eloquent Models"],
        ["symfony/http-foundation", "7.4.19", "MIT License", "PHP Core Lib", "Lớp trừu tượng hóa xử lý HTTP Request và HTTP Response"],
        ["phpunit/phpunit", "11.5.56", "BSD-3-Clause", "Testing Suite", "Bộ khung thực thi 367 bài kiểm thử tự động Unit & Feature"],
        ["laravel/pint", "1.30.4", "MIT License", "Code Formatter", "Công cụ tự động chuẩn hóa cú pháp theo tiêu chuẩn PSR-12"],
        ["fakerphp/faker", "1.24.1", "MIT License", "Data Generator", "Phát sinh dữ liệu ngẫu nhiên cho Model Factories kiểm thử"],
        ["bootstrap", "5.3.8", "MIT License", "Frontend UI", "Hệ thống lưới Responsive 12 cột và các thành phần giao diện"],
        ["bootstrap-icons", "1.13.1", "MIT License", "Vector Icons", "Bộ biểu tượng vector SVG hiển thị nút bấm và thanh điều hướng"],
        ["axios", "1.11.0", "MIT License", "HTTP Client", "Thư viện JavaScript gửi yêu cầu AJAX bất đồng bộ ngầm"],
        ["vite", "7.3.6", "MIT License", "Build Tool", "Công cụ biên dịch và tối ưu hóa tài nguyên CSS/JS đóng gói"],
        ["laravel-vite-plugin", "2.0.0", "MIT License", "Frontend Plugin", "Cầu nối tích hợp tự động giữa Vite và Blade Template"],
        ["concurrently", "9.0.1", "MIT License", "Dev Runner", "Tiện ích chạy song song dev server và vite bundler"],
        ["chart.js", "4.4.x", "MIT License", "Visualization", "Vẽ biểu đồ doanh thu và phương thức thanh toán tại Admin"],
        ["MariaDB / MySQL Engine", "10.4.32", "GPL v2", "Database RDBMS", "Hệ quản trị CSDL quan hệ lưu trữ 35 bảng dữ liệu InnoDB"],
    ]
    create_table(doc, headers_tech, rows_tech, [Inches(1.8), Inches(1.1), Inches(1.2), Inches(1.2), Inches(2.2)], caption="Bảng 2.1. Tổng hợp Công nghệ & Thư viện Mã Nguồn Mở Tích hợp")

    add_body(doc, "Lưu ý quan trọng: Cần phân định rõ ràng giữa các thư viện mã nguồn mở nêu trên với các dịch vụ đám mây bên thứ ba được tích hợp qua giao thức API như: Cổng thanh toán VNPay Sandbox, Máy chủ lưu trữ hình ảnh Cloudinary, Máy chủ gửi thư Google SMTP và Hạ tầng lưu trữ InfinityFree. Các dịch vụ này là External Cloud Services, không phải là thư viện mã nguồn mở.")

    doc.add_page_break()

    # =========================================================================
    # CHƯƠNG 3. PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG
    # =========================================================================
    add_header(doc, "CHƯƠNG 3. PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG", level=1)
    
    add_header(doc, "3.1. Khảo sát nghiệp vụ", level=2)
    add_body(doc, "Hệ thống Lunara Silver hướng tới việc vận hành một doanh nghiệp bán lẻ trang sức bạc quy mô vừa và nhỏ. Khảo sát thực tế chỉ ra các yêu cầu nghiệp vụ bắt buộc: Khách hàng cần xem chi tiết các góc ảnh của sản phẩm bạc, chọn size nhẫn, đặt theo combo quà tặng có hộp đóng gói và thiệp viết tay; hệ thống phải xử lý đơn hàng tức thời, hỗ trợ thanh toán trực tuyến và ghi nhận lịch sử giao dịch minh bạch.")

    add_header(doc, "3.2. Các tác nhân trong hệ thống (Actors)", level=2)
    add_body(doc, "Hệ thống xác định 3 tác nhân con người chính và 1 tác nhân hệ thống bên ngoài:")
    add_bullet(doc, "Người dùng chưa đăng nhập hệ thống, có thể xem danh mục sản phẩm, tìm kiếm, thêm hàng vào giỏ hàng phiên (Session Cart) và thực hiện đặt hàng.", "1. Khách vãng lai (Guest): ")
    add_bullet(doc, "Người dùng đã có tài khoản xác thực, sở hữu đầy đủ quyền hạn của Guest, kèm theo quyền quản lý sổ địa chỉ giao hàng cá nhân, theo dõi lịch sử đơn hàng, sử dụng mã coupon cá nhân hóa và viết đánh giá có xác thực mua hàng.", "2. Khách hàng thành viên (Customer): ")
    add_bullet(doc, "Người quản trị nắm giữ toàn quyền vận hành: Quản trị danh mục và sản phẩm, xử lý đơn hàng, đối soát và hoàn tiền VNPay, tra cứu hồ sơ khách hàng 360, kiểm duyệt đánh giá và xuất báo cáo kế toán.", "3. Quản trị viên (Admin): ")
    add_bullet(doc, "Cổng thanh toán điện tử đóng vai trò tiếp nhận yêu cầu thanh toán, xác thực giao dịch từ ngân hàng của khách và phản hồi kết quả về cho Lunara Silver.", "4. Cổng VNPay (External System Actor): ")

    add_header(doc, "3.3. Yêu cầu chức năng (Functional Requirements)", level=2)
    add_body(doc, "Từ việc phân tích 143 tuyến đường và 37 controllers thực tế, hệ thống Lunara Silver bao gồm 31 yêu cầu chức năng cốt lõi được mã hóa từ F01 đến F31 như sau:")

    headers_fr = ["Mã YC", "Tên chức năng", "Tác nhân (Actor)", "Mô tả chi tiết chức năng"]
    rows_fr = [
        ["F01", "Đăng ký tài khoản", "Guest", "Tạo tài khoản thành viên mới với email và mật khẩu được mã hóa Bcrypt."],
        ["F02", "Đăng nhập xác thực", "Guest, Customer, Admin", "Xác thực danh tính, tự động phân quyền điều hướng và gộp giỏ hàng."],
        ["F03", "Đăng xuất tài khoản", "Customer, Admin", "Hủy phiên làm việc hiện tại và tái tạo Session an toàn."],
        ["F04", "Khám phá danh mục", "Guest, Customer", "Trưng bày danh sách sản phẩm phân trang, hiển thị nhãn mới và giá bán."],
        ["F05", "Tìm kiếm tức thời", "Guest, Customer", "Tìm kiếm gợi ý theo từ khóa tên sản phẩm với kỹ thuật Debounce 300ms."],
        ["F06", "Lọc sản phẩm đa chiều", "Guest, Customer", "Lọc sản phẩm theo danh mục, chất liệu bạc, loại đá quý và khoảng giá."],
        ["F07", "Xem chi tiết sản phẩm", "Guest, Customer", "Xem thông số kỹ thuật, gallery đa ảnh và danh sách linh kiện bộ quà tặng."],
        ["F08", "Quản lý yêu thích", "Customer", "Thêm hoặc xóa sản phẩm khỏi danh sách Wishlist cá nhân."],
        ["F09", "Quản trị giỏ hàng", "Guest, Customer", "Thêm món, cập nhật số lượng qua Fetch API, kiểm tra tồn kho tức thời."],
        ["F10", "Áp dụng mã giảm giá", "Guest, Customer", "Kiểm tra 7 tầng điều kiện và tính toán giảm giá đơn hàng."],
        ["F11", "Quy trình Đặt hàng", "Guest, Customer", "Điền địa chỉ giao nhận, ghi chú thiệp quà tặng và chốt đơn."],
        ["F12", "Thanh toán COD", "Guest, Customer", "Tạo đơn hàng thanh toán tiền mặt khi nhận hàng."],
        ["F13", "Thanh toán VNPay", "Guest, Customer", "Ký số HMAC-SHA512 và chuyển tiếp sang Cổng VNPay Sandbox."],
        ["F14", "Tra cứu đơn hàng", "Customer", "Theo dõi lịch sử mua hàng, trạng thái vận chuyển và hóa đơn chi tiết."],
        ["F15", "Đánh giá xác thực", "Customer", "Viết đánh giá sản phẩm đã mua thành công kèm đăng tải ảnh thực tế."],
        ["F16", "Hỗ trợ Concierge", "Guest, Customer", "Gửi tin nhắn tư vấn trực tuyến và nhận phản hồi từ bộ phận chăm sóc."],
        ["F17", "Quản trị Sản phẩm", "Admin", "Full CRUD sản phẩm đơn lẻ và bộ combo, điều phối tồn kho vật lý và ảo."],
        ["F18", "Quản trị Danh mục", "Admin", "Full CRUD danh mục sản phẩm phân cấp cha - con với ràng buộc khóa."],
        ["F19", "Cảnh báo Tồn kho", "Admin", "Hàng chờ Attention Required phát hiện sản phẩm chạm ngưỡng tồn tối thiểu."],
        ["F20", "Vận hành Đơn hàng", "Admin", "Chuyển trạng thái đơn qua máy trạng thái (Pending -> Processing -> Shipped)."],
        ["F21", "Đối soát VNPay", "Admin", "Phát lệnh Server-to-Server gọi API QueryDr xác thực giao dịch."],
        ["F22", "Hoàn tiền trực tuyến", "Admin", "Phát lệnh hoàn tiền qua API VNPay và hoàn trả tồn kho tự động."],
        ["F23", "Quản lý Khuyến mãi", "Admin", "Full CRUD mã giảm giá và cấu hình hạn mức chiết khấu."],
        ["F24", "Quản trị Blog CMS", "Admin", "Full CRUD bài viết cẩm nang trang sức kèm bộ lọc làm sạch XSS."],
        ["F25", "Quản trị FAQ", "Admin", "Full CRUD câu hỏi thường gặp về chính sách bảo hành và đổi trả."],
        ["F26", "Kiểm duyệt Đánh giá", "Admin", "Duyệt hoặc ẩn đánh giá của khách hàng và đăng tải phản hồi thương hiệu."],
        ["F27", "Quản lý Khách hàng", "Admin", "Xem danh sách khách hàng được tối ưu hóa bằng truy vấn leftJoinSub."],
        ["F28", "Hồ sơ Khách hàng 360", "Admin", "Xem tổng quan giá trị trọn đời (LTV) và 5 Tab tải lười (Lazy Tabs) AJAX."],
        ["F29", "Dashboard Tài chính", "Admin", "Giám sát 5 chỉ số tài chính chuẩn xác (Gross, Net, Refund, AOV, Units)."],
        ["F30", "Xuất Báo cáo CSV", "Admin", "Xuất dữ liệu kế toán theo luồng chunkById(200) chống tràn bộ nhớ RAM."],
        ["F31", "Command Palette", "Admin", "Thanh điều hướng tìm nhanh (Ctrl+K) phân luồng thông minh theo tiền tố."],
    ]
    create_table(doc, headers_fr, rows_fr, [Inches(0.8), Inches(1.8), Inches(1.5), Inches(3.3)], caption="Bảng 3.1. Bảng Yêu cầu Chức năng Hệ thống (F01 - F31)")

    add_header(doc, "3.4. Yêu cầu phi chức năng (Non-Functional Requirements)", level=2)
    add_body(doc, "Hệ thống đáp ứng 12 yêu cầu phi chức năng khắt khe nhằm đảm bảo độ tin cậy và trải nghiệm người dùng:")

    headers_nfr = ["Mã YC", "Tiêu chuẩn phi chức năng", "Mô tả yêu cầu kỹ thuật chi tiết"]
    rows_nfr = [
        ["NF01", "Giao diện Đáp ứng (Responsive)", "Tối ưu hiển thị hoàn hảo trên màn hình từ 375px đến 1920px."],
        ["NF02", "Hiệu năng Truy vấn (Performance)", "Triệt tiêu N+1 queries, thời gian phản hồi trang dưới 200ms trên môi trường local."],
        ["NF03", "Kiểm soát Dữ liệu (Validation)", "Thẩm tra 100% dữ liệu đầu vào qua Form Request, ngăn chặn chèn dữ liệu rác."],
        ["NF04", "An toàn Mật khẩu (Password Security)", "Mã hóa một chiều bằng Bcrypt độ phức tạp 12 vòng, không lưu bản rõ."],
        ["NF05", "Phân quyền Kiểm soát (Authorization)", "Chặn đứng leo thang đặc quyền (Privilege Escalation) và lỗ hổng IDOR."],
        ["NF06", "Bảo vệ XSS & CSRF (Web Security)", "Mã hóa ký tự đặc biệt qua Blade, làm sạch HTML bằng Purifier và kiểm tra @csrf token."],
        ["NF07", "Toàn vẹn Giao dịch (Data Integrity)", "Sử dụng DB Transaction và khóa bi quan (lockForUpdate) chống bán vượt kho."],
        ["NF08", "Tối ưu Tìm kiếm (SEO Standard)", "Cấu hình Canonical, robots.txt, XML sitemap và siêu dữ liệu cấu trúc Schema.org JSON-LD."],
        ["NF09", "Khả năng Tiếp cận (Accessibility)", "Hỗ trợ điều hướng bằng bàn phím, nhãn ARIA và độ tương phản màu đạt chuẩn WCAG 2.2 AA."],
        ["NF10", "Khả năng Bảo trì (Maintainability)", "Tuân thủ mô hình Layered MVC, nguyên tắc SOLID và tiêu chuẩn định dạng mã nguồn PSR-12."],
        ["NF11", "Nhật ký Hoạt động (Audit Logging)", "Ghi vết lịch sử thay đổi trạng thái đơn hàng (order_status_histories) và log lỗi hệ thống."],
        ["NF12", "Triển khai Thực tế (Deployment)", "Khả năng vận hành ổn định trên máy chủ Web Server chuẩn (Nginx/Apache, PHP-FPM, MySQL)."],
    ]
    create_table(doc, headers_nfr, rows_nfr, [Inches(1.0), Inches(2.2), Inches(4.2)], caption="Bảng 3.2. Bảng Yêu cầu Phi chức năng Hệ thống")

    add_header(doc, "3.5. Sơ đồ Use Case Tổng quát", level=2)
    add_body(doc, "Sơ đồ Use Case tổng quát phản ánh mối quan hệ giữa 4 tác nhân (Guest, Customer, Admin và VNPay Gateway) với các nhóm chức năng lớn của hệ thống:")
    add_landscape_diagram_page(doc, "diagrams/use-case-general.png", "Hình 3.1. Sơ đồ Use Case Tổng quát Hệ thống Lunara Silver", width_inches=10.2, max_height_inches=6.6)

    add_header(doc, "3.6. Sơ đồ Use Case Phân hệ Khách hàng", level=2)
    add_body(doc, "Phân hệ Khách hàng tập trung vào toàn bộ hành trình mua sắm từ khám phá trang chủ, tìm kiếm, lọc sản phẩm, quản lý giỏ hàng có thiệp viết tay, đặt hàng thanh toán và hậu mãi đánh giá:")
    add_landscape_diagram_page(doc, "diagrams/use-case-customer.png", "Hình 3.2. Sơ đồ Use Case Phân hệ Khách hàng (Storefront)", width_inches=10.2, max_height_inches=6.6)

    add_header(doc, "3.7. Sơ đồ Use Case Phân hệ Quản trị viên", level=2)
    add_body(doc, "Phân hệ Quản trị viên bao quát toàn bộ các chức năng giám sát KPI tài chính, điều phối đơn hàng, đối soát hoàn tiền VNPay, kiểm soát tồn kho và phân tích khách hàng 360:")
    add_landscape_diagram_page(doc, "diagrams/use-case-admin.png", "Hình 3.3. Sơ đồ Use Case Phân hệ Quản trị (Admin Portal)", width_inches=10.2, max_height_inches=6.6)

    add_header(doc, "3.8. Đặc tả Use Case Tiêu biểu", level=2)
    add_body(doc, "Dưới đây là 6 bảng đặc tả chi tiết cho các Use Case nghiệp vụ quan trọng nhất của hệ thống:")

    # Đặc tả 1: Đăng nhập
    headers_uc = ["Thuộc tính Use Case", "Nội dung đặc tả chi tiết"]
    rows_uc1 = [
        ["Tên Use Case", "Xác thực Đăng nhập Hệ thống (User / Admin Login)"],
        ["Tác nhân (Actor)", "Khách vãng lai (Guest), Khách hàng (Customer), Quản trị viên (Admin)"],
        ["Mục tiêu", "Xác thực danh tính người dùng, cấp quyền truy cập và gộp giỏ hàng phiên."],
        ["Tiền điều kiện", "Người dùng đã truy cập vào trang /login và tài khoản đã được kích hoạt."],
        ["Hậu điều kiện", "Phiên làm việc được thiết lập, giỏ hàng được gộp và điều hướng đến màn hình phù hợp."],
        ["Luồng chính", "1. Người dùng nhập Email, Mật khẩu và bấm nút 'Đăng nhập'.\n2. Hệ thống kiểm tra Rate Limiting (tối đa 5 lần thử sai trong 1 phút).\n3. Hệ thống xác thực mật khẩu qua Hash::check() với mã băm Bcrypt.\n4. Hệ thống tái tạo Session ID chống Session Fixation.\n5. Hệ thống gọi CartService::mergeGuestCartToUser() gộp giỏ hàng khách vào DB.\n6. Nếu tài khoản là Admin: Điều hướng sang /admin. Nếu là User: Điều hướng về /account."],
        ["Luồng ngoại lệ", "3a. Mật khẩu không đúng: Báo lỗi 'Thông tin đăng nhập không hợp lệ', ghi nhận số lần thử sai.\n2a. Vượt quá số lần thử sai: Khóa đăng nhập tạm thời trong 60 giây (HTTP 429 Throttle)."],
    ]
    create_table(doc, headers_uc, rows_uc1, [Inches(2.0), Inches(5.4)], caption="Bảng 3.3. Đặc tả Use Case: Xác thực Đăng nhập Hệ thống")

    # Đặc tả 2: Quản lý sản phẩm
    rows_uc2 = [
        ["Tên Use Case", "Quản lý Danh mục & Sản phẩm (Product & Category CRUD)"],
        ["Tác nhân (Actor)", "Quản trị viên (Admin)"],
        ["Mục tiêu", "Khởi tạo, cập nhật thông số, quản lý ảnh và xóa mềm sản phẩm trang sức."],
        ["Tiền điều kiện", "Quản trị viên đã đăng nhập và có quyền truy cập vào phân hệ /admin/products."],
        ["Hậu điều kiện", "Bản ghi sản phẩm được lưu vào CSDL, hình ảnh được đồng bộ lên Cloudinary."],
        ["Luồng chính", "1. Admin nhấp 'Thêm sản phẩm mới' tại bảng điều khiển sản phẩm.\n2. Admin nhập Tên, SKU, Danh mục, Loại sản phẩm (Single hoặc Bundle/Gift), Giá bán.\n3. Nếu là Single: Nhập số lượng tồn kho vật lý. Nếu là Bundle: Chọn các linh kiện con.\n4. Tải lên ảnh chính, ảnh di chuột (hover) và bộ sưu tập ảnh phụ lên Cloudinary.\n5. Admin bấm 'Lưu sản phẩm'. Hệ thống lưu dữ liệu và chuyển về danh sách."],
        ["Luồng ngoại lệ", "4a. Tệp ảnh vượt dung lượng cho phép (>5MB): Hệ thống báo lỗi và giữ lại form dữ liệu.\n5a. Mã SKU bị trùng lặp: Hệ thống thông báo lỗi vi phạm tính duy nhất."],
    ]
    create_table(doc, headers_uc, rows_uc2, [Inches(2.0), Inches(5.4)], caption="Bảng 3.4. Đặc tả Use Case: Quản lý Danh mục & Sản phẩm")

    # Đặc tả 3: Giỏ hàng
    rows_uc3 = [
        ["Tên Use Case", "Quản lý Giỏ hàng & Lời chúc Thiệp (Cart & Gift Experience)"],
        ["Tác nhân (Actor)", "Khách vãng lai (Guest), Khách hàng (Customer)"],
        ["Mục tiêu", "Quản lý các sản phẩm dự định mua, tùy chọn ghi chú thiệp viết tay và áp dụng coupon."],
        ["Tiền điều kiện", "Khách hàng đang xem trang chi tiết sản phẩm hoặc trang giỏ hàng."],
        ["Hậu điều kiện", "Giỏ hàng được cập nhật, tạm tính tổng tiền và lưu vết lời chúc quà tặng."],
        ["Luồng chính", "1. Khách hàng bấm 'Thêm vào giỏ hàng', có thể nhập lời chúc thiệp Lunara.\n2. Hệ thống kiểm tra số lượng tồn kho khả dụng qua OrderInventoryService.\n3. Nếu đủ hàng: Thêm sản phẩm vào giỏ, cập nhật Drawer giỏ hàng trượt qua AJAX.\n4. Khách hàng có thể tăng/giảm số lượng hoặc xóa món hàng.\n5. Khách nhập mã giảm giá: Hệ thống thẩm tra 7 tầng quy tắc và trừ chiết khấu."],
        ["Luồng ngoại lệ", "2a. Số lượng yêu cầu vượt quá tồn kho khả dụng: Báo lỗi 'Số lượng tồn kho không đủ'.\n5a. Mã coupon hết hạn hoặc chưa đạt giá trị đơn tối thiểu: Thông báo lý do từ chối cụ thể."],
    ]
    create_table(doc, headers_uc, rows_uc3, [Inches(2.0), Inches(5.4)], caption="Bảng 3.5. Đặc tả Use Case: Quản lý Giỏ hàng & Lời chúc Thiệp")

    # Đặc tả 4: Checkout
    rows_uc4 = [
        ["Tên Use Case", "Quy trình Đặt hàng (Checkout Flow & Concurrency Lock)"],
        ["Tác nhân (Actor)", "Khách hàng (Customer), Khách vãng lai (Guest)"],
        ["Mục tiêu", "Xác nhận mua hàng, thiết lập địa chỉ giao nhận và bảo đảm trừ tồn kho toàn vẹn."],
        ["Tiền điều kiện", "Giỏ hàng có ít nhất một sản phẩm hợp lệ."],
        ["Hậu điều kiện", "Đơn hàng được khởi tạo ở trạng thái Pending, tồn kho linh kiện được trừ an toàn."],
        ["Luồng chính", "1. Khách hàng vào trang /checkout, điền thông tin người nhận và địa chỉ giao hàng.\n2. Khách chọn phương thức thanh toán (COD hoặc Cổng VNPay).\n3. Khách bấm 'Xác nhận Đặt hàng'.\n4. Hệ thống mở Database Transaction, thực thi lockForUpdate() các dòng sản phẩm.\n5. Thẩm tra tồn kho lần cuối: Nếu đủ, tạo bản ghi Order, OrderItems và trừ tồn kho.\n6. Cam kết DB Commit giao dịch. Làm rỗng giỏ hàng và chuyển tiếp thanh toán."],
        ["Luồng ngoại lệ", "5a. Xảy ra xung đột đồng thời (Race Condition) làm sản phẩm hết hàng: DB Rollback toàn bộ và thông báo 'Sản phẩm vừa hết hàng do có người mua trước'."],
    ]
    create_table(doc, headers_uc, rows_uc4, [Inches(2.0), Inches(5.4)], caption="Bảng 3.6. Đặc tả Use Case: Quy trình Đặt hàng (Checkout)")

    # Đặc tả 5: VNPay
    rows_uc5 = [
        ["Tên Use Case", "Thanh toán Điện tử Cổng VNPay (Payment Lifecycle & QueryDr)"],
        ["Tác nhân (Actor)", "Khách hàng (Customer), Cổng VNPay (External Actor)"],
        ["Mục tiêu", "Thực hiện thanh toán trực tuyến an toàn qua chữ ký số và đối soát giao dịch kép."],
        ["Tiền điều kiện", "Đơn hàng đã được tạo thành công ở trạng thái Pending với phương thức VNPay."],
        ["Hậu điều kiện", "Giao dịch thanh toán hoàn tất, đơn hàng được cập nhật sang Paid/Processing."],
        ["Luồng chính", "1. Hệ thống tạo URL thanh toán chứa mã hash HMAC-SHA512 chuyển khách sang VNPay.\n2. Khách hàng thực hiện xác thực thẻ hoặc quét mã QR trên ứng dụng ngân hàng.\n3. VNPay trừ tiền tài khoản khách và chuyển hướng về Return URL của Lunara.\n4. Lunara kiểm tra chữ ký số vnp_SecureHash.\n5. Lunara phát lệnh Server-to-Server gọi API QueryDr sang VNPay đối soát.\n6. Khớp dữ liệu thành công: Cập nhật Payment completed, Order processing và gửi email."],
        ["Luồng ngoại lệ", "4a. Chữ ký số không khớp: Báo lỗi 'Giao dịch không hợp lệ' và giữ trạng thái pending.\n2a. Khách hủy giao dịch tại cổng VNPay: Chuyển về trang thông báo và cho phép 'Thử lại thanh toán'."],
    ]
    create_table(doc, headers_uc, rows_uc5, [Inches(2.0), Inches(5.4)], caption="Bảng 3.7. Đặc tả Use Case: Thanh toán Điện tử Cổng VNPay")

    # Đặc tả 6: Vận hành đơn hàng
    rows_uc6 = [
        ["Tên Use Case", "Vận hành & Đổi trạng thái Đơn hàng (Order State Lifecycle)"],
        ["Tác nhân (Actor)", "Quản trị viên (Admin)"],
        ["Mục tiêu", "Xử lý đơn hàng qua từng giai đoạn và phục hồi tồn kho an toàn khi hủy đơn."],
        ["Tiền điều kiện", "Admin đang mở chi tiết đơn hàng tại /admin/orders/{id}."],
        ["Hậu điều kiện", "Trạng thái đơn hàng được cập nhật, nhật ký kiểm toán được ghi vết."],
        ["Luồng chính", "1. Admin xem xét thông tin đơn hàng, địa chỉ giao nhận và ghi chú quà tặng.\n2. Admin chuyển trạng thái từ Pending sang Processing khi bắt đầu đóng gói.\n3. Admin chuyển sang Shipped khi bàn giao cho đơn vị vận chuyển phát nhanh.\n4. Admin chuyển sang Completed khi khách đã nhận hàng thành công.\n5. Mọi thay đổi đều được ghi nhật ký vào bảng order_status_histories."],
        ["Luồng ngoại lệ", "Admin hủy đơn (Cancelled): Hệ thống kích hoạt OrderInventoryService::restoreStock(), cộng trả lại tồn kho linh kiện và đóng dấu timestamp inventory_restored_at đúng 1 lần duy nhất."],
    ]
    create_table(doc, headers_uc, rows_uc6, [Inches(2.0), Inches(5.4)], caption="Bảng 3.8. Đặc tả Use Case: Vận hành & Đổi trạng thái Đơn hàng")

    add_header(doc, "3.9. Sơ đồ Hoạt động (Activity Diagrams)", level=2)
    add_body(doc, "Sơ đồ hoạt động quy trình Đặt hàng thể hiện chi tiết các bước thẩm tra giỏ hàng, áp dụng coupon, mở Transaction, thực hiện khóa bi quan (lockForUpdate) và rẽ nhánh COD / VNPay:")
    add_landscape_diagram_page(doc, "diagrams/activity-checkout.png", "Hình 3.4. Sơ đồ Hoạt động (Activity Diagram) Quy trình Đặt hàng", width_inches=10.2, max_height_inches=6.6)

    add_body(doc, "Sơ đồ hoạt động quy trình Thanh toán VNPay thể hiện cơ chế phản hồi hai kênh kép: Kênh 1 trình duyệt Return URL kích hoạt đối soát QueryDr máy chủ, và Kênh 2 Webhook IPN xử lý ngầm bất đồng bộ bảo đảm tính toàn vẹn tuyệt đối:")
    add_landscape_diagram_page(doc, "diagrams/activity-vnpay.png", "Hình 3.5. Sơ đồ Hoạt động (Activity Diagram) Thanh toán & Đối soát VNPay", width_inches=10.2, max_height_inches=6.6)

    add_header(doc, "3.10. Sơ đồ Tuần tự (Sequence Diagrams)", level=2)
    add_body(doc, "Sơ đồ tuần tự Đăng nhập tài khoản mô tả chi tiết quá trình thẩm định mật khẩu Bcrypt, tái tạo Session và tự động gộp các món trong giỏ hàng phiên của khách vãng lai vào giỏ hàng cơ sở dữ liệu của người dùng:")
    add_landscape_diagram_page(doc, "diagrams/sequence-login.png", "Hình 3.6. Sơ đồ Tuần tự (Sequence Diagram) Đăng nhập & Gộp Giỏ hàng", width_inches=10.2, max_height_inches=6.6)

    add_body(doc, "Sơ đồ tuần tự Quy trình Đặt hàng phản ánh mô hình kiến trúc phân lớp thực tế: Controller tiếp nhận yêu cầu, CheckoutService mở Transaction, gọi lockForUpdate() trên Eloquent Model và trừ tồn kho linh kiện an toàn:")
    add_landscape_diagram_page(doc, "diagrams/sequence-checkout.png", "Hình 3.7. Sơ đồ Tuần tự (Sequence Diagram) Đặt hàng với Pessimistic Locking", width_inches=10.2, max_height_inches=6.6)

    add_body(doc, "Sơ đồ tuần tự Thanh toán VNPay thể hiện luồng ký số HMAC-SHA512, khách hàng thực hiện trả tiền và hệ thống phát lệnh Server-to-Server gọi API QueryDr sang VNPay để đối soát:")
    add_landscape_diagram_page(doc, "diagrams/sequence-vnpay.png", "Hình 3.8. Sơ đồ Tuần tự (Sequence Diagram) Thanh toán Kép & QueryDr", width_inches=10.2, max_height_inches=6.6)

    add_header(doc, "3.11. Sơ đồ Thực thể Quan hệ (ERD Diagram)", level=2)
    add_body(doc, "Hệ thống cơ sở dữ liệu Lunara Silver bao gồm 35 bảng quan hệ được quản lý qua 17 tệp migrations. Dưới đây là sơ đồ thực thể quan hệ ERD tổng quan biểu diễn các thực thể cốt lõi và các mối liên kết đa chiều:")
    add_landscape_diagram_page(doc, "diagrams/erd-overview.png", "Hình 3.9. Sơ đồ Thực thể Quan hệ Tổng quan (ERD Diagram)", width_inches=10.2, max_height_inches=6.6)

    add_body(doc, "Sơ đồ thực thể chi tiết Phân hệ Sản phẩm & Tồn kho biểu diễn cấu trúc bảng products, categories, product_images và quan hệ cấu thành bộ combo quà tặng qua bảng product_bundle_items:")
    add_image_with_caption(doc, "diagrams/erd-catalog-inventory.png", "Hình 3.10. Sơ đồ Thực thể Chi tiết Phân hệ Sản phẩm & Tồn kho", width_inches=5.8)

    add_body(doc, "Sơ đồ thực thể chi tiết Phân hệ Đơn hàng & Thanh toán mô tả các bảng orders, order_items, payments, payment_refunds và coupon_usages, phục vụ theo dõi chính xác doanh thu, đối soát và hoàn tiền:")
    add_image_with_caption(doc, "diagrams/erd-orders-payments.png", "Hình 3.11. Sơ đồ Thực thể Chi tiết Phân hệ Đơn hàng & Thanh toán", width_inches=5.8)

    add_header(doc, "3.12. Thiết kế Cơ sở Dữ liệu Chi tiết", level=2)
    add_body(doc, "Dưới đây là cấu trúc chi tiết của 10 bảng cơ sở dữ liệu cốt lõi nhất trong hệ thống, được trích xuất trực tiếp từ các tệp migrations đang hoạt động:")

    # Table: users
    headers_db = ["Tên trường (Field)", "Kiểu dữ liệu (Type)", "Khóa (Key)", "Cho phép Null", "Mô tả ý nghĩa nghiệp vụ"]
    rows_users = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính tự tăng định danh người dùng."],
        ["name", "VARCHAR(255)", "", "No", "Họ và tên đầy đủ của người dùng."],
        ["email", "VARCHAR(255)", "Unique", "No", "Địa chỉ thư điện tử dùng để đăng nhập hệ thống."],
        ["password", "VARCHAR(255)", "", "No", "Mật khẩu đã được mã hóa băm một chiều Bcrypt."],
        ["role", "VARCHAR(20)", "", "No", "Vai trò người dùng ('user' hoặc 'admin'). Mặc định 'user'."],
        ["phone", "VARCHAR(20)", "", "Yes", "Số điện thoại liên hệ nhận hàng."],
        ["avatar", "VARCHAR(255)", "", "Yes", "Đường dẫn hình ảnh đại diện người dùng."],
        ["remember_token", "VARCHAR(100)", "", "Yes", "Mã ghi nhớ đăng nhập trình duyệt."],
        ["created_at / updated_at", "TIMESTAMP", "", "Yes", "Thời điểm khởi tạo và cập nhật bản ghi."],
    ]
    create_table(doc, headers_db, rows_users, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.9. Cấu trúc Bảng CSDL: users")

    # Table: categories
    rows_categories = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính tự tăng định danh danh mục."],
        ["parent_id", "BIGINT UNSIGNED", "FK", "Yes", "Khóa ngoại liên kết đệ quy tới chính danh mục cha."],
        ["name", "VARCHAR(255)", "", "No", "Tên danh mục (ví dụ: Dây chuyền, Nhẫn, Set Quà)."],
        ["slug", "VARCHAR(255)", "Unique", "No", "Đường dẫn thân thiện chuẩn SEO."],
        ["description", "TEXT", "", "Yes", "Mô tả chi tiết đặc tính của danh mục trang sức."],
        ["image", "VARCHAR(255)", "", "Yes", "Hình ảnh đại diện banner danh mục."],
        ["is_active", "TINYINT(1)", "", "No", "Trạng thái hiển thị (1: hiển thị, 0: tạm ẩn)."],
        ["display_order", "INT", "", "No", "Thứ tự sắp xếp ưu tiên hiển thị trên thanh menu."],
    ]
    create_table(doc, headers_db, rows_categories, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.10. Cấu trúc Bảng CSDL: categories")

    # Table: products
    rows_products = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính tự tăng định danh sản phẩm."],
        ["category_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại liên kết tới bảng categories."],
        ["sku", "VARCHAR(50)", "Unique", "No", "Mã quản lý kho duy nhất (ví dụ: LNS-NH001)."],
        ["name", "VARCHAR(255)", "", "No", "Tên thương mại của sản phẩm trang sức."],
        ["slug", "VARCHAR(255)", "Unique", "No", "Đường dẫn URL thân thiện chuẩn SEO."],
        ["product_type", "VARCHAR(20)", "Index", "No", "Loại sản phẩm: 'single' (đơn), 'collection' hoặc 'gift'."],
        ["price", "DECIMAL(12,2)", "", "No", "Giá bán niêm yết chính thức."],
        ["sale_price", "DECIMAL(12,2)", "", "Yes", "Giá khuyến mãi (nếu có chương trình giảm giá)."],
        ["stock_quantity", "INT", "", "No", "Số lượng tồn kho vật lý (chỉ dùng cho loại single)."],
        ["material", "VARCHAR(100)", "", "Yes", "Chất liệu chế tác (ví dụ: Bạc Ý 925 cao cấp)."],
        ["gemstone", "VARCHAR(100)", "", "Yes", "Loại đá quý đính kèm (ví dụ: Kim cương Moissanite, CZ)."],
        ["is_active", "TINYINT(1)", "Index", "No", "Trạng thái mở bán của sản phẩm."],
        ["deleted_at", "TIMESTAMP", "", "Yes", "Đánh dấu thời gian xóa mềm (Soft Delete)."],
    ]
    create_table(doc, headers_db, rows_products, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.11. Cấu trúc Bảng CSDL: products")

    # Table: bundle_items
    rows_bundle = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính tự tăng của quan hệ combo."],
        ["bundle_product_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại trỏ về sản phẩm cha (loại collection/gift)."],
        ["component_product_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại trỏ về sản phẩm con (loại single cấu thành)."],
        ["quantity", "INT", "", "No", "Số lượng linh kiện con cần thiết để tạo nên 1 bộ combo."],
    ]
    create_table(doc, headers_db, rows_bundle, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.12. Cấu trúc Bảng CSDL: bundle_items")

    # Table: orders
    rows_orders = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính tự tăng định danh đơn hàng."],
        ["order_code", "VARCHAR(50)", "Unique", "No", "Mã đơn hàng hiển thị (LNS-YYYYMMDD-XXXXX)."],
        ["user_id", "BIGINT UNSIGNED", "FK", "Yes", "Khóa ngoại trỏ tới users (Null nếu là khách vãng lai)."],
        ["customer_name", "VARCHAR(255)", "", "No", "Họ tên người nhận hàng."],
        ["customer_email", "VARCHAR(255)", "", "No", "Email nhận thông báo hóa đơn."],
        ["customer_phone", "VARCHAR(20)", "", "No", "Số điện thoại liên hệ giao hàng."],
        ["shipping_address", "TEXT", "", "No", "Địa chỉ giao nhận chi tiết."],
        ["subtotal", "DECIMAL(12,2)", "", "No", "Tổng tiền hàng trước khi áp dụng chiết khấu."],
        ["discount_amount", "DECIMAL(12,2)", "", "No", "Số tiền chiết khấu giảm giá từ coupon."],
        ["shipping_fee", "DECIMAL(12,2)", "", "No", "Phí vận chuyển giao hàng."],
        ["grand_total", "DECIMAL(12,2)", "", "No", "Tổng số tiền thực tế khách phải thanh toán."],
        ["payment_method", "VARCHAR(20)", "", "No", "Phương thức thanh toán: 'cod' hoặc 'vnpay'."],
        ["payment_status", "VARCHAR(20)", "", "No", "Trạng thái thanh toán: 'pending', 'paid', 'refunded'."],
        ["order_status", "VARCHAR(20)", "Index", "No", "Vòng đời đơn: 'pending', 'processing', 'shipped', 'completed', 'cancelled'."],
        ["inventory_restored_at", "TIMESTAMP", "", "Yes", "Đánh dấu thời gian đã hoàn kho (chống hoàn kho lặp)."],
    ]
    create_table(doc, headers_db, rows_orders, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.13. Cấu trúc Bảng CSDL: orders")

    # Table: order_items
    rows_order_items = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính tự tăng của dòng hàng."],
        ["order_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại liên kết tới đơn hàng orders."],
        ["product_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại trỏ tới sản phẩm mua."],
        ["product_name", "VARCHAR(255)", "", "No", "Snapshot lưu giữ tên sản phẩm tại thời điểm mua."],
        ["product_sku", "VARCHAR(50)", "", "No", "Snapshot mã SKU tại thời điểm mua."],
        ["unit_price", "DECIMAL(12,2)", "", "No", "Đơn giá sản phẩm tại thời điểm chốt đơn."],
        ["quantity", "INT", "", "No", "Số lượng mặt hàng đặt mua."],
        ["subtotal", "DECIMAL(12,2)", "", "No", "Thành tiền của dòng hàng (unit_price * quantity)."],
        ["gift_message", "TEXT", "", "Yes", "Lời chúc thiệp viết tay khách hàng đính kèm cho món này."],
    ]
    create_table(doc, headers_db, rows_order_items, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.14. Cấu trúc Bảng CSDL: order_items")

    # Table: payments
    rows_payments = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính định danh nỗ lực thanh toán."],
        ["order_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại liên kết tới orders."],
        ["transaction_id", "VARCHAR(100)", "", "Yes", "Mã giao dịch phát sinh từ phía cổng VNPay."],
        ["payment_method", "VARCHAR(20)", "", "No", "Phương thức thanh toán ('cod', 'vnpay')."],
        ["amount", "DECIMAL(12,2)", "", "No", "Số tiền yêu cầu thanh toán."],
        ["status", "VARCHAR(20)", "Index", "No", "Trạng thái nỗ lực: 'pending', 'completed', 'failed'."],
        ["vnp_response_code", "VARCHAR(10)", "", "Yes", "Mã phản hồi kết quả từ cổng VNPay (ví dụ: '00')."],
        ["last_queried_at", "TIMESTAMP", "", "Yes", "Thời điểm phát lệnh đối soát QueryDr gần nhất."],
    ]
    create_table(doc, headers_db, rows_payments, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.15. Cấu trúc Bảng CSDL: payments")

    # Table: payment_refunds
    rows_refunds = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính giao dịch hoàn tiền."],
        ["payment_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại liên kết tới payments."],
        ["refund_amount", "DECIMAL(12,2)", "", "No", "Số tiền thực tế được hoàn trả cho khách."],
        ["reason", "TEXT", "", "Yes", "Lý do hủy đơn và hoàn tiền."],
        ["status", "VARCHAR(20)", "Index", "No", "Trạng thái hoàn tiền: 'pending', 'completed', 'failed'."],
        ["vnp_refund_response", "TEXT", "", "Yes", "Toàn bộ chuỗi JSON phản hồi từ API hoàn tiền VNPay."],
    ]
    create_table(doc, headers_db, rows_refunds, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.16. Cấu trúc Bảng CSDL: payment_refunds")

    # Table: coupons
    rows_coupons = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính định danh mã giảm giá."],
        ["code", "VARCHAR(50)", "Unique", "No", "Ký tự mã khuyến mãi khách hàng nhập (ví dụ: LUNARA10)."],
        ["discount_type", "VARCHAR(20)", "", "No", "Loại giảm giá: 'percentage' (%) hoặc 'fixed' (tiền cố định)."],
        ["discount_value", "DECIMAL(12,2)", "", "No", "Giá trị giảm (tỷ lệ phần trăm hoặc số tiền VNĐ)."],
        ["max_discount_amount", "DECIMAL(12,2)", "", "Yes", "Số tiền chiết khấu tối đa cho loại percentage."],
        ["min_order_amount", "DECIMAL(12,2)", "", "Yes", "Giá trị đơn hàng tối thiểu để được áp dụng."],
        ["usage_limit", "INT", "", "Yes", "Tổng số lượt sử dụng tối đa của mã trên toàn hệ thống."],
        ["usage_limit_per_user", "INT", "", "Yes", "Số lượt tối đa 1 người dùng được sử dụng mã này."],
        ["used_count", "INT", "", "No", "Số lượt mã đã được áp dụng thành công."],
        ["starts_at / expires_at", "DATETIME", "", "Yes", "Khung thời gian có hiệu lực của mã giảm giá."],
        ["is_active", "TINYINT(1)", "", "No", "Trạng thái kích hoạt (1: đang mở, 0: tạm khóa)."],
    ]
    create_table(doc, headers_db, rows_coupons, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.17. Cấu trúc Bảng CSDL: coupons")

    # Table: reviews
    rows_reviews = [
        ["id", "BIGINT UNSIGNED", "PK", "No", "Khóa chính định danh đánh giá."],
        ["product_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại liên kết tới sản phẩm products."],
        ["user_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại liên kết tới khách hàng users."],
        ["order_item_id", "BIGINT UNSIGNED", "FK", "No", "Khóa ngoại duy nhất ràng buộc dòng hàng đã mua."],
        ["rating", "TINYINT UNSIGNED", "", "No", "Số sao đánh giá chất lượng (từ 1 đến 5 sao)."],
        ["comment", "TEXT", "", "Yes", "Nội dung nhận xét trải nghiệm sản phẩm."],
        ["status", "VARCHAR(20)", "Index", "No", "Trạng thái kiểm duyệt: 'pending', 'approved', 'rejected'."],
        ["merchant_reply", "TEXT", "", "Yes", "Nội dung phản hồi chính thức từ thương hiệu Lunara."],
    ]
    create_table(doc, headers_db, rows_reviews, [Inches(1.5), Inches(1.5), Inches(0.8), Inches(1.1), Inches(2.5)], caption="Bảng 3.18. Cấu trúc Bảng CSDL: reviews")

    add_header(doc, "3.13. Quan hệ giữa các bảng và Nguyên tắc toàn vẹn dữ liệu", level=2)
    add_body(doc, "Cơ sở dữ liệu của Lunara Silver được thiết kế tuân thủ nghiêm ngặt các nguyên tắc toàn vẹn dữ liệu của hệ quản trị cơ sở dữ liệu quan hệ:")
    add_bullet(doc, "Tất cả các bảng đều sử dụng khóa chính dạng số nguyên tự tăng BIGINT UNSIGNED đảm bảo tính duy nhất và hiệu năng chỉ mục B-Tree tối ưu.", "1. Toàn vẹn thực thể (Entity Integrity): ")
    add_bullet(doc, "Khóa ngoại (Foreign Keys) được thiết lập giữa tất cả các bảng có quan hệ cha - con kèm quy tắc hành vi ON DELETE RESTRICT hoặc CASCADE phù hợp, ngăn chặn triệt để tình trạng mồ côi dữ liệu (orphan records).", "2. Toàn vẹn tham chiếu (Referential Integrity): ")
    add_bullet(doc, "Các trường dữ liệu đều có ràng buộc kiểu, độ dài và các chỉ mục duy nhất (Unique Indexes) trên các trường như users.email, products.sku, categories.slug, orders.order_code và coupons.code.", "3. Toàn vẹn miền giá trị (Domain Integrity): ")
    add_bullet(doc, "Bảng reviews có ràng buộc UNIQUE trên order_item_id, bảo đảm mỗi món hàng khách đã mua chỉ được phép gửi đánh giá một lần duy nhất, ngăn chặn hoàn toàn hiện tượng spam hoặc tạo đánh giá giả.", "4. Ràng buộc nghiệp vụ đặc thù: ")

    doc.add_page_break()

    # =========================================================================
    # CHƯƠNG 4. XÂY DỰNG VÀ TRIỂN KHAI HỆ THỐNG
    # =========================================================================
    add_header(doc, "CHƯƠNG 4. XÂY DỰNG VÀ TRIỂN KHAI HỆ THỐNG", level=1)
    
    add_header(doc, "4.1. Môi trường phát triển & Cấu trúc thư mục mã nguồn", level=2)
    add_body(doc, "Dự án Lunara Silver được phát triển và vận hành trên môi trường máy chủ địa phương với các thông số kỹ thuật chuẩn:")
    add_bullet(doc, "Hệ điều hành Windows 11 64-bit, gói phần mềm máy chủ tích hợp XAMPP.", "Môi trường OS & Server: ")
    add_bullet(doc, "PHP phiên bản 8.2.12 (CLI / CGI) với đầy đủ các phần mở rộng bắt buộc: pdo_mysql, mbstring, openssl, curl, gd, fileinfo.", "Môi trường thực thi: ")
    add_bullet(doc, "Hệ quản trị CSDL MariaDB 10.4.32 tương thích chuẩn MySQL 8.0, cấu hình Engine InnoDB mặc định.", "Cơ sở dữ liệu: ")
    add_bullet(doc, "Node.js v20.x kết hợp npm đóng gói tài nguyên frontend qua Vite 7.3.6.", "Môi trường Frontend: ")
    add_body(doc, "Cấu trúc thư mục dự án tuân thủ tiêu chuẩn của Laravel Framework với các phân vùng chức năng rõ ràng:")
    add_bullet(doc, "Chứa 29 Eloquent Models định nghĩa quan hệ và Scopes truy vấn.", "app/Models/: ")
    add_bullet(doc, "Chứa 27 Service Domain Classes xử lý toàn bộ các giải thuật nghiệp vụ trọng yếu.", "app/Services/: ")
    add_bullet(doc, "Chứa 37 Controllers điều phối luồng HTTP, chia tách Storefront và Admin.", "app/Http/Controllers/: ")
    add_bullet(doc, "Chứa 17 migration files thiết lập cấu trúc 35 bảng CSDL và CatalogSeeder nạp dữ liệu.", "database/: ")
    add_bullet(doc, "Chứa các mẫu giao diện Blade, chia tách Storefront layouts, admin layouts và customer tabs.", "resources/views/: ")

    add_header(doc, "4.2. Danh mục Modules Đạt Chuẩn Full CRUD", level=2)
    add_body(doc, "Hệ thống Lunara Silver phân định rõ ràng giữa các phân hệ đạt chuẩn Full CRUD (hỗ trợ đầy đủ 4 thao tác Tạo mới - Create, Xem - Read, Cập nhật - Update, Xóa - Delete) và các luồng nghiệp vụ vòng đời (Business Workflows). Bảng dưới đây tổng hợp 7 module Full CRUD đã được kiểm toán trực tiếp:")

    headers_crud = ["Thực thể CRUD", "Tạo (Create)", "Đọc (Read)", "Sửa (Update)", "Xóa (Delete)", "Controller phụ trách", "Model & Quan hệ"]
    rows_crud = [
        ["Product", "Form thêm mới", "Lưới danh sách", "Form chỉnh sửa", "Xóa mềm (SoftDeletes)", "Admin\\ProductController", "Product (belongsTo Category, hasMany Images)"],
        ["Category", "Form thêm mới", "Cây danh mục", "Form chỉnh sửa", "Xóa (chặn nếu có con)", "Admin\\CategoryController", "Category (hasMany Products, parent/children)"],
        ["Post (Blog)", "Form soạn thảo", "Danh sách bài", "Cập nhật bài", "Xóa vĩnh viễn", "Admin\\PostController", "Post (belongsTo PostCategory, sanitizeHtml)"],
        ["PostCategory", "Form thêm mới", "Danh sách", "Form chỉnh sửa", "Xóa danh mục tin", "Admin\\PostCategoryController", "PostCategory (hasMany Posts)"],
        ["Faq", "Form tạo câu hỏi", "Danh sách FAQ", "Cập nhật nội dung", "Xóa câu hỏi", "Admin\\FaqController", "Faq (độc lập)"],
        ["Coupon", "Form tạo mã 7 tầng", "Danh sách lọc", "Cập nhật hạn mức", "Xóa (nếu chưa dùng)", "Admin\\CouponController", "Coupon (hasMany CouponUsages)"],
        ["Address", "Form thêm địa chỉ", "Sổ địa chỉ", "Cập nhật địa chỉ", "Xóa địa chỉ", "Account\\AddressController", "Address (belongsTo User, OrderPolicy)"],
    ]
    create_table(doc, headers_crud, rows_crud, [Inches(0.85), Inches(0.85), Inches(0.80), Inches(0.85), Inches(0.85), Inches(1.05), Inches(1.00)], caption="Bảng 4.1. Danh mục Các Module Đạt Chuẩn Full CRUD trong Hệ thống")

    add_header(doc, "4.3. Giao diện Trang chủ & Khám phá Danh mục Sản phẩm", level=2)
    add_body(doc, "Trang chủ Lunara Silver được thiết kế theo phong cách mỹ thuật Celestial Luxury Minimalism với bảng màu ánh trăng đặc trưng: Tông màu Midnight (#1A1C2C) tạo chiều sâu cho Header và Footer, tông Mauve (#B8A7B7) làm điểm nhấn và Ivory/Cream (#F7F5F2) làm nền trưng bày sản phẩm sang trọng.")
    add_image_with_caption(doc, "screenshots/ui-homepage.png", "Hình 4.1. Giao diện Trang chủ Thương hiệu Trang sức Lunara Silver", width_inches=6.0)

    add_body(doc, "Trang danh mục sản phẩm (/products) cung cấp lưới hiển thị sản phẩm phân trang kết hợp thanh công cụ lọc đa tiêu chí bên trái, cho phép khách hàng lọc linh hoạt theo loại trang sức, chất liệu bạc, loại đá quý đính kèm và khoảng giá:")
    add_image_with_caption(doc, "screenshots/ui-catalog.png", "Hình 4.2. Danh mục Sản phẩm & Bộ lọc Đa tiêu chí", width_inches=6.0)

    add_header(doc, "4.4. Tìm kiếm Gợi ý Tức thời & Trang Chi tiết Sản phẩm", level=2)
    add_body(doc, "Hệ thống hỗ trợ tính năng Live Search Suggestions: Khi khách hàng gõ từ khóa vào thanh tìm kiếm, JavaScript sẽ kích hoạt cơ chế Debounce 300ms và sử dụng AbortController để hủy các truy vấn mạng trễ, trả về danh sách gợi ý sản phẩm và giá tức thời mà không cần nạp lại trang:")
    add_image_with_caption(doc, "screenshots/ui-search.png", "Hình 4.3. Tìm kiếm Gợi ý Thời gian thực (Live Search)", width_inches=5.8)

    add_body(doc, "Trang chi tiết sản phẩm (/product/{slug}) cung cấp bộ sưu tập hình ảnh đa góc nhìn với hiệu ứng di chuột chuyển ảnh (Hover Image Swap), thông số kỹ thuật chi tiết của bạc 925, tình trạng tồn kho khả dụng và accordion chính sách bảo hành, làm sáng bạc miễn phí:")
    add_image_with_caption(doc, "screenshots/ui-product-detail.png", "Hình 4.4. Trang Chi tiết Sản phẩm & Gallery Đa góc nhìn", width_inches=6.0)

    add_header(doc, "4.5. Giải thuật Quản lý Tồn kho Bộ Quà tặng Combo (Bundle Inventory Engine)", level=2)
    add_body(doc, "Một trong những đóng góp kỹ thuật nổi bật nhất của đề tài là Giải thuật Tồn kho Ảo (Dynamic Virtual Inventory Engine) giải quyết bài toán bán combo trong ngành trang sức quà tặng.")
    add_body(doc, "Sản phẩm trong Lunara Silver được phân loại thành 3 nhóm:")
    add_bullet(doc, "Có số lượng tồn kho vật lý thực tế được lưu trực tiếp trong trường stock_quantity.", "Sản phẩm Đơn lẻ ('single'): ")
    add_bullet(doc, "Tập hợp kết hợp nhiều sản phẩm đơn lẻ (ví dụ: Bộ sưu tập Dây chuyền + Nhẫn).", "Bộ sưu tập ('collection'): ")
    add_bullet(doc, "Bộ hộp quà cao cấp bao gồm các sản phẩm lẻ cùng phụ kiện đóng gói.", "Hộp quà tặng ('gift'): ")
    add_body(doc, "Quy tắc cốt lõi: Sản phẩm combo/gift set không bao giờ lưu trữ số lượng tồn kho cố định mà được thuật toán tính toán động tại thời điểm truy vấn theo công thức toán học:")
    add_body(doc, "Available Quantity = min_i ( floor( Component_Stock_i / Required_Quantity_i ) )", bold_prefix="Công thức giải thuật: ", italic=True)
    add_body(doc, "Ví dụ thực tế: Set quà tặng 'Tình Yêu Vĩnh Cửu' gồm 1 Dây chuyền (kho còn 8 chiếc), 1 Nhẫn Moissanite (kho còn 3 chiếc) và 1 Đôi Hoa Tai (kho còn 5 đôi). Tồn kho khả dụng của Set quà sẽ bằng min(8, 3, 5) = 3 bộ (bị chặn bởi Nhẫn). Khi khách đặt mua 1 Set quà, hệ thống tự động trừ kho của từng linh kiện con tương ứng, bảo đảm tuyệt đối không bao giờ xảy ra tình trạng bán vượt số lượng tồn thực tế.")
    add_image_with_caption(doc, "diagrams/bundle-inventory-example.png", "Hình 4.5. Sơ đồ Minh họa Giải thuật Tồn kho Khả dụng Bộ Quà tặng Combo", width_inches=5.8)

    add_body(doc, "Hình ảnh dưới đây minh họa giao diện trang chi tiết một bộ quà tặng trên website, hiển thị rõ ràng danh sách các linh kiện thành phần cấu thành bên trong:")
    add_image_with_caption(doc, "screenshots/ui-bundle-detail.png", "Hình 4.6. Chi tiết Bộ Quà Tặng & Danh sách Linh kiện Thành phần", width_inches=6.0)

    add_header(doc, "4.6. Trải nghiệm Giỏ hàng & Cá nhân hóa Thiệp Quà tặng", level=2)
    add_body(doc, "Giỏ hàng Lunara Silver được thiết kế theo dạng ngăn kéo trượt (Mini Cart Drawer) và trang giỏ hàng chuyên biệt (/cart). Người dùng có thể cập nhật số lượng hoặc xóa sản phẩm mượt mà qua AJAX Fetch API. Giỏ hàng tích hợp thanh tiến trình miễn phí vận chuyển toàn quốc (khi đơn hàng trên 500.000₫) và ô ghi chú lời chúc thiệp Lunara viết tay:")
    add_image_with_caption(doc, "screenshots/ui-cart.png", "Hình 4.7. Giao diện Giỏ hàng & Cá nhân hóa Thiệp Quà tặng", width_inches=6.0)

    add_header(doc, "4.7. Quy trình Đặt hàng & Phòng chống Xung đột Đồng thời (Pessimistic Locking)", level=2)
    add_body(doc, "Tại trang Checkout (/checkout), khách hàng nhập thông tin giao nhận, áp dụng mã coupon và lựa chọn phương thức thanh toán COD hoặc Cổng VNPay:")
    add_image_with_caption(doc, "screenshots/ui-checkout.png", "Hình 4.8. Trang Đặt hàng & Lựa chọn Cổng Thanh toán", width_inches=6.0)

    add_body(doc, "Để bảo vệ dữ liệu khi có nhiều khách hàng cùng thanh toán món hàng cuối cùng, phương thức process() trong CheckoutService mở một Database Transaction và thực hiện câu lệnh:")
    add_body(doc, "Product::whereIn('id', $productIds)->lockForUpdate()->get();", bold_prefix="Đoạn mã kỹ thuật: ", italic=True)
    add_body(doc, "Cơ chế khóa bi quan này buộc cơ sở dữ liệu phải xếp hàng các tiến trình checkout đồng thời, ngăn chặn triệt để tình trạng Race Condition bán âm kho hàng.")

    add_header(doc, "4.8. Cổng Thanh toán Điện tử VNPay & Cơ chế Đối soát Kép", level=2)
    add_body(doc, "Tích hợp cổng VNPay Sandbox áp dụng thuật toán mã hóa chữ ký số HMAC-SHA512. Để giải quyết triệt để vấn đề mạng chập chờn hoặc khách hàng đóng trình duyệt trước khi chuyển về, hệ thống triển khai cơ chế đối soát kép hai kênh:")
    add_bullet(doc, "Khi khách hoàn tất giao dịch trên VNPay và quay lại URL này, hệ thống kiểm tra chữ ký băm vnp_SecureHash. Nếu hợp lệ, hệ thống không vội vàng tin tưởng ngay mà chủ động phát lệnh Server-to-Server gọi sang API QueryDr của VNPay (PaymentReconciliationService::queryDrReconciliation()) để đối soát trạng thái thực tế từ máy chủ ngân hàng.", "Kênh 1 - Return URL kết hợp QueryDr: ")
    add_bullet(doc, "Máy chủ VNPay gửi thông báo ngầm độc lập về webhook /payment/vnpay/ipn. Hệ thống kiểm tra tính duy nhất (Idempotency) để bảo đảm giao dịch chỉ được cập nhật đúng một lần.", "Kênh 2 - Server-to-Server IPN Webhook: ")

    add_header(doc, "4.9. Máy Trạng thái Đơn hàng & Phục hồi Tồn kho An toàn", level=2)
    add_body(doc, "Vòng đời đơn hàng được quản lý chặt chẽ qua máy trạng thái (Order State Machine):")
    add_bullet(doc, "Pending -> Processing -> Shipped -> Completed.", "Luồng xử lý thành công: ")
    add_bullet(doc, "Khách hàng hủy (khi đơn chưa giao) hoặc Admin hủy: Đơn chuyển sang Cancelled.", "Luồng hủy đơn: ")
    add_body(doc, "Điểm mấu chốt: Khi đơn hàng chuyển sang Cancelled, hệ thống kích hoạt hàm restoreStock() trong OrderInventoryService để cộng hoàn trả lại tồn kho cho các sản phẩm con. Để ngăn chặn lỗi hoàn kho lặp lại nhiều lần nếu Admin bấm hủy nhiều lần, hệ thống sử dụng trường inventory_restored_at làm cờ đánh dấu kiểm tra (Idempotent Restoration):")
    add_image_with_caption(doc, "diagrams/order-state-machine.png", "Hình 4.9. Sơ đồ Máy Trạng thái Vòng đời Đơn hàng & Phục hồi Tồn kho An toàn", width_inches=6.0)

    add_body(doc, "Hình ảnh dưới đây minh họa giao diện Hóa đơn điện tử sau khi đặt hàng thành công, hiển thị mã đơn hàng LNS-YYYYMMDD-XXXXX và tiến trình xử lý:")
    add_image_with_caption(doc, "screenshots/ui-order-tracking.png", "Hình 4.10. Hóa đơn Điện tử & Theo dõi Vòng đời Đơn hàng", width_inches=6.0)

    add_header(doc, "4.10. Hệ thống Khuyến mãi 7 Tầng Thẩm định (Coupons)", level=2)
    add_body(doc, "Hệ thống mã giảm giá (CouponService) áp dụng quy trình thẩm định 7 tầng nghiêm ngặt trước khi chấp nhận khấu trừ tiền đơn hàng:")

    headers_cp = ["Tầng kiểm tra", "Điều kiện thẩm định", "Hành vi hệ thống nếu vi phạm"]
    rows_cp = [
        ["Tầng 1: Kích hoạt", "Mã phải có is_active = 1", "Từ chối: Mã giảm giá đang tạm khóa."],
        ["Tầng 2: Thời hạn", "starts_at <= now() <= expires_at", "Từ chối: Mã chưa bắt đầu hoặc đã hết hạn."],
        ["Tầng 3: Giá trị tối thiểu", "subtotal >= min_order_amount", "Từ chối: Chưa đạt giá trị đơn hàng tối thiểu."],
        ["Tầng 4: Giới hạn toàn sàn", "used_count < usage_limit", "Từ chối: Mã giảm giá đã hết lượt sử dụng."],
        ["Tầng 5: Giới hạn cá nhân", "user_usage < usage_limit_per_user", "Từ chối: Bạn đã dùng hết số lượt của mã này."],
        ["Tầng 6: Khách hàng mới", "Chỉ áp dụng nếu user chưa có đơn nào", "Từ chối: Mã chỉ dành cho đơn hàng đầu tiên."],
        ["Tầng 7: Hạn mức tối đa", "Chiết khấu % không vượt max_discount", "Tự động chặn số tiền giảm ở mức trần tối đa."],
    ]
    create_table(doc, headers_cp, rows_cp, [Inches(1.5), Inches(2.5), Inches(3.2)], caption="Bảng 4.2. Quy tắc 7 Tầng Thẩm định Mã Giảm Giá (Coupon Validation Rules)")

    add_header(doc, "4.11. Đánh giá Có Xác thực Mua hàng (Verified Purchase Reviews)", level=2)
    add_body(doc, "Để bảo vệ uy tín thương hiệu, Lunara Silver xây dựng cơ chế đánh giá chống gian lận:")
    add_bullet(doc, "Chỉ khách hàng sở hữu đơn hàng đã hoàn tất (Completed) và chứa đúng sản phẩm đó mới được phép viết nhận xét.", "Ràng buộc mua hàng thực tế: ")
    add_bullet(doc, "Mỗi order_item_id chỉ được tạo duy nhất một đánh giá (khóa Unique).", "Chống spam đánh giá: ")
    add_bullet(doc, "Tên khách hàng được tự động che giấu ký tự giữa (ví dụ: N***n) trên giao diện công khai.", "Bảo vệ quyền riêng tư: ")
    add_bullet(doc, "Khách hàng có thể tải lên ảnh thực tế của trang sức lên đám mây Cloudinary.", "Minh chứng ảnh thật: ")
    add_bullet(doc, "Đánh giá mới tạo ở trạng thái Pending, phải qua hàng chờ kiểm duyệt của Quản trị viên mới xuất hiện trên trang sản phẩm.", "Kiểm duyệt thương hiệu: ")

    add_header(doc, "4.12. Bảng Điều khiển Trung tâm & Các Chỉ số KPI Tài chính (Admin Dashboard)", level=2)
    add_body(doc, "Admin Dashboard (/admin) cung cấp bức tranh toàn cảnh về hoạt động kinh doanh với 4 thẻ KPI tài chính và hàng chờ việc cần xử lý ngay (Attention Required):")
    add_image_with_caption(doc, "screenshots/admin-dashboard.png", "Hình 4.11. Bảng điều khiển Trung tâm & Các chỉ số KPI Tài chính", width_inches=6.0)

    add_body(doc, "Các chỉ số tài chính được tính toán theo công thức chuẩn mực kinh tế trong AnalyticsService:")
    headers_kpi = ["Chỉ số KPI", "Công thức tính toán chuẩn xác", "Ý nghĩa quản trị kinh doanh"]
    rows_kpi = [
        ["Doanh thu Gộp (Gross Sales)", "SUM(grand_total) của các đơn không bị Cancelled", "Tổng giá trị đơn hàng khách đã phát sinh."],
        ["Số tiền Hoàn lại (Refund Amount)", "SUM(refund_amount) của các giao dịch hoàn thành", "Tổng số tiền đã hoàn trả cho khách do hủy/trả hàng."],
        ["Doanh thu Thuần (Net Revenue)", "Gross Sales - Refund Amount", "Doanh thu thực tế doanh nghiệp giữ lại được."],
        ["Giá trị Đơn trung bình (AOV)", "Gross Sales / Số lượng đơn hàng hợp lệ", "Mức chi tiêu trung bình của một khách hàng trên một đơn."],
        ["Số lượng Sản phẩm bán (Units Sold)", "SUM(quantity) của tất cả order_items hợp lệ", "Tổng số lượng trang sức vật lý đã bán ra."],
    ]
    create_table(doc, headers_kpi, rows_kpi, [Inches(2.0), Inches(2.6), Inches(2.6)], caption="Bảng 4.3. Công thức Tính toán Chỉ số KPI Tài chính trên Dashboard")

    add_header(doc, "4.13. Thanh Tìm kiếm Nhanh Command Palette (Ctrl + K)", level=2)
    add_body(doc, "Để hỗ trợ người vận hành tra cứu tức thời, hệ thống xây dựng thanh Command Palette kích hoạt bằng tổ hợp phím Ctrl + K với tính năng định tuyến ý định thông minh dựa trên tiền tố:")
    add_bullet(doc, "Gõ tiền tố 'LNS-' -> Hệ thống chỉ tìm kiếm trên bảng Đơn hàng (Orders).", "Tiền tố Đơn hàng: ")
    add_bullet(doc, "Gõ tiền tố '@' -> Hệ thống chỉ tìm kiếm trên bảng Khách hàng (Customers).", "Tiền tố Khách hàng: ")
    add_bullet(doc, "Gõ tiền tố SKU trang sức ('NH-', 'DC-', 'VT-') -> Hệ thống chỉ tìm kiếm trên bảng Sản phẩm (Products).", "Tiền tố Sản phẩm: ")
    add_image_with_caption(doc, "screenshots/admin-command-palette.png", "Hình 4.12. Thanh Điều hướng Nhanh Command Palette (Ctrl+K)", width_inches=5.8)

    add_header(doc, "4.14. Phân hệ Quản trị Sản phẩm & Danh mục (Admin Product & Category)", level=2)
    add_body(doc, "Giao diện quản lý danh sách sản phẩm (/admin/products) cho phép lọc theo danh mục, lọc theo phân loại Single/Bundle và quản lý tình trạng kích hoạt:")
    add_image_with_caption(doc, "screenshots/admin-products.png", "Hình 4.13. Bảng Quản trị Sản phẩm & Điều phối Tồn kho", width_inches=6.0)

    add_body(doc, "Biểu mẫu thêm mới và cập nhật sản phẩm hỗ trợ thiết lập đầy đủ thông số chất liệu bạc 925, chọn các linh kiện con cho bộ quà tặng và tải lên nhiều góc ảnh đồng thời:")
    add_image_with_caption(doc, "screenshots/admin-product-create.png", "Hình 4.14. Biểu mẫu Khởi tạo & Cấu hình Sản phẩm", width_inches=6.0)

    add_body(doc, "Quản trị danh mục sản phẩm phân cấp (/admin/categories) với cơ chế bảo vệ toàn vẹn: Không cho phép xóa danh mục cha nếu vẫn còn danh mục con hoặc còn sản phẩm liên kết:")
    add_image_with_caption(doc, "screenshots/admin-categories.png", "Hình 4.15. Quản trị Danh mục Sản phẩm Phân cấp", width_inches=6.0)

    add_header(doc, "4.15. Phân hệ Vận hành Đơn hàng, Đối soát & Hoàn tiền (Admin Orders)", level=2)
    add_body(doc, "Bảng danh sách đơn hàng (/admin/orders) hỗ trợ bộ lọc trạng thái vận hành, phương thức thanh toán và thời gian tạo đơn:")
    add_image_with_caption(doc, "screenshots/admin-orders.png", "Hình 4.16. Danh sách Quản lý Đơn hàng & Bộ lọc Vận hành", width_inches=6.0)

    add_body(doc, "Trang chi tiết đơn hàng (/admin/orders/{id}) cung cấp các nút thao tác đặc quyền: Nút Đối soát VNPay (gọi QueryDr theo thời gian thực) và nút Hoàn tiền trực tuyến tự động qua API khi cần hủy đơn:")
    add_image_with_caption(doc, "screenshots/admin-order-detail.png", "Hình 4.17. Chi tiết Vận hành Đơn hàng, Đối soát & Hoàn tiền", width_inches=6.0)

    add_header(doc, "4.16. Hồ sơ Khách hàng 360 & Kiến trúc Tab Tải Lười (Customer 360 Lazy Tabs)", level=2)
    add_body(doc, "Danh sách khách hàng (/admin/customers) được tối ưu hóa truy vấn bằng kỹ thuật leftJoinSub, gom nhóm đơn hàng và hoàn tiền chỉ trong 2 câu truy vấn duy nhất, loại bỏ hoàn toàn 5 câu truy vấn con tương quan trên từng dòng:")
    add_image_with_caption(doc, "screenshots/admin-customers.png", "Hình 4.18. Danh sách Khách hàng & Thống kê Tương tác", width_inches=6.0)

    add_body(doc, "Màn hình Hồ sơ Khách hàng 360 (/admin/customers/{id}) áp dụng kiến trúc Tab Tải Lười (Lazy Tabs) qua AJAX. Trang ban đầu chỉ nạp thông tin tóm tắt và số lượng đếm của các tab, giúp thời gian phản hồi đạt dưới 20ms. Khi Admin nhấp vào từng Tab (Đơn hàng, Đánh giá, Hỗ trợ, Coupon, Sổ địa chỉ), hệ thống mới nạp dữ liệu chi tiết tương ứng và lưu bộ đệm trình duyệt:")
    add_image_with_caption(doc, "screenshots/admin-customer-360.png", "Hình 4.19. Hồ sơ Khách hàng 360 & Kiến trúc Tab Tải lười", width_inches=6.0)

    add_header(doc, "4.17. Quản lý Mã Giảm Giá & Kiểm duyệt Đánh giá (Coupons & Reviews)", level=2)
    add_body(doc, "Giao diện quản lý mã giảm giá (/admin/coupons) cho phép cấu hình chi tiết 7 tầng quy tắc chiết khấu:")
    add_image_with_caption(doc, "screenshots/admin-coupons.png", "Hình 4.20. Quản lý Mã Giảm Giá & Thiết lập Quy tắc Khuyến mãi", width_inches=6.0)

    add_body(doc, "Hàng chờ kiểm duyệt đánh giá (/admin/reviews) hiển thị huy hiệu Verified Purchase, hình ảnh đính kèm của khách và cho phép Quản trị viên nhập phản hồi chính thức từ thương hiệu:")
    add_image_with_caption(doc, "screenshots/admin-reviews.png", "Hình 4.21. Hàng chờ Kiểm duyệt Đánh giá Khách hàng", width_inches=6.0)

    add_header(doc, "4.18. Tối ưu Hiệu năng, Xuất Báo cáo Luồng & Bảo mật Hệ thống", level=2)
    add_body(doc, "Hệ thống áp dụng các kỹ thuật tối ưu hóa và bảo vệ dữ liệu chuyên sâu:")
    add_bullet(doc, "Dịch vụ ExportService sử dụng chunkById(200) và StreamedResponse, xuất hàng ngàn dòng hóa đơn CSV trực tiếp ra luồng mạng mà mức tiêu thụ bộ nhớ RAM máy chủ luôn duy trì dưới 16MB.", "Xuất báo cáo theo luồng (Streaming CSV): ")
    add_bullet(doc, "Cơ chế Purifier danh sách trắng trong Post::sanitizeHtml() loại bỏ toàn bộ thẻ script và iframe độc hại khi biên tập tin tức.", "Chống tấn công XSS: ")
    add_bullet(doc, "Middleware bổ sung tiêu đề X-Frame-Options: SAMEORIGIN ngăn chặn tấn công chèn khung lừa đảo, X-Content-Type-Options: nosniff chống tấn công sniffing MIME.", "Tiêu đề an toàn HTTP: ")

    add_header(doc, "4.19. Triển khai Hệ thống trên Hosting Sản xuất (InfinityFree Hosting)", level=2)
    add_body(doc, "Để chứng minh khả năng hoạt động thực tế trên mạng Internet công cộng, hệ thống Lunara Silver đã được đóng gói và phát hành thành công lên hạ tầng máy chủ trực tuyến:")
    add_bullet(doc, "https://lunarasilver.infinityfreeapp.com", "Địa chỉ website hoạt động chính thức: ")
    add_bullet(doc, "Quy trình phát hành tự động qua kịch bản FTP Python (scripts/deploy_direct.py), tự động tải lên mã nguồn Laravel tối ưu, các tệp tài nguyên Vite đã biên dịch tại public/build/, tệp cấu hình môi trường .env sản xuất và đồng bộ CSDL.", "Quy trình triển khai: ")
    add_image_with_caption(doc, "technical/production-deployment.png", "Hình 4.22. Hệ thống Lunara Silver Triển khai trên Môi trường Hosting Sản xuất", width_inches=6.2)
    add_body(doc, "Ghi nhận hạn chế hạ tầng: InfinityFree là dịch vụ shared hosting miễn phí phục vụ mục đích học tập và trình diễn đồ án, do đó bộ nhớ RAM bị giới hạn ở mức 128MB, không hỗ trợ giao diện dòng lệnh SSH và tường lửa lọc bot của hosting có thể làm gián đoạn kênh Webhook IPN ngầm từ VNPay (hệ thống thích ứng bằng cơ chế đối soát chủ động QueryDr tại Return URL).")

    doc.add_page_break()

    # =========================================================================
    # CHƯƠNG 5. KIỂM THỬ VÀ ĐÁNH GIÁ KẾT QUẢ
    # =========================================================================
    add_header(doc, "CHƯƠNG 5. KIỂM THỬ VÀ ĐÁNH GIÁ KẾT QUẢ", level=1)
    
    add_header(doc, "5.1. Mục tiêu và Phương pháp Kiểm thử", level=2)
    add_body(doc, "Kiểm thử phần mềm là giai đoạn quan trọng nhằm xác thực tính đúng đắn của toàn bộ các yêu cầu chức năng, bảo đảm tính toàn vẹn của dữ liệu và ngăn chặn tuyệt đối lỗi hồi quy (regressions).")
    add_body(doc, "Dự án Lunara Silver áp dụng phương pháp kiểm thử hộp trắng (White-box Testing) và kiểm thử chức năng tự động (Automated Functional Testing) thông qua bộ khung PHPUnit 11.5.56 của Laravel. Toàn bộ 37 lớp kiểm thử được chia thành:")
    add_bullet(doc, "Kiểm tra tính đúng đắn của các giải thuật tính toán độc lập (tính tồn kho combo ảo, tính chiết khấu coupon, tính tổng tiền hóa đơn).", "1. Kiểm thử Đơn vị (Unit Tests): ")
    add_bullet(doc, "Giả lập các yêu cầu HTTP Request hoàn chỉnh, kiểm tra chuỗi middleware, thẩm định form, tương tác CSDL, phản hồi HTTP Status và dữ liệu hiển thị trên Blade View.", "2. Kiểm thử Tích hợp (Feature Tests): ")

    add_header(doc, "5.2. Danh mục Test Cases Kiểm thử Tự động Tiêu biểu", level=2)
    add_body(doc, "Dưới đây là bảng trích xuất 28 ca kiểm thử tiêu biểu đại diện cho 13 phân hệ nghiệp vụ trọng yếu của hệ thống:")

    headers_tc = ["Mã TC", "Phân hệ", "Tình huống kiểm thử", "Dữ liệu / Điều kiện", "Kết quả mong đợi (Expected)", "Kết quả thực tế"]
    rows_tc = [
        ["TC-01", "AUTH", "Đăng ký gán vai trò user", "Form đăng ký thông thường", "User có role = 'user'", "Đạt (Pass)"],
        ["TC-02", "AUTH", "Chống tấn công Brute-force", "Gửi sai mật khẩu > 5 lần", "Trả về HTTP 429 Throttle", "Đạt (Pass)"],
        ["TC-03", "CATALOG", "Ẩn sản phẩm không kích hoạt", "Truy cập sản phẩm is_active = 0", "Trả về HTTP 404 Not Found", "Đạt (Pass)"],
        ["TC-04", "CATALOG", "Lọc sản phẩm theo đá quý", "Tham số gem=Moissanite", "Chỉ trả về trang sức đính đá này", "Đạt (Pass)"],
        ["TC-05", "INVENTORY", "Tính tồn kho combo khả dụng", "3 linh kiện có kho: 8, 3, 5", "Available quantity = 3", "Đạt (Pass)"],
        ["TC-06", "INVENTORY", "Báo hết hàng combo khi 1 món hết", "1 linh kiện trong bộ có kho = 0", "Available quantity = 0", "Đạt (Pass)"],
        ["TC-07", "CART", "Thêm sản phẩm kèm thiệp quà", "Item ID=1 + gift_note='Chúc mừng'", "Giỏ hàng lưu trữ đúng gift_note", "Đạt (Pass)"],
        ["TC-08", "CART", "Cập nhật số lượng qua AJAX", "Gửi PATCH /cart/items/{id} qty=3", "Tổng tiền giỏ hàng cập nhật đúng", "Đạt (Pass)"],
        ["TC-09", "COUPON", "Áp dụng coupon % có trần tối đa", "Mã giảm 20% tối đa 100k, đơn 1tr", "Giảm chính xác 100.000₫", "Đạt (Pass)"],
        ["TC-10", "COUPON", "Từ chối coupon khi chưa đạt min", "Mã yêu cầu đơn 500k, đơn 300k", "Báo lỗi điều kiện giá trị đơn", "Đạt (Pass)"],
        ["TC-11", "COUPON", "Chặn vượt quá số lượt cá nhân", "User dùng lần 2 mã 1 lần/user", "Báo lỗi vượt giới hạn cá nhân", "Đạt (Pass)"],
        ["TC-12", "CHECKOUT", "Tạo đơn hàng COD thành công", "Giỏ hàng hợp lệ + chọn COD", "Đơn hàng tạo status='pending'", "Đạt (Pass)"],
        ["TC-13", "CHECKOUT", "Khóa bi quan chống bán âm kho", "Hai giao dịch checkout đồng thời", "Một đơn thành công, một đơn báo hết", "Đạt (Pass)"],
        ["TC-14", "CHECKOUT", "Lưu vết thành phần linh kiện", "Đặt mua 1 bộ Gift Box", "order_item_components lưu đủ", "Đạt (Pass)"],
        ["TC-15", "VNPAY", "Ký số URL thanh toán chuẩn xác", "Tham số đơn hàng + Secret Key", "URL chứa vnp_SecureHash 128 ký tự", "Đạt (Pass)"],
        ["TC-16", "VNPAY", "Thẩm tra chữ ký số Return URL", "Tham số hợp lệ có kèm hash", "verifyChecksum() trả về true", "Đạt (Pass)"],
        ["TC-17", "VNPAY", "Đối soát QueryDr cập nhật Paid", "Return URL gọi sang API QueryDr", "Đơn hàng chuyển payment paid", "Đạt (Pass)"],
        ["TC-18", "VNPAY", "IPN Webhook xử lý Idempotent", "Gửi IPN 2 lần liên tiếp cùng mã", "Cả 2 lần trả về 200 Confirm Success", "Đạt (Pass)"],
        ["TC-19", "ORDER", "Chuyển trạng thái đơn hợp lệ", "Pending -> Processing -> Shipped", "order_status_histories ghi vết", "Đạt (Pass)"],
        ["TC-20", "ORDER", "Hoàn kho an toàn khi hủy đơn", "Chuyển đơn sang Cancelled", "Tồn kho linh kiện được cộng lại", "Đạt (Pass)"],
        ["TC-21", "ORDER", "Chống hoàn kho lặp lại (Idempotent)", "Gọi restoreStock() lần thứ hai", "Không cộng thêm kho, giữ nguyên", "Đạt (Pass)"],
        ["TC-22", "REFUND", "Hoàn tiền đơn thanh toán VNPay", "Admin bấm Hoàn tiền giao dịch", "Gửi lệnh API VNPay thành công", "Đạt (Pass)"],
        ["TC-23", "REVIEW", "Chặn người chưa mua đánh giá", "User chưa có đơn mua sản phẩm", "Bị chặn truy cập form đánh giá", "Đạt (Pass)"],
        ["TC-24", "REVIEW", "Chặn đánh giá 2 lần trên 1 món", "Gửi đánh giá lần 2 cùng order item", "Hệ thống báo lỗi vi phạm Unique", "Đạt (Pass)"],
        ["TC-25", "SECURITY", "Chặn User vào trang Quản trị", "User thường vào /admin", "EnsureUserIsAdmin chặn 403/Redirect", "Đạt (Pass)"],
        ["TC-26", "SECURITY", "Chống lỗ hổng IDOR xem đơn hàng", "User A xem đơn hàng của User B", "OrderPolicy chặn quyền 403", "Đạt (Pass)"],
        ["TC-27", "ADMIN", "Dashboard tính Net Revenue đúng", "Gross 10tr, Hoàn tiền 2tr", "Net Revenue hiển thị đúng 8tr", "Đạt (Pass)"],
        ["TC-28", "ADMIN", "Customer 360 Lazy Tab nạp AJAX", "Gọi GET /admin/customers/1/tab/orders", "Trả về partial HTML dưới 20ms", "Đạt (Pass)"],
    ]
    create_table(doc, headers_tc, rows_tc, [Inches(0.65), Inches(0.85), Inches(1.45), Inches(1.25), Inches(1.35), Inches(0.70)], caption="Bảng 5.1. Danh mục Test Cases Kiểm thử Tự động Tiêu biểu (28 Ca Kiểm thử)")

    add_header(doc, "5.3. Kết quả Thực thi Kiểm thử Tự động Thực tế", level=2)
    add_body(doc, "Kết quả thực thi toàn bộ bộ kiểm thử tự động trên máy chủ kiểm thử (chạy lệnh php artisan test) được ghi nhận chính xác và trung thực như sau:")
    add_bullet(doc, "367 bài kiểm thử (Tests).", "Tổng số bài kiểm thử đã chạy: ")
    add_bullet(doc, "1.762 khẳng định (Assertions).", "Tổng số khẳng định kiểm tra: ")
    add_bullet(doc, "0 bài thất bại (0 Failures / 0 Errors).", "Số lượng bài kiểm thử thất bại: ")
    add_bullet(doc, "3 bài kiểm thử (được PHPUnit đánh dấu cảnh báo liên quan đến việc đóng bộ đệm đầu ra trong VerifiedReviewTest, hoàn toàn không làm sai lệch logic nghiệp vụ).", "Số lượng bài kiểm thử Risky: ")
    add_bullet(doc, "41.80 giây.", "Thời gian thực thi toàn bộ: ")
    
    add_image_with_caption(doc, "technical/test-terminal.png", "Hình 5.1. Kết quả Thực thi Bộ Kiểm thử Tự động PHPUnit trên Terminal", width_inches=6.2)

    add_header(doc, "5.4. Đánh giá Hệ thống (Ưu điểm & Hạn chế)", level=2)
    add_body(doc, "1. Về mặt ưu điểm:")
    add_bullet(doc, "Kiến trúc mã nguồn chuẩn mực, phân lớp rõ ràng, tuân thủ nghiêm ngặt các nguyên tắc hướng đối tượng và tiêu chuẩn mã nguồn PSR-12.", "Kiến trúc vững chắc: ")
    add_bullet(doc, "Giải quyết thành công bài toán tồn kho combo, thanh toán điện tử VNPay có đối soát và kiểm soát xung đột đồng thời trong mua hàng.", "Nghiệp vụ thực tế: ")
    add_bullet(doc, "Hệ thống kiểm thử tự động phong phú với 367 bài test bảo đảm độ ổn định cao, không phát sinh lỗi hồi quy.", "Độ tin cậy cao: ")
    add_bullet(doc, "Giao diện thẩm mỹ cao, tốc độ phản hồi nhanh và đáp ứng tốt trên các thiết bị di động.", "Trải nghiệm người dùng: ")
    add_body(doc, "2. Về mặt hạn chế thực tế:")
    add_bullet(doc, "Hạ tầng máy chủ shared hosting miễn phí InfinityFree bị giới hạn bộ nhớ RAM 128MB và không có quyền truy cập SSH dòng lệnh.", "Hạn chế máy chủ: ")
    add_bullet(doc, "Cổng thanh toán VNPay đang vận hành trên môi trường thử nghiệm (Sandbox) với các tài khoản ngân hàng giả lập, chưa kết nối tài khoản doanh nghiệp thực tế.", "Môi trường thanh toán: ")
    add_bullet(doc, "Hệ thống chưa xây dựng ứng dụng di động bản địa (Native Mobile App) trên iOS và Android.", "Nền tảng mở rộng: ")

    doc.add_page_break()

    # =========================================================================
    # CHƯƠNG 6. KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN
    # =========================================================================
    add_header(doc, "CHƯƠNG 6. KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN", level=1)
    
    add_header(doc, "6.1. Kết luận", level=2)
    add_body(doc, "Đề tài “Xây dựng Website Thương mại Điện tử Lunara Silver sử dụng Framework Laravel và MySQL” đã hoàn thành xuất sắc toàn bộ các mục tiêu nghiên cứu và phát triển đặt ra ban đầu. Dự án không chỉ là một bài tập thực hành mã nguồn mở mà đã trở thành một hệ thống thương mại điện tử hoàn chỉnh, vận hành ổn định và giải quyết trọn vẹn các thách thức nghiệp vụ phức tạp của ngành bán lẻ trang sức cao cấp.")

    add_header(doc, "6.2. Kiến thức tích lũy", level=2)
    add_body(doc, "Thông qua quá trình thực hiện đồ án, sinh viên đã tích lũy và củng cố được khối lượng kiến thức chuyên môn sâu sắc:")
    add_bullet(doc, "Làm chủ các tính năng cốt lõi của Laravel: Service Container, Eloquent Relationships, Query Scopes, Custom Middleware, Form Requests, Policies và Database Migrations.", "1. Kỹ năng lập trình Laravel: ")
    add_bullet(doc, "Hiểu và áp dụng thành thạo Service Layer Pattern, Dependency Injection và nguyên tắc SOLID trong thiết kế phần mềm.", "2. Tư duy kiến trúc phân lớp: ")
    add_bullet(doc, "Nắm vững kỹ thuật xử lý giao dịch an toàn (ACID Transactions), cơ chế khóa bi quan (lockForUpdate) phòng chống Race Condition và tối ưu câu truy vấn bằng leftJoinSub.", "3. Quản trị cơ sở dữ liệu: ")
    add_bullet(doc, "Hiểu sâu sắc quy trình ký băm chữ ký số HMAC-SHA512, cơ chế xử lý Webhook bất đồng bộ và kỹ thuật đối soát QueryDr hai kênh.", "4. Tích hợp cổng thanh toán: ")
    add_bullet(doc, "Thành thạo phương pháp viết Unit Test và Feature Test với PHPUnit, tự động hóa quy trình kiểm tra chất lượng phần mềm.", "5. Kỹ năng kiểm thử tự động: ")

    add_header(doc, "6.3. Hạn chế của Đề tài", level=2)
    add_body(doc, "Báo cáo nhìn nhận một cách trung thực và khách quan các giới hạn hiện tại của hệ thống:")
    add_bullet(doc, "Hạ tầng InfinityFree Shared Hosting có độ trễ mạng nhất định (TTFB ~3.4s trên hosting miễn phí do máy chủ đặt tại nước ngoài), không hỗ trợ SSH và giới hạn bộ nhớ.", "Giới hạn hạ tầng máy chủ: ")
    add_bullet(doc, "Chưa tích hợp API của các đơn vị chuyển phát nhanh thực tế (như Giao Hàng Nhanh, Giao Hàng Tiết Kiệm) để tính phí vận chuyển theo tọa độ thực và in vận đơn bưu tá tự động.", "Tích hợp đơn vị vận chuyển: ")
    add_bullet(doc, "Hệ thống ghi nhận lỗi qua file log cục bộ, chưa tích hợp hệ thống giám sát hiệu năng doanh nghiệp (APM) như Sentry hay Datadog.", "Giám sát hiệu năng APM: ")

    add_header(doc, "6.4. Hướng phát triển trong tương lai", level=2)
    add_body(doc, "Từ nền tảng kiến trúc vững chắc hiện tại, hệ thống Lunara Silver có thể tiếp tục được nâng cấp và mở rộng theo các định hướng khả thi sau:")
    add_bullet(doc, "Nâng cấp cổng thanh toán lên tài khoản Merchant chính thức của VNPay để chấp nhận giao dịch tiền thật từ tất cả các ngân hàng Việt Nam và thẻ thanh toán quốc tế Visa/Mastercard.", "1. Chuyển đổi sang VNPay Production: ")
    add_bullet(doc, "Tích hợp trực tiếp Webhook API của Giao Hàng Nhanh (GHN) hoặc Viettel Post để tính toán phí vận chuyển chính xác theo khối lượng và tự động đồng bộ mã vận đơn.", "2. Tích hợp API Logistics tự động: ")
    add_bullet(doc, "Chuyển đổi hạ tầng sang máy chủ ảo riêng (Cloud VPS / AWS / DigitalOcean) chạy Nginx, PHP-FPM, Redis Cache và cơ chế cân bằng tải Load Balancer.", "3. Hạ tầng Cloud chuyên dụng: ")
    add_bullet(doc, "Xây dựng hệ thống điểm thưởng tích lũy (Lunara Points), nâng hạng thành viên (Silver, Gold, Platinum) và tặng voucher sinh nhật tự động.", "4. Chương trình Khách hàng Thân thiết (Loyalty): ")
    add_bullet(doc, "Phát triển bộ API RESTful chuẩn OpenAPI để kết nối ứng dụng di động bản địa (Flutter hoặc React Native) cho iOS và Android.", "5. Ứng dụng Di động Bản địa (Mobile App): ")

    doc.add_page_break()

    # =========================================================================
    # TÀI LIỆU THAM KHẢO
    # =========================================================================
    add_header(doc, "TÀI LIỆU THAM KHẢO", level=1)
    references = [
        "[1] Taylor Otwell and Laravel Community, “Laravel 12.x Official Documentation,” Laravel LLC, 2026. [Online]. Available: https://laravel.com/docs/12.x",
        "[2] The PHP Group, “PHP 8.2 Manual and Language Reference,” The PHP Documentation Group, 2024. [Online]. Available: https://www.php.net/manual/en/",
        "[3] MariaDB Foundation, “MariaDB 10.4 Knowledge Base & SQL Reference,” MariaDB Foundation, 2024. [Online]. Available: https://mariadb.com/kb/en/",
        "[4] VNPay Payment Gateway, “Tài liệu Tích hợp Cổng Thanh toán VNPay phiên bản 2.1.0,” Công ty Cổ phần Giải pháp Thanh toán Việt Nam (VNPAY), 2023.",
        "[5] Bootstrap Team, “Bootstrap 5.3 Documentation: The most popular HTML, CSS, and JS library,” Bootstrap, 2024. [Online]. Available: https://getbootstrap.com/docs/5.3/",
        "[6] Cloudinary Ltd., “Cloudinary PHP SDK v3 Developer Documentation,” Cloudinary, 2024. [Online]. Available: https://cloudinary.com/documentation/php_integration",
        "[7] Sebastian Bergmann, “PHPUnit 11.5 Manual: The PHP Testing Framework,” 2025. [Online]. Available: https://docs.phpunit.de/en/11.5/",
        "[8] Open Web Application Security Project, “OWASP Top 10 Web Application Security Risks,” OWASP Foundation, 2021. [Online]. Available: https://owasp.org/www-project-top-ten/",
        "[9] World Wide Web Consortium (W3C), “Web Content Accessibility Guidelines (WCAG) 2.2,” W3C Recommendation, 2023. [Online]. Available: https://www.w3.org/TR/WCAG22/",
    ]
    for ref in references:
        p_ref = doc.add_paragraph()
        p_ref.paragraph_format.space_before = Pt(4)
        p_ref.paragraph_format.space_after = Pt(4)
        p_ref.paragraph_format.line_spacing = 1.2
        r_r = p_ref.add_run(ref)
        r_r.font.name = 'Times New Roman'
        r_r.font.size = Pt(11.5)

    doc.add_page_break()

    # =========================================================================
    # PHỤ LỤC (APPENDICES)
    # =========================================================================
    add_header(doc, "PHỤ LỤC A. CẤU TRÚC MÃ NGUỒN CHI TIẾT", level=1)
    add_body(doc, "Mã nguồn dự án Lunara Silver được tổ chức theo cấu trúc module phân lớp rõ ràng:")
    add_code_block(doc, """d:/Lunara/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Account/ (Dashboard, Order, Review, Address)
│   │   │   ├── Admin/ (Dashboard, Product, Category, Order, Customer, Export...)
│   │   │   ├── Auth/ (Login, Register, Password)
│   │   │   └── (ProductController, CartController, CheckoutController, VNPayController...)
│   │   ├── Middleware/ (EnsureUserIsAdmin, SecurityHeaders, SeoRedirect)
│   │   └── Requests/ (CheckoutRequest, ProductRequest, CouponRequest...)
│   ├── Models/ (29 Eloquent Models)
│   ├── Policies/ (OrderPolicy, AddressPolicy)
│   └── Services/ (27 Domain Services)
├── config/ (app, database, lunara, vnpay, cloudinary, mail...)
├── database/
│   ├── data/ (catalog.json, posts.json)
│   ├── factories/
│   ├── migrations/ (17 Migration files)
│   └── seeders/ (CatalogSeeder, AdminUserSeeder, BlogSeeder)
├── docs/ (Bộ tài liệu kỹ thuật Phase 24B & final)
├── public/ (index.php, media-previews/, build/)
├── resources/
│   ├── css/ (app.css, admin.css, tokens.css)
│   ├── js/ (app.js, bootstrap.js, cart.js, search.js)
│   └── views/ (layouts, storefront, admin, customer, emails)
├── routes/ (web.php - 143 routes)
├── tests/ (37 Test classes Unit & Feature)
├── composer.json & composer.lock
└── package.json & package-lock.json""", caption="Sơ đồ cây tổ chức thư mục mã nguồn:")

    add_header(doc, "PHỤ LỤC B. MỘT SỐ ĐOẠN MÃ LARAVEL TIÊU BIỂU", level=1)
    add_body(doc, "Dưới đây là hai cài đặt giải thuật nghiệp vụ cốt lõi trong hệ thống:")
    add_code_block(doc, """public function getAvailableQuantityAttribute(): int
{
    if ($this->product_type === 'single') {
        return (int) $this->stock_quantity;
    }
    if ($this->bundleItems->isEmpty()) {
        return 0;
    }
    return (int) $this->bundleItems->min(function ($bundleItem) {
        $componentStock = $bundleItem->componentProduct?->stock_quantity ?? 0;
        $req = $bundleItem->quantity;
        return $req > 0 ? (int) floor($componentStock / $req) : 0;
    });
}""", caption="Đoạn mã 1: Giải thuật tính Tồn kho Ảo (Virtual Inventory) trong App\\Models\\Product.php")

    add_code_block(doc, """return DB::transaction(function () use ($user, $data, $cart) {
    $productIds = $cart->items->pluck('product_id')->unique();
    $lockedProducts = Product::whereIn('id', $productIds)->lockForUpdate()->get();
    
    // Thẩm tra tồn kho khả dụng lần cuối
    $this->inventoryService->validateCartAvailability($cart);
    
    // Khởi tạo đơn hàng và các dòng chi tiết
    $order = Order::create($orderData);
    $this->inventoryService->decrementInventory($cart);
    $cart->clear();
    return $order;
});""", caption="Đoạn mã 2: Giao dịch Đặt hàng & Khóa bi quan (Pessimistic Locking) trong App\\Services\\CheckoutService.php")

    add_header(doc, "PHỤ LỤC C. DANH MỤC 35 BẢNG CƠ SỞ DỮ LIỆU", level=1)
    add_body(doc, "Toàn bộ 35 bảng CSDL được phân bổ thành 8 phân hệ lưu trữ InnoDB:")
    add_bullet(doc, "users, addresses, password_reset_tokens, sessions.", "Phân hệ Tài khoản (AUTH): ")
    add_bullet(doc, "categories, products, product_images, bundle_items.", "Phân hệ Danh mục (CATALOG): ")
    add_bullet(doc, "carts, cart_items, orders, order_items, order_item_components, order_status_histories.", "Phân hệ Bán lẻ (COMMERCE): ")
    add_bullet(doc, "payments, payment_refunds.", "Phân hệ Thanh toán (PAYMENT): ")
    add_bullet(doc, "coupons, coupon_usages.", "Phân hệ Khuyến mãi (MARKETING): ")
    add_bullet(doc, "posts, post_categories, banners, settings, faqs, seo_redirects.", "Phân hệ Nội dung (CONTENT): ")
    add_bullet(doc, "reviews, review_media, support_conversations, support_messages, contact_messages, wishlists, email_logs.", "Phân hệ Chăm sóc (CUSTOMER): ")
    add_bullet(doc, "cache, cache_locks, jobs, failed_jobs.", "Phân hệ Hệ thống (SYSTEM): ")

    add_header(doc, "PHỤ LỤC D. HƯỚNG DẪN CÀI ĐẶT VÀ VẬN HÀNH NHANH", level=1)
    add_body(doc, "Các câu lệnh thiết lập và khởi chạy hệ thống tại môi trường phát triển cục bộ:")
    add_code_block(doc, """# Bước 1: Sao chép mã nguồn và nạp gói phụ thuộc
git clone https://github.com/tanmanh-31102005/LunaraSilver.git
cd LunaraSilver
composer install
npm install

# Bước 2: Khởi tạo tệp cấu hình môi trường và sinh Application Key
cp .env.example .env
php artisan key:generate

# Bước 3: Cấu hình kết nối cơ sở dữ liệu MariaDB trong file .env
# Khởi chạy toàn bộ 17 migrations và seed dữ liệu mẫu
php artisan migrate --seed

# Bước 4: Biên dịch tài nguyên giao diện người dùng (Vite)
npm run build

# Bước 5: Khởi chạy máy chủ phát triển Laravel
php artisan serve --port=8000""", caption="Kịch bản lệnh triển khai môi trường máy chủ cục bộ:")

    add_header(doc, "PHỤ LỤC E. DANH MỤC TEST CASES MỞ RỘNG", level=1)
    add_body(doc, "Toàn bộ 37 lớp kiểm thử tự động của dự án bao gồm:")
    add_bullet(doc, "OrderTotalCalculationTest, VirtualInventoryTest.", "Unit Tests: ")
    add_bullet(doc, "AuthenticationTest, PasswordResetTest, AccountCenterTest, AddressManagementTest, CartCheckoutIntegrationTest, PromotionCouponTest, VNPayPaymentTest, VerifiedReviewTest, ProductCatalogTest, SeoSystemTest, AdminDashboardTest, AdminProductTest, AdminCategoryTest, AdminOrderTest, AdminCustomerTest, AdminPhase21AnalyticsTest...", "Feature Tests: ")
    add_body(doc, "Kết quả thực thi đạt 367 tests passed, 0 failures, 3 risky tests và 1.762 assertions.")

    add_header(doc, "PHỤ LỤC F. BẢNG ĐỐI CHIẾU CHUẨN ĐẦU RA MÔN HỌC", level=1)
    add_body(doc, "Hệ thống đáp ứng 100% các tiêu chí học phần Lập trình Mã nguồn mở:")
    add_bullet(doc, "Laravel 12.69.2 và MariaDB 10.4 / MySQL 8.0.", "Yêu cầu Framework & CSDL: ")
    add_bullet(doc, "Hoàn thiện 7 module CRUD: Product, Category, Post, PostCategory, Faq, Coupon, Address.", "Yêu cầu CRUD: ")
    add_bullet(doc, "Phân quyền User và Admin độc lập qua Middleware EnsureUserIsAdmin.", "Yêu cầu Phân quyền: ")
    add_bullet(doc, "Live Search Suggestions với Debounce và phân luồng Command Palette.", "Yêu cầu Tìm kiếm: ")
    add_bullet(doc, "Cổng thanh toán điện tử VNPay và Media CDN Cloudinary.", "Yêu cầu Tích hợp Dịch vụ: ")

    add_header(doc, "PHỤ LỤC G. DANH MỤC THƯ VIỆN MÃ NGUỒN MỞ", level=1)
    add_body(doc, "Chi tiết đã được trình bày toàn diện tại Bảng 2.1 của Chương 2.")

    add_header(doc, "PHỤ LỤC H. CẨM NANG DÀNH CHO KHÁCH HÀNG", level=1)
    add_body(doc, "Hướng dẫn đầy đủ các bước mua hàng, kiểm tra size nhẫn, đính kèm thiệp quà tặng và theo dõi trạng thái đơn hàng (tham chiếu docs/06-user-guide.md).")

    add_header(doc, "PHỤ LỤC I. CẨM NANG VẬN HÀNH DÀNH CHO QUẢN TRỊ VIÊN", level=1)
    add_body(doc, "Hướng dẫn vận hành đơn hàng, quy trình đối soát QueryDr VNPay, quy trình hoàn tiền, duyệt đánh giá và các cảnh báo an toàn dữ liệu (tham chiếu docs/07-admin-guide.md).")

    # Save document
    print(f"Saving final report docx to: {OUTPUT_FINAL_DOCX}...")
    doc.save(OUTPUT_FINAL_DOCX)
    print("Document saved successfully!")

    # Check file size
    fsize = os.path.getsize(OUTPUT_FINAL_DOCX)
    print(f"Final file size: {fsize:,} bytes")

if __name__ == '__main__':
    build_full_academic_report()
