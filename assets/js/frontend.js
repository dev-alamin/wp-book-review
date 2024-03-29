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

    // Initialize Select2 for the select dropdown
    $('.select2').select2();

    // Initialize TinyMCE for the review content textarea

    // tinymce.init({
    //     selector: 'textarea#review-content',
    //     height: 200,
    //     menubar: false,
    //     block_formats: 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;',
    //     plugins: [
    //         'advlist autolink lists link image charmap print preview anchor',
    //         'searchreplace visualblocks code fullscreen',
    //         'insertdatetime media table paste code help wordcount',
    //         'textcolor',
    //         'toc'
    //     ],
    //     toolbar: 'undo redo | formatselect | ' +
    //         'bold italic underline strikethrough | ' +
    //         'forecolor backcolor | removeformat | ' +
    //         'alignleft aligncenter alignright alignjustify | ' +
    //         'bullist numlist outdent indent | ' +
    //         'blockquote | link unlink | image media | ' +
    //         'table | hr | toc | ' +
    //         'code | fullscreen | help | ' +
    //         'heading1 heading2 heading3 | paragraph', // Add heading and paragraph options
    //     content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
    // });

    
    

    // Handle form submission via AJAX
    $('#review-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = new FormData(form[0]); // Create FormData object from form
        
        // Add nonce to form data
        formData.append('nonce', $('#review-nonce').val());
        // Add action to form data
        formData.append('action', 'submit_review');
        
        var submitButton = form.find('input[type="submit"]');
        
        // AJAX request
        $.ajax({
            type: 'POST',
            url: wbrFrontendScripts.ajaxUrl,
            data: formData,
            contentType: false, // Don't set contentType, let jQuery handle it automatically
            processData: false, // Don't process data, let jQuery handle it automatically
            beforeSend: function() {
                // Disable submit button and show loading spinner if needed
                submitButton.prop('disabled', true);
            },
            success: function(response) {
                if (response.success === false ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                    });
                } else {
                    // If no error, display success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your review has been submitted successfully.',
                    });
                    console.log(response);
                    form[0].reset();
                    form.find(':input').not(':button, :submit, :reset, :hidden').val('');

                }
            },
            error: function(xhr, status, error) {
                // Log detailed error information
                console.error('AJAX Request Error:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Text:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while submitting your review. Please try again later.',
                });
            },
            complete: function() {
                // Re-enable submit button and hide loading spinner if needed
                submitButton.prop('disabled', false);
            }
        });
    });
    
    /**
     * File upload beautifier
     */
        var droppedFiles = false;
        var fileName = '';
        var $dropzone = $('.dropzone');
        var $button = $('.upload-btn');
        var uploading = false;
        var $syncing = $('.syncing');
        var $done = $('.done');
        var $bar = $('.bar');
        var timeOut;

        $dropzone.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        })
        .on('dragover dragenter', function() {
        $dropzone.addClass('is-dragover');
        })
        .on('dragleave dragend drop', function() {
        $dropzone.removeClass('is-dragover');
        })
        .on('drop', function(e) {
        droppedFiles = e.originalEvent.dataTransfer.files;
        fileName = droppedFiles[0]['name'];
        $('.filename').html(fileName);
        $('.dropzone .upload').hide();
        });

        $button.bind('click', function() {
        startUpload();
        });

        $("input:file").change(function (){
        fileName = $(this)[0].files[0].name;
        $('.filename').html(fileName);
        $('.dropzone .upload').hide();
        });

        function startUpload() {
        if (!uploading && fileName != '' ) {
            uploading = true;
            $button.html('Uploading...');
            $dropzone.fadeOut();
            $syncing.addClass('active');
            $done.addClass('active');
            $bar.addClass('active');
            timeoutID = window.setTimeout(showDone, 3200);
        }
        }

        function showDone() {
        $button.html('Done');
        }
      
        /**
         * Review form toggler btn
         * 
         */
        $('.wbr-review-form-toggler button.old-user').on('click', function(){
            $('#review-submission-form').slideToggle();
        });

        /**
         * Handle user agreement form / Popup
         * 
         */
        $('#ff_user_agreement_form').on('submit', function(event) {
            // Prevent default form submission
            event.preventDefault();
            
            // Check if the agreement checkbox is checked
            if ($('#agreement').is(':checked')) {
                $.ajax({
                    url: wbrFrontendScripts.ajaxUrl, // WordPress AJAX URL
                    type: 'POST',
                    data: {
                        action: 'update_user_agreement', // Custom AJAX action name
                        user_agreement_consent: 1, // Value to be saved in the metadata
                        ff_user_agreement_nonce_field: $('#ff_user_agreement_nonce_field').val(), // Include nonce value
                    },
                    success: function(response) {
                        $('#wbrUserAgreement').modal('hide');

                        if( response.success == true ){
                            setTimeout(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Thank you for your confirmation. Now you can submit your reviews.',
                                });

                                $('#review-submission-form').slideToggle();
                                $('.first-reviewer').removeClass('first-reviewer').addClass('old-user');    
                            }, 1000); 

                        }else{
                            setTimeout(() => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.data,
                                });
                            }, 1000); 
                        }
                                               
                    },
                    error: function(error) {
                        swal("Error!", "An error occurred while saving agreement.", "error");
                    }
                });
            } else {
                // If agreement checkbox is not checked, display SweetAlert error message
                swal("Error!", "Please check the agreement checkbox before proceeding.", "error");
            }
        });
        
        
});