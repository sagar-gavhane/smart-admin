<?= $header; ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="row">
                    <div class="login-block">
                        <form id="login-form" action="<?=  base_url().'login/check'; ?>" method="post" autocomplete="on">
                            <!-- login heading -->
                            <h2 class="login-block__login-heading">Login</h2>

                            <!-- email address -->
                            <div class="form-group">
                                <label class="control-label label-required">Email Address</label>
                                <input type="email" class="form-control" name="email_address" placeholder="Email address">
                            </div>

                            <!-- password -->
                            <div class="form-group">
                                <label class="control-label label-required">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>

                            <!-- submit -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $footer; ?>
