<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Công Việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Danh Sách Công Việc</h2>

        <!-- Thông báo thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Thêm Mới</a>

            <!-- FORM LỌC / CHỌN TRẠNG THÁI -->
            <form action="{{ route('tasks.index') }}" method="GET" class="d-flex">
                <select name="status" class="form-select me-2" onchange="this.form.submit()">
                    <option value="all">-- Tất cả trạng thái --</option>
                    <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>Cần làm (Todo)</option>
                    <option value="doing" {{ request('status') == 'doing' ? 'selected' : '' }}>Đang làm (Doing)</option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Đã xong (Done)</option>
                </select>
                
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên Công Việc</th>
                            <th>Mô Tả</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                                @if($task->status == 'done')
                                    <span class="badge bg-success">Đã xong</span>
                                @elseif($task->status == 'doing')
                                    <span class="badge bg-warning text-dark">Đang làm</span>
                                @else
                                    <span class="badge bg-secondary">Cần làm</span>
                                @endif
                            </td>
                            <td>

                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-info text-white">Sửa</a>
                                

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<nav class="navbar navbar-light bg-light mb-4 px-3 d-flex justify-content-between">
    <span class="navbar-brand mb-0 h1">Xin chào, {{ Auth::user()->name }}</span>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Đăng Xuất</button>
    </form>
</nav>

</html>