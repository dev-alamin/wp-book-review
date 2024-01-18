jQuery(document).ready(function($) {
    $('.show-more-btn').click(function() {
        var button = $(this);
        var commentId = button.data('comment-id');
        var fullCommentContainer = button.siblings('.full-comment');

        // Check if the full comment content is already loaded
        if (fullCommentContainer.is(':empty')) {
            // Use AJAX to fetch the full comment content
            $.ajax({
                url: wbrFrontendScripts.ajaxUrl, // WordPress AJAX URL
                type: 'POST',
                data: {
                    action: 'get_full_comment_content',
                    comment_id: commentId,
                },
                success: function(response) {
                    fullCommentContainer.html(response);
                    fullCommentContainer.slideDown();
                    button.siblings('.show-less-btn').show();
                    button.hide();
                },
            });
        } else {
            // Full comment content is already loaded, toggle visibility
            fullCommentContainer.slideToggle();
            button.siblings('.show-less-btn').toggle();
            button.hide();
        }
    });

    // Add click event for "Show Less" button
    $('.show-less-btn').click(function() {
        var button = $(this);
        var commentId = button.data('comment-id');
        var fullCommentContainer = button.siblings('.full-comment');

        // Toggle visibility of full and truncated comment content
        fullCommentContainer.slideToggle();
        button.siblings('.show-more-btn').toggle();
        button.hide();
    });

    $(document).ready(function() {
        new SimpleBar($('.wpr-card-body'));
        new SimpleBar($('.wpr-card-header'));
      });
});