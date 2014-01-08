$(function() {
    $('.file-multiple').mousedown(function() {
        $(this).find('.btn').addClass('active');
    }).mouseup(function() {
        $(this).find('.btn').removeClass('active');
    });

    $('.file-multiple').mouseover(function() {
        $(this).find('.btn').addClass('hover');
    }).mouseout(function() {
        $(this).find('.btn').removeClass('hover');
    });
});
