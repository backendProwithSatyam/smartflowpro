# OAuth Setup Instructions

This Laravel application now supports Google and LinkedIn OAuth authentication. Follow these steps to complete the setup:

## 1. Install Laravel Socialite

If not already installed, run:
```bash
composer require laravel/socialite
```

## 2. Run Migration

Run the migration to add OAuth fields to the users table:
```bash
php artisan migrate
```

## 3. Environment Configuration

Add these environment variables to your `.env` file:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# LinkedIn OAuth
LINKEDIN_CLIENT_ID=your_linkedin_client_id_here
LINKEDIN_CLIENT_SECRET=your_linkedin_client_secret_here
LINKEDIN_REDIRECT_URI=http://localhost:8000/auth/linkedin/callback
```

## 4. Google OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API
4. Go to "Credentials" and create OAuth 2.0 Client ID
5. Set authorized redirect URIs to: `http://your-domain.com/auth/google/callback`
6. Copy the Client ID and Client Secret to your `.env` file

## 5. LinkedIn OAuth Setup

1. Go to [LinkedIn Developer Portal](https://www.linkedin.com/developers/)
2. Create a new app
3. Add the following redirect URL: `http://your-domain.com/auth/linkedin/callback`
4. Copy the Client ID and Client Secret to your `.env` file

## 6. Features Implemented

- ✅ Google OAuth login button
- ✅ LinkedIn OAuth login button  
- ✅ User registration/login with OAuth providers
- ✅ Automatic user creation for new OAuth users
- ✅ Linking existing users with OAuth accounts
- ✅ Avatar storage from OAuth providers
- ✅ Provider tracking (google/linkedin)

## 7. Database Changes

The following fields have been added to the `users` table:
- `google_id` - Stores Google user ID
- `linkedin_id` - Stores LinkedIn user ID  
- `avatar` - Stores user avatar URL
- `provider` - Tracks which OAuth provider was used

## 8. Routes Added

- `GET /auth/google` - Redirects to Google OAuth
- `GET /auth/google/callback` - Handles Google OAuth callback
- `GET /auth/linkedin` - Redirects to LinkedIn OAuth
- `GET /auth/linkedin/callback` - Handles LinkedIn OAuth callback

## 9. Testing

1. Start your Laravel application
2. Go to the login page
3. Click on "Google" or "LinkedIn" buttons
4. Complete the OAuth flow
5. You should be logged in and redirected to the dashboard

## Notes

- OAuth users will have a random password generated automatically
- Email verification is automatically set for OAuth users
- Existing users can link their accounts with OAuth providers
- The system handles both new user creation and existing user linking
