<?php

?>
<div class="container">
    <form action="" method="post" enctype="multipart/form-data">
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
                            <input type="file" accept=".png,.gif,.jpeg,.jpg,.bmp" class="custom-file-input" id="customFile" name="postImg">
                            <label class="custom-file-label" for="customFile">Add an image</label>
                        </div>
                    </div>

                    <div class="input-group col-4 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                        </div>
                        <select name="CodeID" class="form-control custom-select text-center"><!--user can include his saved code in a post-->
                            <option selected value="">no code is selected</option>
                            <?php 
                            $GetUserCodes=$mysqli->query("SELECT id,name,langType FROM codes WHERE username='$username' order by date desc");
                            while($row=$GetUserCodes->fetch_assoc()){
                                switch($row['langType']){
                                case 'cpp':
                                    echo '<option value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(1,1,1,0.5);color:white;"><span class="badge badge-light">C++/</span> '.$row['name'].'</option>';
                                    break;
                                case 'c':
                                    echo '<option value="'.$row['id'].'"><span class="badge badge-dark">C/</span> '.$row['name'].'</option>';
                                    break;
                                case 'java':
                                    echo '<option value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(153,51,51,0.5);"><span class="badge badge-danger">Java/</span> '.$row['name'].'</option>';
                                    break;
                                case 'html':
                                    echo '<option value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(255,153,51,0.5);"><span class="badge badge-warning text-warning">Web/</span> '.$row['name'].'</option>';
                                    break;
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <button id="GOPOST" type="submit" name="submit" value="post" class="btn btn-light text-dark btn-outline-white border-secondary  ml-auto col-2 mr-3"> <i class="far fa-paper-plane ml-0 mr-1"></i> Post</button>

                </div>
            </div>
        </div>
    </form>
</div>