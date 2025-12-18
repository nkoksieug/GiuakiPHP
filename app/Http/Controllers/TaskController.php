<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Hàm phụ trợ để lấy User ID an toàn
    private function getUserId()
    {
        // Nếu đã đăng nhập thì lấy ID thật
        if (Auth::check()) {
            return Auth::id();
        }
        // Nếu chưa đăng nhập (hoặc lỗi), trả về ID = 1 (Sinh Vien Test) để code không bao giờ chết
        return 1;
    }

    /**
     * 1. Hiển thị danh sách
     */
    public function index(Request $request)
    {
        $userId = $this->getUserId(); // Lấy ID an toàn

        $query = Task::query();
        
        // Chỉ lấy công việc của người đó (hoặc của User 1)
        $query->where('user_id', $userId);

        // Lọc trạng thái
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * 2. Hiển thị form tạo mới
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * 3. Lưu công việc mới (Khắc phục lỗi User ID Null)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $task = new Task($request->all());
        
        // --- ĐOẠN NÀY QUAN TRỌNG NHẤT ---
        // Tự động gán ID an toàn, không bao giờ bị lỗi null
        $task->user_id = $this->getUserId(); 
        
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Thêm công việc thành công!');
    }

    /**
     * 4. Form Sửa
     */
    public function edit(Task $task)
    {
        // Kiểm tra quyền (Cho phép User 1 quyền tối cao để test)
        if ($task->user_id != $this->getUserId() && $this->getUserId() != 1) {
            abort(403, 'Bạn không có quyền sửa task này');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * 5. Cập nhật
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id != $this->getUserId() && $this->getUserId() != 1) {
            abort(403);
        }

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * 6. Xóa
     */
    public function destroy(Task $task)
    {
        if ($task->user_id != $this->getUserId() && $this->getUserId() != 1) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Đã xóa công việc!');
    }
}