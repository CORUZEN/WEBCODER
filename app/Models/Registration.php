<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'code',
        'status',
        'notes',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Helpers
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending_payment';
    }

    public function isCancelled(): bool
    {
        return in_array($this->status, ['cancelled', 'refunded']);
    }

    public function statusBadge(): string
    {
        return match($this->status) {
            'registered' => '<span class="badge badge-info">Inscrito</span>',
            'pending_payment' => '<span class="badge badge-warning">Aguardando Pagamento</span>',
            'paid' => '<span class="badge badge-success">Pago</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelado</span>',
            'refunded' => '<span class="badge badge-danger">Reembolsado</span>',
            default => '<span class="badge">' . $this->status . '</span>',
        };
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'registered' => 'Inscrito',
            'pending_payment' => 'Aguardando Pagamento',
            'paid' => 'Pago',
            'cancelled' => 'Cancelado',
            'refunded' => 'Reembolsado',
            default => $this->status,
        };
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->code)) {
                $registration->code = self::generateUniqueCode();
            }
        });
    }

    private static function generateUniqueCode(): string
    {
        do {
            $year = date('Y');
            $number = str_pad(self::count() + 1, 6, '0', STR_PAD_LEFT);
            $code = "IAGUS-{$year}-{$number}";
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
