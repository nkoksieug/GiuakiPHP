<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Đăng Nhập</h4>
                    </div>
                    <div class="card-body">
                        <!-- Thông báo lỗi -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Mật khẩu:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>