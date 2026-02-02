<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'provider',
        'mp_preference_id',
        'mp_payment_id',
        'external_reference',
        'amount_cents',
        'currency',
        'status',
        'status_detail',
        'payload_json',
    ];

    protected $casts = [
        'amount_cents' => 'integer',
        'payload_json' => 'array',
    ];

    // Relacionamentos
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // Helpers
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['created', 'pending']);
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function amountFormatted(): string
    {
        return 'R$ ' . number_format($this->amount_cents / 100, 2, ',', '.');
    }

    public function statusBadge(): string
    {
        return match($this->status) {
            'created' => '<span class="badge badge-info">Criado</span>',
            'pending' => '<span class="badge badge-warning">Pendente</span>',
            'approved' => '<span class="badge badge-success">Aprovado</span>',
            'rejected' => '<span class="badge badge-danger">Rejeitado</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelado</span>',
            'refunded' => '<span class="badge badge-warning">Reembolsado</span>',
            'charged_back' => '<span class="badge badge-danger">Chargeback</span>',
            default => '<span class="badge">' . $this->status . '</span>',
        };
    }
}
