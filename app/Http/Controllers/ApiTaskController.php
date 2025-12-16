<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class ApiTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $tasks
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'user_id' => 'required'
        ]);

        $task = Task::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Thêm công việc thành công',
            'data' => $task
        ], 201);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy'], 404);
        }
        return response()->json(['status' => true, 'data' => $task], 200);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy'], 404);
        }

        $task->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $task
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy'], 404);
        }

        $task->delete();
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa thành công'
        ], 200);
    }
}