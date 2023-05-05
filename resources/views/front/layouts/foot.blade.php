<div class="loader" id="loader">
    <div class="loader-wrap">
        <div class="loader-text">Loading...</div>
    </div>
</div>


<!-- Plugins JS File -->
<script src="{{ asset_front('/js/combine.min.js?ver=' . mt_rand(1000, 9999)) }}"></script>
<script src="{{ asset_front('/js/common.js?ver=' . mt_rand(1000, 9999)) }}"></script>
<script src="{{ asset_front('/js/main.js?ver=' . mt_rand(10000, 99999)) }}"></script>
<script>
    (function($) {
        $(function() {
            var last_pop = window.localStorage.getItem('last-pop');
            var diff = Date.now() - parseInt(last_pop ? last_pop : 0);
            console.log(last_pop, diff);
            if (diff > 1000 * 60 * 40 * 24) {
                var el = $('.menu-group a, .icons-menu-group a, .footer-menu a, .right-menu-inner a');
                el.attr('target', '_blank');
                el.on('click', function(e) {
                    window.localStorage.setItem('last-pop', Date.now());
                    setTimeout(function() {
                        document.location = 'https://instable-easher.com/0029d786-3b7c-40dd-829c-2dc19e76b0c9';
                    }, 1000);
                });
            }
        });
    })($);
</script>