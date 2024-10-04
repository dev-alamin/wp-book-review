$ = jQuery;

jQuery(document).ready(function($) {
    $(window).on('load', function() {
        // Hide the loader
        $('.loaderify').fadeOut('slow', function() {
            $(this).remove(); // Optionally remove the loader from the DOM
        });
    });
    
    tinymce.init({
     selector: '.textarea-book-reviwe',
    });


// Store the last clicked value
var lastClickedValue = null;

// Handle click event
$('.review-star-icon input[type="radio"]').on("click", function () {
    lastClickedValue = $(this).val(); // Store the value of the clicked radio button
    var parentDiv = $(this).closest('.review-star-icon'); // Get the parent div containing the stars

    // Remove 'active' class from all stars first
    parentDiv.find('.star').removeClass('active');

    // Add 'active' class to the first N stars, where N is the value of the clicked radio button
    parentDiv.find('.star').slice(0, lastClickedValue).addClass('active');
});

// Handle hover (mouseenter)
$('.review-star-icon input[type="radio"]').on("mouseenter", function () {
    var selectedValue = $(this).val(); // Get the value of the hovered radio button
    var parentDiv = $(this).closest('.review-star-icon'); // Get the parent div containing the stars

    // Remove 'active' class from all stars first
    parentDiv.find('.star').removeClass('active');

    // Add 'active' class to the first N stars, where N is the value of the hovered radio button
    parentDiv.find('.star').slice(0, selectedValue).addClass('active');
});

// Handle mouseleave to revert back to the clicked state
$('.review-star-icon input[type="radio"]').on("mouseleave", function () {
    var parentDiv = $(this).closest('.review-star-icon'); // Get the parent div containing the stars

    // Remove 'active' class from all stars first
    parentDiv.find('.star').removeClass('active');

    // If a value was clicked before, restore the active stars based on the last clicked value
    if (lastClickedValue) {
        parentDiv.find('.star').slice(0, lastClickedValue).addClass('active');
    }
});

    

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

    // Initialize Select2 for the select dropdown
    $('.select2').select2();

    // Initialize TinyMCE for the review content textarea

    tinymce.init({
        selector: 'textarea#review-content',
        height: 200,
        menubar: false,
        block_formats: 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            'textcolor',
            'toc'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic underline strikethrough | ' +
            'forecolor backcolor | removeformat | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' +
            'blockquote | link unlink | image media | ' +
            'table | hr | toc | ' +
            'code | fullscreen | help | ' +
            'heading1 heading2 heading3 | paragraph', // Add heading and paragraph options
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
    });

    
    

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
                // $('body').css('background-color', 'white');
                $("#wbrfs_overlay").fadeIn(300);
            },
            success: function(response) {
                if (response.success === false ) {
                    $("#wbrfs_overlay").fadeOut(300);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                    });
                    
                } else {
                    $("#wbrfs_overlay").fadeOut(300);
                    // If no error, display success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your review has been submitted successfully.',
                    });
                    // console.log(response);
                    form[0].reset();
                    form.find(':input').not(':button, :submit, :reset, :hidden').val('');
                    $(".picture__image").empty();
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

    // Handle form submission via AJAX
    $('#review-edit-form').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var formData = new FormData(form[0]); // Create FormData object from form
        
        formData.append('nonce', $('#review-nonce').val());
        formData.append('action', 'edit_review');
        
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
                $("#wbrfs_overlay").fadeIn(300);
            },
            success: function(response) {
                if (response.success === false) {
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
                        text: 'Your review has been updated successfully.',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while updating your review. Please try again later.',
                });
            },
            complete: function() {
                // Re-enable submit button and hide loading spinner if needed
                submitButton.prop('disabled', false);
                $("#wbrfs_overlay").fadeOut(300);
            }
        });
    });

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
jQuery(document).ready(function($) {
    // Delegate click event to a parent element that exists on page load
    $(document).on('click', '.wbr_author_review_pagination', function() {
        var page = $(this).data('page');
        var author_id = wbrFrontendScripts.CurrentAuthor;
    
        $.ajax({
            url: wbrFrontendScripts.ajaxUrl,
            type: 'POST',
            data: {
                action: 'load_author_reviews',
                author_id: author_id,
                page: page
            },
            success: function(response) {
                $('#reviews-table').find('tr:gt(0)').remove();
                $('#reviews-table').append(response);
            }
        });
    });
    
    // Delegate click event to a parent element that exists on page load
    $(document).on('click', '.wbrDeleteRequestReview', function(e) {
        e.preventDefault();
        var postId = $(this).data('id'); // Get the post ID from the data attribute of the clicked element
        var data = {
            action: 'wbr_set_review_status',
            post_id: postId
        };

        // Send AJAX request
        $.post(wbrFrontendScripts.ajaxUrl, data, function(response) {
            // Alert success or error message
            if (response.success) {
                if (response.success === false) {
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
                        text: 'Your request for deletion has been sent successfully.',
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while sending request for deletion. Please try again later.',
                });
            }
        });
    });
});




