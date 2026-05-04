<?php

use Illuminate\Support\Facades\Broadcast;

/* ده بتكتب فيه قواعد الوصول (authorization) للقنوات. */
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


