<?php

namespace App\Notifications\WishList;

use App\Mail\NewPriceMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPriceNotification extends Notification
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

    public function toMail(User $user): Mailable
    {
        return (new NewPriceMail($this->product))->to($user->email);
//        return (new MailMessage)
//            ->line("Hey, $user->name $user->lastname")
//            ->line("Product ". $this->product->title ." from your wish list has new lower price!")
//            ->line('Hurry up!')
//            ->action('Visit product page', url(route('products.show', $this->product)))
//            ->line('Thank you for using our application!');
    }
}
