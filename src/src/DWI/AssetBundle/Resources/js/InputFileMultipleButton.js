$(function() {
    $('body').on('mousedown', '.file-multiple', function() {
        $(this).find('.btn').addClass('active');
    });

    $('body').on('mouseup', '.file-multiple', function() {
        $(this).find('.btn').removeClass('active');
    });

    $('body').on('mouseover', '.file-multiple', function() {
        $(this).find('.btn').addClass('hover');
    });

    $('body').on('mouseout', '.file-multiple', function() {
        $(this).find('.btn').removeClass('active');
        $(this).find('.btn').removeClass('hover');
    });
});
