<nav class="navbar navbar-expand-md bg-dark navbar-dark py-3 mb-3">
    <a class="navbar-brand" href=""><span class="letter" style="font-size: 28px;">Code</span>NetworK </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"> <i class="fa fa-arrow-down "></i> </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">

        <form method="post" action="./Login/index.php" class="form-inline my-1 my-lg-0 mr-sm-4 ml-md-auto mx-md-0">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark"> <i class="fa fa-user btn-dark" aria-hidden="true"></i>
                    </span>
                </div>
                <input class="form-control mr-sm-2 bg-dark text-light border-top-0 border-right-0 border-left-0" type="email" name="LogEmail" placeholder="E-mail Address" required>
            </div>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark"> <i class="fa fa-key btn-dark" aria-hidden="true"></i>
                    </span>
                </div>
                <input class="form-control mr-sm-2 bg-dark text-light border-top-0 border-right-0 border-left-0" type="password" name="LogPass" placeholder="Password">
            </div>

            <div class="input-group">
                <button type="submit" name="loginbtn" value="yupe" class="btn btn-dark btn-outline-light my-2 my-sm-0"><i class="fa fa-arrow-right" aria-hidden="true"></i> Login</button>
            </div>
        </form>

    </div>
</nav>