<div class="wbr-featured-image-container">
    <!-- <label for="product-image-id" class="custom-file-upload">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" transform="rotate(180)">
        <path fill="none" d="M0 0h24v24H0z"/>
        <path d="M18 12v-2h-5V5h-2v5H6l6 6 6-6zm-6 8h4v2H8v-2z"/>
    </svg>

        <span id="selected-file-name">Choose featured image</span>
        <input onchange="previewImage(this)" class="file-input-custom form-control"   name="product-image-id"  id="product-image-id"  type="file"  class="input"  accept="image/*">
    </label> -->

    <!-- <div id="image-preview-container">
        <img id="image-preview" src="#" alt="Preview" style="display: none; width: 100px; height: 60px;">
    </div>   -->
    <label class="picture" for="product-image-id" tabIndex="0">
        <span class="picture__image"></span>
    </label>

    <input type="file" name="product-image-id" id="product-image-id">

    
</div>     
             
    <script> 
            // function previewImage(input) {
            //     var file = input.files[0];
            //     var reader = new FileReader();
            
            //     reader.onload = function(e) {
            //     var imagePreview = document.getElementById('image-preview');
            //     imagePreview.src = e.target.result;
            //     imagePreview.style.display = 'block';
            //     };
            
            //     reader.readAsDataURL(file);
            //     document.getElementById('selected-file-name').textContent = file.name;
            // }

            const inputFile = document.querySelector("#product-image-id");
            const pictureImage = document.querySelector(".picture__image");
            const pictureImageTxt = "Choose an image";
            pictureImage.innerHTML = pictureImageTxt;

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

    </script>