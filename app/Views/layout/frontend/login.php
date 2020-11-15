<div class="showLogin">

</div>

<div class="modal fade" id="userLogin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize"><?= lang('App.frontend.login.login')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="dataLogin">
                <div class="row">
                    <div class="col-6">
                        <h2 class="login__modal-title"><?= lang('App.frontend.login.login')?></h2>
                        <?= form_open(base_url(route_to('postLogin')), ['class' => 'postLoginForm']) ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" name="loginUsername" id="loginUsername">
                            <div class="invalid-feedback loginUsername">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="loginPassword" id="loginPassword">
                            <div class="invalid-feedback loginPassword">

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary text-capitalize btn-sm"><?= lang('App.frontend.login.login')?></button>
                        <?= form_close() ?>

                        <a href="<?= base_url(route_to('infoForgotPassword'))?>" class="text-muted pt-2 d-inline-block">Forgot Password ?</a>
                    </div>
                    <div class="col-6">
                        <h2 class="login__modal-title"><?= lang('App.frontend.login.register')?></h2>
                        <?= form_open(base_url(route_to('postRegister')), ['class' => 'postRegisterForm']) ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label class="text-capitalize" for="exampleInputEmail1"><?= lang('App.frontend.login.fullname')?></label>
                            <input type="text" name="fullname" class="form-control" id="fullname">
                            <div class="invalid-feedback fullname">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-capitalize" for="exampleInputEmail1">Email</label>
                            <input type="text" class="form-control" name="email" id="email"">
                            <div class=" invalid-feedback email">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-capitalize" for="exampleInputEmail1"><?= lang('App.frontend.login.phone')?></label>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <div class="invalid-feedback phone">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                        <div class="invalid-feedback username">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <div class="invalid-feedback password">

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary text-capitalize btn-sm"><?= lang('App.frontend.login.register')?></button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>