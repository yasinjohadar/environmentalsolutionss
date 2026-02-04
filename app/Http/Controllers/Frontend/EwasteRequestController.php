<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\EwasteRequestStoreRequest;
use App\Models\EwasteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EwasteRequestController extends Controller
{
    public function create(): View
    {
        return view('frontend.ewaste.request');
    }

    public function store(EwasteRequestStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $images = [];
        if ($request->hasFile('images')) {
            $uploadPath = public_path('frontend/uploads/ewaste-requests');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $name = uniqid('ewaste_') . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $name);
                    $images[] = 'frontend/uploads/ewaste-requests/' . $name;
                }
            }
        }
        $data['images'] = !empty($images) ? $images : null;

        EwasteRequest::create($data);

        return redirect()
            ->route('frontend.ewaste.request')
            ->with('success', 'تم إرسال طلبك بنجاح. سنتواصل معك قريباً.');
    }
}
