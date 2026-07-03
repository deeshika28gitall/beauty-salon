<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function edit()
    {
        return view('admin.contact-settings.edit', [
            'contactSetting' => ContactSetting::firstOrNew(['studio_name' => 'Kharbanda Makeup Studio']),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'studio_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:60'],
            'whatsapp' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:120'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'map_url' => ['nullable', 'url', 'max:500'],
            'map_embed_url' => ['nullable', 'string', 'max:2000'],
            'business_hours_text' => ['nullable', 'string'],
        ]);

        $data['business_hours'] = collect(preg_split('/\r\n|\r|\n/', $data['business_hours_text'] ?? ''))
            ->mapWithKeys(function ($line) {
                [$day, $hours] = array_pad(explode(':', $line, 2), 2, null);
                return $day && $hours ? [strtolower(trim($day)) => trim($hours)] : [];
            })
            ->all();
        unset($data['business_hours_text']);
        $data['is_active'] = $request->boolean('is_active', true);

        ContactSetting::updateOrCreate(['id' => $request->input('id')], $data);

        return back()->with('success', 'Contact settings updated.');
    }
}
