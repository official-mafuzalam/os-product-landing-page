<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:settings_manage')->only(['index', 'update']);
    // }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $groups = Setting::getGroupedSettings()
            ->map(function ($group) {
                return $group->reject(fn($setting) => $setting->key === 'default_layout_type');
            });

        return view('admin.settings.index', compact('groups'));
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token');

        // Get all boolean settings from database
        $booleanSettings = Setting::where('type', 'boolean')->pluck('key');

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                // Handle file uploads
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    // Delete old file if exists
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    // Store new file
                    $path = $request->file($key)->store('settings', 'public');
                    $value = $path;
                }

                // Handle empty file input (don't overwrite existing file)
                if ($setting->type === 'image' && !$request->hasFile($key) && empty($value)) {
                    continue; // Skip updating if no new file was uploaded
                }

                $setting->update(['value' => $value]);

                // Clear individual setting cache
                if (function_exists('setting')) {
                    Cache::forget('setting_' . $key);
                }
            }
        }

        // Handle boolean settings that weren't submitted (unchecked checkboxes)
        foreach ($booleanSettings as $booleanKey) {
            if (!$request->has($booleanKey)) {
                $setting = Setting::where('key', $booleanKey)->first();
                if ($setting) {
                    $setting->update(['value' => '0']);
                    Cache::forget('setting_' . $booleanKey);
                }
            }
        }

        // Clear all settings cache
        Cache::flush();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function homepageSections()
    {
        $layoutSetting = Setting::where('key', 'default_layout_type')->first();

        return view('admin.settings.homepage_sections', compact('layoutSetting'));
    }

    public function updateHomepageSections(Request $request)
    {
        $request->validate([
            'default_layout_type' => 'required|in:layout1,layout2',
        ]);

        Setting::updateOrCreate(
            ['key' => 'default_layout_type', 'group' => 'general'],
            ['value' => $request->default_layout_type]
        );
        Cache::flush();
        return redirect()->back()->with('success', 'Layout updated successfully!');
    }


}