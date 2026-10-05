<?php

namespace App\Jobs;

use App\Enums\InquiryStatus;
use App\Models\ActivityLog;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessInquirySubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $data,
        public ?string $ipAddress = null,
        public ?string $userAgent = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inquiry = Inquiry::create([
            'name' => $this->data['name'],
            'phone_number' => $this->data['phone_number'],
            'email' => $this->data['email'] ?? null,
            'message' => $this->data['message'],
            'status' => InquiryStatus::NEW,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
        ]);

        ActivityLog::record(
            action: 'Dibuat',
            subjectType: 'Pesan Masuk',
            description: "Pesan baru diterima dari {$inquiry->name} ({$inquiry->phone_number})",
            subject: $inquiry,
            properties: [
                'attributes' => $inquiry->only(['name', 'phone_number', 'email', 'message']),
            ]
        );

        Log::info("ProcessInquirySubmission: Pesan masuk dari {$inquiry->name} ({$inquiry->phone_number}) berhasil diproses melalui Queue.");
    }
}
