$(document).ready(function() {

    $('.left-side-navbar > button').on('click', function() {
        if(!$(this).hasClass("navbar-active")){
            $('.left-side-navbar > button').removeClass('navbar-active');
            $(this).addClass('navbar-active');
            
            if ($(this)[0].dataset.role =='all') {
                $('.all').addClass('show');
                $('.dialog').removeClass('show');
                $('.group').removeClass('show');
                $('#left-loader').css('display', 'flex');
            } else if($(this)[0].dataset.role =='dialog'){
                $('.all').removeClass('show');
                $('.dialog').addClass('show');
                $('.group').removeClass('show');
                $('#left-loader').css('display', 'flex');
            } else {
                $('.all').removeClass('show');
                $('.dialog').removeClass('show');
                $('.group').addClass('show');
                $('#left-loader').css('display', 'flex');
            }
        }
    })
    
    $('.all').addClass('show');
    $('.dialog').removeClass('show');
    $('.group').removeClass('show');
    $('#left-loader').css('display', 'flex');
    getUserlist();
    
});

