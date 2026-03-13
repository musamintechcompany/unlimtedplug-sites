<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (!auth('admin')->user()->can('view-users')) {
            abort(403);
        }
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if (!auth('admin')->user()->can('view-user-details')) {
            abort(403);
        }
        $rentals = $user->rentals()->latest()->get();
        $transactions = $user->creditTransactions()->latest()->get();
        $wallet = $user->wallet;
        return view('admin.users.show', compact('user', 'rentals', 'transactions', 'wallet'));
    }

    public function edit(User $user)
    {
        if (!auth('admin')->user()->can('edit-users')) {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth('admin')->user()->can('edit-users')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:active,inactive,banned',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if (!auth('admin')->user()->can('delete-users')) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function ban(User $user)
    {
        if (!auth('admin')->user()->can('ban-users')) {
            abort(403);
        }

        $user->update(['status' => 'banned']);
        return back()->with('success', 'User banned successfully!');
    }

    public function unban(User $user)
    {
        if (!auth('admin')->user()->can('unban-users')) {
            abort(403);
        }

        $user->update(['status' => 'active']);
        return back()->with('success', 'User unbanned successfully!');
    }

    public function bulkDelete(Request $request)
    {
        if (!auth('admin')->user()->can('delete-users')) {
            abort(403);
        }

        $ids = explode(',', $request->input('ids', ''));
        $ids = array_filter($ids);

        if (empty($ids)) {
            return back()->with('error', 'No users selected!');
        }

        $deleted = User::whereIn('id', $ids)->delete();
        return redirect()->route('admin.users.index')->with('success', "$deleted user(s) deleted successfully!");
    }
}
