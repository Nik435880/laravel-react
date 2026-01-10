<?php

namespace App\Http\Controllers\Settings;

use App\Actions\DeleteUser;
use App\Actions\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileDeleteRequest;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

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

        return Inertia::render('settings/profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile settings.
     */
    public function update(ProfileUpdateRequest $request, UpdateUser $updateUser): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validated();

        $updateUser->execute($user, $validatedData);

        return to_route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(ProfileDeleteRequest $request, DeleteUser $deleteUser): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $deleteUser->execute($user);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
