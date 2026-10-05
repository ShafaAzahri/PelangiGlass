<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessInquirySubmission;
use App\Models\Setting;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        // Simple honeypot anti-spam
        if ($request->filled('website_hp_field')) {
            return back()->with('success', 'Pesan Anda telah berhasil dikirim.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone_number' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'message.required' => 'Pesan atau pertanyaan wajib diisi.',
        ]);

        // Dispatch queued job to process the inquiry and audit log in background
        ProcessInquirySubmission::dispatch(
            $validated,
            $request->ip(),
            $request->userAgent()
        );

        $waNumber = Setting::get('whatsapp', '6281390288875');
        $cleanPhone = preg_replace('/[^0-9]/', '', $waNumber);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $waText = urlencode("Halo Pelangi Glass, saya {$validated['name']} ({$validated['phone_number']}). Saya ingin berkonsultasi:\n\n\"{$validated['message']}\"");
        $redirectUrl = "https://wa.me/{$cleanPhone}?text={$waText}";

        return redirect('/#kontak')
            ->with('success', 'Terima kasih, ' . $validated['name'] . '! Pesan Anda telah berhasil terkirim ke sistem kami. Tim Pelangi Glass akan segera menghubungi Anda.')
            ->with('wa_url', $redirectUrl);
    }
}
