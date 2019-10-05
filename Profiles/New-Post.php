<?php

?>
<div class="container">
    <form action="" method="post">
        <div class="row col-10 mx-auto">
            <div class="col form-group">
                <div class="form-group mb-1">
                  <textarea class="form-control btn-outline-secondary bg-light px-4 py-3" name="post" id="post" rows="3" style="resize:none;" placeholder="What do you think?"></textarea>
                </div>
                <div class="custom-file mb-2 col-4">
                    <input type="file" class="custom-file-input" id="customFile" name="postImg">
                    <label class="custom-file-label" for="customFile">Add an image</label>
                </div>
                 <button type="submit" name="submit" value="post" class="btn btn-light text-dark btn-outline-white border-secondary  mt-n5 col-2 btn-block ml-auto "> <i class="far fa-paper-plane ml-0 mr-1"></i> Post</button>
            </div>
        </div>
    </form>
</div>