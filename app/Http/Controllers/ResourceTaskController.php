<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ResourceTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $tasks
        ], 200);
    }


    public function create()
    {
        return response()->json([
            'message' => 'API không trả về View. Vui lòng gọi POST để tạo dữ liệu.'
        ], 200);
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required' 
        ]);

        $task = Task::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm mới thành công!',
            'data' => $task
        ], 201);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }
        return response()->json(['data' => $task], 200);
    }

    public function edit($id)
    {
        return response()->json([
            'message' => 'API không trả về View. Vui lòng gọi PUT để sửa dữ liệu.'
        ], 200);
    }

 
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        $task->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công!',
            'data' => $task
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        $task->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa thành công!'
        ], 200);
    }
}