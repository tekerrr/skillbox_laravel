<?php

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('report-total.{userId}', function (\App\User $user, $userId) {
    return (($user->id == $userId) && ($user->isAdmin()));
});

Broadcast::channel('admin', function (\App\User $user) {
    return $user->isAdmin() ? ['id' => $user->id] : null;
});
