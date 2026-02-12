<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function stripe()
    {
        $stripeKey = env('STRIPE_KEY', '');
        $stripeSecret = env('STRIPE_SECRET', '');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET', '');

        return view('admin.settings.stripe', compact('stripeKey', 'stripeSecret', 'webhookSecret'));
    }

    public function updateStripe(Request $request)
    {
        $validated = $request->validate([
            'stripe_key' => 'nullable|string',
            'stripe_secret' => 'nullable|string',
            'stripe_webhook_secret' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            if ($value) {
                Setting::set($key, $value, ['group' => 'stripe', 'type' => 'text']);
            }
        }

        // Also update .env file
        $this->updateEnvFile([
            'STRIPE_KEY' => $validated['stripe_key'] ?? env('STRIPE_KEY'),
            'STRIPE_SECRET' => $validated['stripe_secret'] ?? env('STRIPE_SECRET'),
            'STRIPE_WEBHOOK_SECRET' => $validated['stripe_webhook_secret'] ?? env('STRIPE_WEBHOOK_SECRET'),
        ]);

        return redirect()->route('admin.settings.stripe')
            ->with('success', 'Stripe settings updated successfully.');
    }

    private function updateEnvFile(array $data): void
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envFile, $envContent);
    }
}
