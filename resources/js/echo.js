Echo
    .channel('hello')
    .listen('.event.happens', (e) => {
        console.log(e);
    });

Echo
    .private('App.User.' + userId)
    .notification((notification) => {
        alert(notification.type + ': ' + notification.subject);
    });
