# Blog_App

> [Classroom](https://classroom.google.com/u/0/c/NzQ5OTkyMzU3MTQy) [Docs](https://docs.google.com/spreadsheets/d/1UzBbwM3lt-sTwVuCZHm5MYIAFbV_Y6HGWXxu6OOtbzk/edit?gid=801622215#gid=801622215)

```
- 7/4/25 Nộp BC + Source code
- 7h30, 9/4/25 Báo cáo đồ án
```

### Mục đích dự án

Dự án này là một ứng dụng blog cơ bản với các chức năng quản lý bài viết, danh mục, và người dùng. Nó phù hợp để học tập và mở rộng thêm các tính năng nâng cao như API, phân trang, hoặc giao diện hiện đại hơn.

### Công nghệ sử dụng
- PHP: Xử lý logic phía server.
- MySQL: Lưu trữ dữ liệu (bài viết, người dùng, danh mục, v.v.).
- HTML/CSS: Giao diện người dùng.
- JavaScript: Tương tác giao diện (ví dụ: sidebar, menu).
- XAMPP: Môi trường phát triển (Apache, MySQL).

### Cách chạy dự án
- Cài đặt XAMPP và khởi động Apache, MySQL.
- Tạo cơ sở dữ liệu blog và nhập thông tin vào constains.php.
- Đặt thư mục dự án vào htdocs.
- Truy cập http://localhost/Blog_App/ trên trình duyệt.

## Vài câu lệnh git:

- Git checkout <tên nhánh> # di chuyển ra nhánh
- Git merge <tên nhánh> # hợp nhất nhánh (nhánh chọn vào nhánh hiện tại)
- Git push origin <tên nhánh> # đẩy source lên nhánh
- Git pull origin main # tải các thay đổi từ main về dự án
- Git fetch # Tải về tất cả các thay đổi từ remote mà không tự động hợp nhất (fetch) vào nhánh hiện tại
- Git branch -r # kiểm tra các nhánh cục bộ hiện tại
- git log --oneline # kiểm tra danh sách commit
- Git reset --hard <id commit> # về commit chỉ định (Xóa toàn bộ thay đổi sau commit)


## Cấu trúc dự án

```
Blog_App/
├── about.php               # Trang "About"
├── blog.php                # Trang danh sách bài viết
├── category-posts.php      # Trang bài viết theo danh mục
├── contact.php             # Trang "Contact"
├── index.php               # Trang chủ
├── logout.php              # Xử lý đăng xuất
├── post.php                # Trang chi tiết bài viết
├── services.php            # Trang "Services"
├── signin.php              # Trang đăng nhập
├── signup.php              # Trang đăng ký
├── admin/                  # Chức năng quản trị
│   ├── add-category.php    # Thêm danh mục
│   ├── add-post.php        # Thêm bài viết
│   ├── add-user.php        # Thêm người dùng
│   ├── edit-category.php   # Sửa danh mục
│   ├── edit-post.php       # Sửa bài viết
│   ├── edit-user.php       # Sửa người dùng
│   ├── manage-categories.php # Quản lý danh mục
│   ├── manage-users.php    # Quản lý người dùng
│   ├── index.php           # Trang quản lý bài viết
│   ├── config/             # Cấu hình cơ sở dữ liệu
│   │   ├── constains.php   # Hằng số (URL, thông tin DB)
│   │   ├── database.php    # Kết nối cơ sở dữ liệu
│   ├── shares/             # Tệp dùng chung (header, footer)
│   │   ├── header.php      # Header cho admin
├── config/                 # Cấu hình chung
│   ├── constains.php       # Hằng số (URL, thông tin DB)
│   ├── database.php        # Kết nối cơ sở dữ liệu
├── controller/             # Xử lý logic
│   ├── adduser-controller.php # Xử lý thêm người dùng
│   ├── signin-controller.php # Xử lý đăng nhập
│   ├── signup-controller.php # Xử lý đăng ký
├── css/                    # Tệp CSS
│   ├── style.css           # Giao diện chính
├── images/                 # Thư mục chứa ảnh
├── js/                     # Tệp JavaScript
│   ├── main.js             # Tương tác giao diện
├── shares/                 # Tệp dùng chung
│   ├── footer.php          # Footer cho người dùng
│   ├── header.php          # Header cho người dùng
├── README.md               # Tài liệu dự án
```

### Các chức năng chính
1. Người dùng
- Trang chủ (index.php):
    - Hiển thị bài viết nổi bật và danh sách bài viết.
    - Có các nút điều hướng đến các danh mục bài viết.
- Đăng ký (signup.php):
    - Người dùng nhập thông tin (họ tên, email, mật khẩu, avatar).
    - Kiểm tra thông tin hợp lệ và lưu vào cơ sở dữ liệu.
- Đăng nhập (signin.php):
    - Người dùng nhập email hoặc tên đăng nhập và mật khẩu.
    - Kiểm tra thông tin và tạo session.
- Đăng xuất (logout.php):
    - Xóa session và chuyển hướng về trang chủ.
- Xem bài viết (post.php):
     -Hiển thị chi tiết bài viết (tiêu đề, nội dung, tác giả, ngày đăng).
- Tìm kiếm bài viết (blog.php):
    - Hiển thị danh sách bài viết và cho phép tìm kiếm.
2. Admin
- Quản lý bài viết (admin/index.php):
    - Hiển thị danh sách bài viết.
    - Chỉnh sửa hoặc xóa bài viết.
- Quản lý danh mục (admin/manage-categories.php):
    - Hiển thị danh sách danh mục.
    - Thêm, sửa, hoặc xóa danh mục.
- Quản lý người dùng (admin/manage-users.php):
    - Hiển thị danh sách người dùng.
    - Thêm, sửa, hoặc xóa người dùng.
- Thêm bài viết (admin/add-post.php):
    - Nhập tiêu đề, nội dung, danh mục, và ảnh đại diện.
- Thêm danh mục (admin/add-category.php):
    - Nhập tên và mô tả danh mục.
- Thêm người dùng (admin/add-user.php):
    - Nhập thông tin người dùng (họ tên, email, mật khẩu, avatar).