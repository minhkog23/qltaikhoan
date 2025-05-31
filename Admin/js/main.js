$('[data-toggle="sidebar"]').click(function(event) {
    event.preventDefault();
    $('.app').toggleClass('sidenav-toggled');
});
