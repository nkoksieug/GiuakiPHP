<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng Ký Tài Khoản</title>
    <!-- Nhúng Bootstrap để có giao diện đẹp ngay lập tức -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">Đăng Ký Tài Khoản Mới</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- --- QUAN TRỌNG: Hiển thị thông báo lỗi --- -->
                        <!-- Nếu nhập sai (pass ngắn, email trùng...), Laravel sẽ trả về biến $errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- -------------------------------------------- -->

                        <form action="{{ route('register') }}" method="POST">
                            @csrf <!-- Bắt buộc phải có để bảo mật -->

                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập tên hiển thị" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nhập lại mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu trên" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Đăng Ký Ngay</button>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <p>Đã có tài khoản? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Đăng nhập tại đây</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>