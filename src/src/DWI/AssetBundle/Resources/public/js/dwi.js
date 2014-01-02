$(function() {
    $('.txt-medium-editable').each(function(){
        var $this = $(this);
        var params = {
            'buttons': ['bold', 'italic', 'underline', 'header1', 'header2', 'quote'],
            'placeholder': $this.attr('placeholder'),
            'firstHeader': 'h2',
            'secondHeader': 'h3'
        }

        $('<div>' + $this.text() + '</div>')
            .attr('class', $this.attr('class'))
            .addClass('medium-editable')
            .removeClass('txt-medium-editable')
            .attr('data-name', $this.attr('name'))
            .insertBefore(this);

        $this.hide();

        var editor = new MediumEditor('.medium-editable', params);
    });

    $('.medium-editable').bind('keyup', function(event) {
        $this = $(this);
        $("[name='" + $this.data('name') + "']").val($this.html());
    });

    $('.medium-editor-action').click(function() {
        $('.medium-editable').each(function() {
            $this = $(this);
            $("[name='" + $this.data('name') + "']").val($this.html());
        });
    });
});
