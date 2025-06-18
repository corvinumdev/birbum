<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $bannerPath = storage_path('app/banner.txt');
        $bannerMessage = '';
        if (file_exists($bannerPath)) {
            $bannerMessage = trim(file_get_contents($bannerPath));
        }
        return view('admin.dashboard', compact('bannerMessage'));
    }

    public function editBanner()
    {
        $bannerPath = storage_path('app/banner.txt');
        $bannerMessage = '';
        if (file_exists($bannerPath)) {
            $bannerMessage = trim(file_get_contents($bannerPath));
        }
        return view('admin.edit-banner', compact('bannerMessage'));
    }

    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner_message' => 'nullable|string|max:40',
        ]);
        $bannerPath = storage_path('app/banner.txt');
        file_put_contents($bannerPath, trim($request->input('banner_message')));
        return redirect()->route('admin.edit-banner')->with('status', 'Banner actualizado correctamente.');
    }
}
