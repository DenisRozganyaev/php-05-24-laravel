<?php

namespace App\Notifications\WishList;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(public Product $product)
    {
        $this->onQueue('wishlist-notifications');
    }

    public function via(User $user): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): MailMessage
    {
        return (new MailMessage)
            ->line("Hey, $user->name $user->lastname")
            ->line('Product '.$this->product->title.' from your wish list is available!')
            ->line('Hurry up!')
            ->action('Visit product page', url(route('products.show', $this->product)))
            ->line('Thank you for using our application!');
    }
}
