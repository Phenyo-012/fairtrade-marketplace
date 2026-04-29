<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['required', 'string', 'max:20'],
        ]);

        $user = auth()->user();

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;

        $user->save();

        return back()->with('status', 'profile-updated');
    }
    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->sellerProfile) {
            $user->sellerProfile->update([
                'verification_status' => 'archived',
            ]);

            $user->sellerProfile->products()->update([
                'is_active' => false,
                'is_archived' => true,
            ]);
        }

        $user->update([
            'is_archived' => true,
            'archived_at' => now(),

            'archived_email' => $user->email,
            'archived_phone' => $user->phone,

            // frees original email and phone for new registrations
            'email' => 'archived_user_' . $user->id . '_' . $user->email,
            'phone' => 'archived_user_' . $user->id . '_' . $user->phone,
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
