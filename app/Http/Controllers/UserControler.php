<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
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
}
