$(document).ready(function(){
    function showMobile(e) {
        if (e) e.stopPropagation();
        var menu = screen.width > 768 ? '.right-menu-inner' : '.right-menu-inner';
        $(menu).toggleClass('show');
        $('.right-menu-dropdown').toggleClass('show', $(menu).hasClass('show'));
        return false;
    }
    $(".menu-toggle-btn").on('click', showMobile);

    function keepMobile(e) { e.stopPropagation(); }

    function hideMobile() {
        $(".right-menu-inner").removeClass('show');
        $(".user-menu-mob").removeClass('show');
        $(".right-menu-dropdown").removeClass('show');
    }

    $(function () {
        $('.right-menu-inner').click(keepMobile);
        $(document).click(hideMobile);
    });

    $('body').on('contextmenu', 'img', function(e){ 
        return false; 
    });

    $('#headersearch .dropdown-item').click(function(e){
        e.preventDefault();

        type = $(this).data('type');
        iclass = $(this).data('iclass');

        $('#search-type').val(type);

        $('button.selected-drop .fas').removeClass('fa-users');
        $('button.selected-drop .fas').removeClass('fa-comments');
        $('button.selected-drop .fas').removeClass('fa-ad');

        $('button.selected-drop .fas').addClass(iclass);
    });
});

