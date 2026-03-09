<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiKeyController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $apiKeys = auth()->user()->apiKeys()->latest()->get();
        return view('api-keys.index', compact('apiKeys'));
    }

    public function create()
    {
        return view('api-keys.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $key = auth()->user()->apiKeys()->create([
            'name' => $request->name,
            'key' => 'sk_' . Str::random(32),
            'status' => 'active'
        ]);

        return redirect()->route('api-keys.create')->with('api_key', $key->key);
    }

    public function destroy(ApiKey $apiKey)
    {
        $this->authorize('delete', $apiKey);
        $apiKey->delete();
        return redirect()->route('api-keys.index')->with('success', 'API key deleted.');
    }

    public function toggle(ApiKey $apiKey)
    {
        $this->authorize('update', $apiKey);

        $apiKey->update([
            'status' => $apiKey->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', 'API key status updated.');
    }
}
