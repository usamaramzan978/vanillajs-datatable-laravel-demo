<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserControler extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:500',
            'sortBy' => 'nullable|string|in:id,name,email,created_at',
            'order' => 'nullable|string|in:asc,desc',
            'perPage' => 'nullable|integer|min:5|max:100',
        ]);

        $query = User::query();

        if ($searchTerm = $request->input('search')) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('id', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('created_at', 'like', "%{$searchTerm}%");
            });
        }

        if ($created_at = $request->input('created_at')) {
            $query->where('created_at', 'like', "%{$created_at}%");
        }
        if ($email = $request->input('email')) {
            $query->where('email', 'like', "%{$email}%");
        }
        if ($name = $request->input('name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        $sortBy = $request->input('sortBy', 'id');
        $order = $request->input('order', 'desc');
        $query->orderBy($sortBy, $order);

        $perPage = $request->input('perPage', 10);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'users' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "User '{$userName}' deleted successfully"
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }
}