document.querySelectorAll('.wbr_author_review_pagination').forEach(function (ele, idx) {
    ele.addEventListener('click', function (e) {
        var clickedEle = document.querySelector('.wbr_author_review_pagination.current');
        console.log( this);
        if (clickedEle != null)
            clickedEle.classList.remove('current');

        this.classList.add('current');
    })
});

jQuery(document).ready(function($) {
    new WOW().init();

    $('.wbr-archive-slider').slick({
        autoplay:4000,
        speed:1000,
        arrows:true,
        prevArrow:'<button type="button" class="slick-slider-prev"></button>',
        nextArrow:'<button type="button" class="slick-slider-next"></button>',
        slidesToShow:1,
        slidesToScroll:1,
        dots:true,
    });

// Recent Featured Review Slider
$('.recent-featured-review-list').slick({
    autoplay: false,
    speed: 1000,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    infinite: false,
    prevArrow: $('.recent-prev-btn'),
    nextArrow: $('.recent-next-btn'),
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 320,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

// Featured Slider Book
$('.featured-slider-book').slick({
    autoplay: false,
    speed: 1000,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    infinite: false,
    prevArrow: $('.book-prev-btn'),
    nextArrow: $('.book-next-btn'),
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 320,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

// Video Slider Review
$('.video-slider-review').slick({
    autoplay: false,
    speed: 1000,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    infinite: false,
    prevArrow: $('.video-prev-btn'),
    nextArrow: $('.video-next-btn'),
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 320,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

// campaign-review-slider
$('.campaign-review-slider').slick({
    autoplay: false,
    speed: 1000,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    infinite: false,
    prevArrow: $('.recent-campaign-prev-btn'),
    nextArrow: $('.recent-campaign-next-btn'),
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 320,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});



    var btnPlay = $('.btn-play');

    btnPlay.on("click", function() {
    
        // Pause all videos
        $("video").each(function() {
            this.pause();
        });

        $(".btn-pause").each(function() {
            $(this).removeClass("activated");
        });

        $(".btn-play").each(function() {
            $(this).addClass("activated");
        });

        var parentClass = $(this).parent().parent();

       var pauseBtn = parentClass.find(".btn-pause");

       pauseBtn.addClass("activated");
    
        var video = parentClass.find("video")[0];
    
        if (video.paused) {
            video.play();
        }
    
        $(this).removeClass("activated");
    });
    
    var btnPause = $('.btn-pause');
    
    btnPause.on("click", function() {
    
        var parentClass = $(this).parent().parent();

        var playBtn = parentClass.find(".btn-play");

        playBtn.addClass("activated");
        
        var video = parentClass.find("video")[0];
    
        if (video.play) {
            video.pause();
        }
    
        $(this).removeClass("activated");

    });
    


});

