<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\ContactStoreRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact.index');
    }

    public function store(ContactStoreRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()
            ->route('frontend.contact.index')
            ->with('success', 'تم إرسال رسالتك بنجاح. سنتواصل معك في أقرب وقت.');
    }
}
