// Echo
//     .channel('hello')
//     .listen('SomethingHappens', (e) => {
//         alert('test');
//         alert(e.whatHappens);
//     });
Echo.channel('skillbox_laravel_database_hello')
    .listen('SomethingHappens', (e) => {
        alert(e.whatHappens);
    });
