<?php

namespace App\Notifications\Admins;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    public function viaQueues(): array
    {
        return [
            'mail' => 'admin-mail',
            'telegram' => 'admin-telegram',
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $user): array
    {
        return $user?->telegram_id ? ['telegram', 'mail'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): MailMessage
    {
        logs()->info('notify admin by email');
        $url = route('admin.dashboard');

        return (new MailMessage)
            ->subject('New order!')
            ->line('Hello, ' . $user->name . ' ' . $user->lastname)
            ->line('There is a new order')
            ->line('')
            ->line('Total: ' . $this->order->total . ' ' . config('paypal.currency'))
            ->action('Check this order', $url);
    }

    public function toTelegram(User $user)
    {
        logs()->info('notify admin by telegram');
        $url = route('admin.dashboard');

        return TelegramMessage::create()
            ->to($user->telegram_id)
            ->content('Hello, ' . $user->name . ' ' . $user->lastname)
            ->line('There is a new order')
            ->line('')
            ->line('Total: ' . $this->order->total . ' ' . config('paypal.currency'))
            ->button('Check this order', $url);
    }
}
