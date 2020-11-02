<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= PATH; ?>">Главная</a></li>
                <li class="active">Вход</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

<!--  start-product  -->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one login">
                    <div class="register-top heading">
                        <h2>Вход</h2>
                    </div>
                    <div class="register-main">
                        <div class="col-md-6 account-left">
                            <form action="user/login" method="post" id="login" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <label for="login">Логин</label>
                                    <input type="text" name="login" class="form-control" id="login" placeholder="Логин" value="<?= isset( $_SESSION['form_data']['login'] ) ? h( $_SESSION['form_data']['login'] ) : ''; ?>" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="password">Пароль</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Пароль" data-error="Паролоть должен быть не менее 6 символов" data-minlength="6" value="<?= isset( $_SESSION['form_data']['password'] ) ? h( $_SESSION['form_data']['password'] ) : ''; ?>" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="clearfix"></div>
                                <button type="submit" class="btn btn-default" value="Submit">Войти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  ent-product  -->
