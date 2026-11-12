<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Member $member
    ) {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Membership Registration Confirmed')
            ->greeting('Hello ' . $this->member->full_name . ',')
            ->line('Your membership registration was successfully received.')
            ->line(
                'Membership number: '
                . $this->member->membership_number
            )
            ->line(
                'Category: '
                . $this->member->category->name
            )
            ->line(
                'Membership level: '
                . $this->member->level->name
            )
            ->line(
                'Status: '
                . $this->member->status
            )
            ->line('Thank you for joining Puihaha Membership.')
            ->salutation('Puihaha Membership Management System');
    }
}