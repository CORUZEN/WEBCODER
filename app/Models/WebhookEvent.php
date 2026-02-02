<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'event_type',
        'request_id',
        'received_at',
        'payload_json',
        'processed_at',
        'processing_status',
        'error_message',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'processed_at' => 'datetime',
        'payload_json' => 'array',
    ];

    // Helpers
    public function isProcessed(): bool
    {
        return $this->processing_status === 'processed';
    }

    public function isFailed(): bool
    {
        return $this->processing_status === 'failed';
    }

    public function markAsProcessed(): void
    {
        $this->update([
            'processing_status' => 'processed',
            'processed_at' => now(),
        ]);
    }

    public function markAsFailed(string $error): void
    {
        $this->update([
            'processing_status' => 'failed',
            'error_message' => $error,
        ]);
    }
}
