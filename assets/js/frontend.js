jQuery(document).ready(function($) {

    var page = 2; // Set the initial page value
    var loading = false;
    
var page = 2; // Set the initial page value
var loading = false;

$(document).on('click', '#load-more-reviews', function () {
    if (!loading) {
        loading = true;

        // Show loading indicator
        $('#load-more-reviews').text('Loading Reviews...');

        $.ajax({
            type: 'POST',
            url: wbrFrontendScripts.ajaxUrl,
            data: {
                action: 'load_more_reviews',
                page: page,
            },
            success: function (response) {
                try {
                    // Attempt to append the response to the container
                    $('#reviews-container').append(response);

                    // Increment the page value for the next request
                    page++;

                    // Check if all posts have loaded, then remove the button
                    if (response.trim() === '') {
                        $('#load-more-reviews').parent().remove();
                    }
                } catch (error) {
                    // Log any parsing or rendering errors
                    console.error('Error appending response to container:', error);
                } finally {
                    // Reset the loading flag
                    loading = false;

                    // Restore the original button text
                    $('#load-more-reviews').text('Load More Reviews');
                }
            },
            error: function (error) {
                // Handle AJAX errors
                console.error('AJAX request failed:', error);

                // Reset the loading flag
                loading = false;

                // Restore the original button text
                $('#load-more-reviews').text('Load More Reviews');
            },
        });
    }
});

    

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