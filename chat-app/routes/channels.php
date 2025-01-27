<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
 |--------------------------------------------------------------------------
 | Broadcast Channels
 |--------------------------------------------------------------------------
 |
 | Here you may register all of the event broadcasting channels that your
 | application supports. The given channel authorization callbacks are
 | used to check if an authenticated user can listen to the channel.
 |
 */


 Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    // Kullanıcının odaya katılma yetkisi olup olmadığını kontrol edin
    return true; // Burada kontrolünüzü uygulayın, şu anda herkesin katılmasına izin veriyor
});