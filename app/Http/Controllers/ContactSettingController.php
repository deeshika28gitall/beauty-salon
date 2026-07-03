<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function index()
    {
        return ContactSetting::query()
            ->where('is_active', true)
            ->latest()
            ->firstOrFail();
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(ContactSetting $contactSetting)
    {
        abort_if(! $contactSetting->is_active, 404);

        return $contactSetting;
    }

    public function edit(ContactSetting $contactSetting)
    {
        abort(404);
    }

    public function update(Request $request, ContactSetting $contactSetting)
    {
        abort(404);
    }

    public function destroy(ContactSetting $contactSetting)
    {
        abort(404);
    }
}
