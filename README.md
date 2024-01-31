1. Giới thiệu về hệ thống
Hệ thống thực hiện quét dữ liệu tự động từ các trang thương mại điện tử để lấy
thông tin các sản phẩm (chủ yếu tập trung vào sản phẩm công nghệ) và cập nhật giá cả
theo thời gian. Người dùng khi truy cập vào hệ thống có thể thực hiện tìm kiếm sản phẩm và
so sánh sản phẩm giữa các nhà bán lẻ khác nhau để có thể mua được với giá tốt nhât.
2. Các yêu cầu chức năng
- Quét các trang thương mại điện tử để lấy dữ liệu các sản phẩm
- Tìm kiếm/Lọc sản phẩm
- Theo dõi sự thay đổi về giá của các sản phẩm theo thời gian
- Đăng ký/Đăng nhập
- Quản lý thông tin người dùng
- Nhận thông báo khi có sự thay đổi về giá của sản phẩm quan tâm
- Quản trị hệ thống: cài đặt các danh mục, các sản phẩm nổi bật hiển thị lên đầu trang
web
- Quản trị hệ thống: quản lý thông tin tất cả người dùng hệ thống
3. Kiến trúc cơ bản của hệ thống
Hệ thống gồm 5 service:
- User Interface Service: Service cung cấp giao diện của hệ thống
- Customer Service: xử lý chức năng đăng ký/đăng nhập, quản lý thông tin người
dùng, nhận thông báo khi có thay đổi về giá của sản phẩm quan tâm
- Management Service: thực hiện các tính năng quản trị hệ thống
- Product Service: xử lý các request liên quan đến thông tin các sản phẩm (tìm kiếm,
lọc sản phẩm, theo dõi giá cả sản phẩm,...)
- Crawl Service: Thực hiện cào dữ liệu sản phẩm từ các trang thương mại điện tử
