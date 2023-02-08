// let conversation_id = '';
        // const loader = document.getElementById('loader');
        // left side buttons controller
        $(document).ready(function() {
        //     $('.member-list').on('click', function() {
        //         console.log('ok');
        //         if(!$(this).hasClass("active")){
        //             // styles
        //             $('.member-list').removeClass('active');
        //             $(this).addClass('active');
                    
        //             $('.member-list').css('backgroundColor', '#fff');
        //             $(this).css('backgroundColor', '#ffc8b2b5');

        //             $('.message-body > div').html('');

        //             $('.member-list').css('pointerEvents', 'auto') 
        //             $(this).css('pointerEvents', 'none')

        //             $('#loader').css('display', 'block');

        //             $('.message-box').css('display', 'flex');
        //             $('.message-box-logo').css('display', 'none');
                    
        //             $('.user-name')[0].innerText = $(this)[0].innerText;
        //             $('#deleteConversation').attr('data-id', $(this)[0].dataset.id);
        //             $('#leaveGroup').attr('data-id', $(this)[0].dataset.id);

        //             if($(this)[0].dataset.isgroup == 'false') {
        //                 $('#leaveGroup').css('display', 'none');
        //             } else {
        //                 $('#leaveGroup').css('display', 'block');
        //             }
        //             conversation_id = $(this)[0].dataset.id;
        //             getMessages();
        //         }
        //     });

            $('.left-side-navbar > button').on('click', function() {
                if(!$(this).hasClass("navbar-active")){
                    $('.left-side-navbar > button').removeClass('navbar-active');
                    $(this).addClass('navbar-active');
                    
                    if ($(this)[0].dataset.role =='all') {
                        $('.all').addClass('show');
                        $('.dialog').removeClass('show');
                        $('.group').removeClass('show');
                        getUserlist('all');
                    } else if($(this)[0].dataset.role =='dialog'){
                        $('.all').removeClass('show');
                        $('.dialog').addClass('show');
                        $('.group').removeClass('show');
                        getUserlist('dialog');
                    } else {
                        $('.all').removeClass('show');
                        $('.dialog').removeClass('show');
                        $('.group').addClass('show');
                        getUserlist('group');
                    }
                }
            })

            $('.all').addClass('show');
            $('.dialog').removeClass('show');
            $('.group').removeClass('show');
            getUserlist('all');
        });