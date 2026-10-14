<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        if (app()->environment('local', 'testing')) {
            return null;
        }

        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'app' => [
                'name' => config('app.name', 'Pelangi Glass'),
            ],
            'settings' => fn () => Setting::allKeyed(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'wa_url' => fn () => $request->session()->get('wa_url'),
            ],
            'contact' => [
                'whatsapp' => Setting::cleanWhatsapp(),
                'phone_display' => Setting::get('phone_display', '0813-9028-8875'),
                'address' => Setting::get('address', 'Purwokerto, Jawa Tengah'),
                'operational_hours' => Setting::get('operational_hours', 'Senin – Jumat: 08.30 – 16.30 WIB'),
                'operational_hours_weekend' => Setting::get('operational_hours_weekend', 'Sabtu & Minggu: Tutup (Janji Temu via WA)'),
                'facebook' => Setting::get('facebook', 'https://facebook.com'),
                'instagram' => Setting::get('instagram', 'https://www.instagram.com/pelangiglassofficial'),
                'youtube' => Setting::get('youtube', 'https://youtube.com'),
            ],
        ]);
    }
}
