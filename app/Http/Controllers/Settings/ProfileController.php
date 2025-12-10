<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('avatar');

        $avatarUrl = $user->avatar && $user->avatar->avatar_path
            ? asset('storage/' . $user->avatar->avatar_path)
            : null;

        return Inertia::render('settings/profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
            'user' => array_merge($user->toArray(), ['avatar_url' => $avatarUrl]),
           

        ]);
    }

    /**
     * Update the user's profile settings.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|file|image|max:2048',
            'email' => 'required|string|lowercase|email|max:255',
        ]);


        if ($request->hasFile('avatar')) {
            // ensure relation is loaded so $user->avatar is available in-memory
            $user->load('avatar');

            // delete previous file only if avatar relation exists and has a path
            if ($user->avatar?->avatar_path) {
                Storage::disk('public')->delete($user->avatar->avatar_path);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            // create or update avatar relation
            $user->avatar()->updateOrCreate(
                [], // match attributes for update
                ['avatar_path' => $path]
            );
        }

        // If incoming email differs, clear verification
        if ($request->input('email') !== $user->email) {
            $user->email_verified_at = null;
        }


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);


        return to_route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
