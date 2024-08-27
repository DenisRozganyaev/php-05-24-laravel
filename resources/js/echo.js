import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

console.log('env', import.meta.env)

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

Pusher.logToConsole = true

window.Echo.private('admin-channel')
    .listen('.order.created.notify', (event) => {

        console.log('event', event)
        iziToast.success({
            title: `You have new order. With total: ${event.total}$`,
            position: 'topRight'
        })
    })
