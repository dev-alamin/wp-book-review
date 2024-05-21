<div class="wbr-featured-image-container">
    <label class="picture" for="product-image-id" tabIndex="0">
        <span class="picture__image"></span>
    </label>
    <input type="file" name="product-image-id" id="product-image-id">
    <input type="hidden" id="review-id" value="<?php echo isset($_GET['reviewid']) ? esc_attr($_GET['reviewid']) : ''; ?>">
</div>

<script> 
    document.addEventListener("DOMContentLoaded", function() {
        const inputFile = document.querySelector("#product-image-id");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = "Choose an image";

        inputFile.addEventListener("change", function (e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function (e) {
                    const readerTarget = e.target;

                    const img = document.createElement("img");
                    img.src = readerTarget.result;
                    img.classList.add("picture__img");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });

        // Fetch post thumbnail image if review ID is provided
        const reviewId = document.querySelector("#review-id").value;
        if (reviewId) {
            <?php
            $thumbnail_src = '';
            $review_id = isset($_GET['reviewid']) ? intval($_GET['reviewid']) : 0;
            if ($review_id) {
                $thumbnail_id = get_post_thumbnail_id($review_id);
                if ($thumbnail_id) {
                    $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full');
                    $thumbnail_src = isset($thumbnail_src[0]) ? $thumbnail_src[0] : '';
                }
            }
            ?>
            if ("<?php echo $thumbnail_src; ?>") {
                const img = document.createElement("img");
                img.src = "<?php echo $thumbnail_src; ?>";
                img.classList.add("picture__img");
                pictureImage.innerHTML = "";
                pictureImage.appendChild(img);
            }
        }
    });
</script>
