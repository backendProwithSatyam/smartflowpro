<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = $this->findOrCreateUser($googleUser, 'google');
            
            Auth::login($user);
            
            return redirect()->intended(route('dashboard'));
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong with Google authentication.');
        }
    }

    /**
     * Redirect to LinkedIn OAuth
     */
    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Handle LinkedIn OAuth callback
     */
    public function handleLinkedInCallback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();
            
            $user = $this->findOrCreateUser($linkedinUser, 'linkedin');
            
            Auth::login($user);
            
            return redirect()->intended(route('dashboard'));
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong with LinkedIn authentication.');
        }
    }

    /**
     * Find or create user based on OAuth data
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        // Check if user exists by email
        $user = User::where('email', $socialUser->getEmail())->first();
        
        if ($user) {
            // Update existing user with OAuth data
            $updateData = [
                'provider' => $provider,
                'avatar' => $socialUser->getAvatar(),
            ];
            
            if ($provider === 'google') {
                $updateData['google_id'] = $socialUser->getId();
            } elseif ($provider === 'linkedin') {
                $updateData['linkedin_id'] = $socialUser->getId();
            }
            
            $user->update($updateData);
            
            return $user;
        }
        
        // Check if user exists by provider ID
        $providerField = $provider . '_id';
        $user = User::where($providerField, $socialUser->getId())->first();
        
        if ($user) {
            return $user;
        }
        
        // Create new user
        $name = $socialUser->getName();
        if (empty($name)) {
            $name = $socialUser->getNickname() ?? 'User';
        }
        
        return User::create([
            'name' => $name,
            'email' => $socialUser->getEmail(),
            'password' => bcrypt(Str::random(16)), // Random password for OAuth users
            'email_verified_at' => now(),
            'avatar' => $socialUser->getAvatar(),
            'provider' => $provider,
            $providerField => $socialUser->getId(),
        ]);
    }
}
