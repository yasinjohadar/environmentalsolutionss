<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EwasteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EwasteRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = EwasteRequest::query()->latest('created_at');

        if ($request->filled('request_type')) {
            $query->where('request_type', $request->request_type);
        }
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('request_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('request_date', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('entity_name', 'like', "%{$search}%")
                    ->orWhere('responsible_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        return view('admin.pages.ewaste-requests.index', compact('requests'));
    }

    public function show(EwasteRequest $ewasteRequest): View
    {
        return view('admin.pages.ewaste-requests.show', compact('ewasteRequest'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $ewasteRequest = EwasteRequest::findOrFail($id);
        $ewasteRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()
            ->route('admin.ewaste-requests.show', $ewasteRequest)
            ->with('success', 'تم تحديث الحالة بنجاح');
    }
}
