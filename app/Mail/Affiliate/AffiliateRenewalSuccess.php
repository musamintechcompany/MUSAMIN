<?php

namespace App\Mail\Affiliate;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AffiliateRenewalSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public int $feesPaid;

    public function __construct(User $user, int $feesPaid = null)
    {
        $this->user = $user;
        $this->feesPaid = $feesPaid ?? ($user->affiliate->fee_paid ?? 0);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Affiliate Membership Renewed Successfully! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.affiliate.successfully-renewed-affiliate',
            with: [
                'user' => $this->user,
                'feesPaid' => $this->feesPaid,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}