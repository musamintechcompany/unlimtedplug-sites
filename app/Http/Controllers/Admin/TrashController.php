<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\RentableProject;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        $trashedUsers = User::onlyTrashed()->latest('deleted_at')->paginate(10, ['*'], 'users');
        $trashedAdmins = Admin::onlyTrashed()->latest('deleted_at')->paginate(10, ['*'], 'admins');
        $trashedProjects = RentableProject::onlyTrashed()->latest('deleted_at')->paginate(10, ['*'], 'projects');

        return view('admin.trash.index', compact('trashedUsers', 'trashedAdmins', 'trashedProjects'));
    }

    public function restoreUser(User $user)
    {
        $user->restore();
        return back()->with('success', 'User restored successfully');
    }

    public function restoreAdmin(Admin $admin)
    {
        $admin->restore();
        return back()->with('success', 'Admin restored successfully');
    }

    public function restoreProject(RentableProject $project)
    {
        $project->restore();
        return back()->with('success', 'Project restored successfully');
    }

    public function forceDeleteUser(User $user)
    {
        $user->forceDelete();
        return back()->with('success', 'User permanently deleted');
    }

    public function forceDeleteAdmin(Admin $admin)
    {
        $admin->forceDelete();
        return back()->with('success', 'Admin permanently deleted');
    }

    public function forceDeleteProject(RentableProject $project)
    {
        $project->forceDelete();
        return back()->with('success', 'Project permanently deleted');
    }

    public function bulkRestore(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:user,admin,project',
            'ids' => 'required|string',
        ]);

        $ids = array_filter(explode(',', $validated['ids']));

        if (empty($ids)) {
            return back()->with('error', 'No items selected');
        }

        $type = $validated['type'];
        $count = 0;

        if ($type === 'user') {
            $count = User::onlyTrashed()->whereIn('id', $ids)->restore();
        } elseif ($type === 'admin') {
            $count = Admin::onlyTrashed()->whereIn('id', $ids)->restore();
        } elseif ($type === 'project') {
            $count = RentableProject::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        return back()->with('success', "$count item(s) restored successfully");
    }

    public function bulkForceDelete(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:user,admin,project',
            'ids' => 'required|string',
        ]);

        $ids = array_filter(explode(',', $validated['ids']));

        if (empty($ids)) {
            return back()->with('error', 'No items selected');
        }

        $type = $validated['type'];
        $count = 0;

        if ($type === 'user') {
            $count = User::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } elseif ($type === 'admin') {
            $count = Admin::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } elseif ($type === 'project') {
            $count = RentableProject::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        }

        return back()->with('success', "$count item(s) permanently deleted");
    }

    public function emptyTrash()
    {
        User::onlyTrashed()->forceDelete();
        Admin::onlyTrashed()->forceDelete();
        RentableProject::onlyTrashed()->forceDelete();

        return back()->with('success', 'Trash emptied successfully');
    }
}
