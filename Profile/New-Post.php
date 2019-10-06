<?php

?>
<div class="container">
    <form action="" method="post">
        <div class="row col-10 mx-auto">
            <div class="col form-group">
                <div class="form-group mb-1">
                  <textarea class="form-control btn-outline-secondary text-dark bg-light px-4 py-3" name="post" id="post" rows="3" style="resize:none;" placeholder="What do you think?"></textarea>
                </div>

                <div class="row">


                     <div class="input-group col-5 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="postImg">
                            <label class="custom-file-label" for="customFile">Add an image</label>
                        </div>
                    </div>

                    <div class="input-group col-4 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                        </div>
                        <select name="cars" class="form-control custom-select text-center"><!--user can include his saved code in a post-->
                            <option selected>no code is selected</option>
                            <option value="volvo">Volvo</option>
                            <option value="fiat">Fiat</option>
                            <option value="audi">Audi</option>
                        </select>
                    </div>

                    <button type="submit" name="submit" value="post" class="btn btn-light text-dark btn-outline-white border-secondary  ml-auto col-2 mr-3"> <i class="far fa-paper-plane ml-0 mr-1"></i> Post</button>

                </div>
            </div>
        </div>
    </form>
</div>