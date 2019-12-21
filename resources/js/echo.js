Echo
    .channel('hello')
    .listen('SomethingHappens', (e) => {
        console.log(e.what);
    });
