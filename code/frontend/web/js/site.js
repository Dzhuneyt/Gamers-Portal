$(function () {
    $(document).on('click', '.play-trailer', function (e) {
        e.preventDefault();

        var videoId = $(this).data('video-id');
        var title = $(this).data('title');

        var player = $('#video-player');

        var contentHTML = $('<div class="embed-responsive embed-responsive-16by9"><iframe id="ytplayer" type="text/html" width="100%" src="" frameborder="0"></iframe></div>');

        contentHTML.find('iframe').attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&fs=1');

        player.find('h4').html(title);
        player.find('.modal-body').html(contentHTML);
        player.modal('show');
        player.on('hidden.bs.modal', function(){
            player.find('.modal-body').html('');
        });
    })
});