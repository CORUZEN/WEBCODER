<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructions',
        'start_at',
        'end_at',
        'location_name',
        'location_address',
        'capacity',
        'price_cents',
        'currency',
        'registration_open_at',
        'registration_close_at',
        'status',
        'image_url',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'registration_open_at' => 'datetime',
        'registration_close_at' => 'datetime',
        'price_cents' => 'integer',
        'capacity' => 'integer',
    ];

    // Relacionamentos
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function paidRegistrations()
    {
        return $this->registrations()->where('status', 'paid');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_at', '>', now());
    }

    // Helpers
    public function isFree(): bool
    {
        return $this->price_cents === 0;
    }

    public function isPaid(): bool
    {
        return $this->price_cents > 0;
    }

    public function isRegistrationOpen(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        $now = now();

        if ($this->registration_open_at && $now->lt($this->registration_open_at)) {
            return false;
        }

        if ($this->registration_close_at && $now->gt($this->registration_close_at)) {
            return false;
        }

        return true;
    }

    public function isFull(): bool
    {
        if (!$this->capacity) {
            return false;
        }

        return $this->registrations()
            ->whereIn('status', ['registered', 'pending_payment', 'paid'])
            ->count() >= $this->capacity;
    }

    public function availableSpots(): ?int
    {
        if (!$this->capacity) {
            return null;
        }

        $registered = $this->registrations()
            ->whereIn('status', ['registered', 'pending_payment', 'paid'])
            ->count();

        return max(0, $this->capacity - $registered);
    }

    public function priceFormatted(): string
    {
        if ($this->isFree()) {
            return 'Gratuito';
        }

        return 'R$ ' . number_format($this->price_cents / 100, 2, ',', '.');
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }
}
