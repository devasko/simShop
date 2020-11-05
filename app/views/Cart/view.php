<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= PATH; ?>">Главная</a></li>
                <li class="active">Корзина</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

<!--  start-prdt  -->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one cart">
                    <div class="register-top heading">
                        <h2>Оформление заказа</h2>
                    </div>
                    <br><br>
                    <?php if( !empty( $_SESSION['cart'] )): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Фото</th>
                                        <th>Наименование</th>
                                        <th>Кол-во</th>
                                        <th>Цена</th>
                                        <th><span class="glyphicon glyphicon-remove clearCart" aria-hidden="true"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach( $_SESSION['cart'] as $id => $item ): ?>
                                    <tr>
                                        <td><a href="product/<?= $item['alias']; ?>"><img src="images/<?= $item['img']; ?>" alt="<?= $item['title']; ?>"></a></td>
                                        <td><a href="product/<?= $item['alias']; ?>"><?= $item['title']; ?></a></td>
                                        <td><?= $item['qty']; ?></td>
                                        <td><?= $item['price']; ?></td>
                                        <td><a href="/cart/delete/?id=<?= $id; ?>"><span class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></a></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>Итого:</td>
                                    <td colspan="4" class="text-right cart-qty"><?= $_SESSION['cart.qty']; ?></td>
                                </tr>
                                <tr>
                                    <td>На сумму:</td>
                                    <td colspan="4" class="text-right cart-sum"><?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . $_SESSION['cart.currency']['symbol_right']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 account-left">
                            <form action="cart/checkout" method="post" id="signup" role="form" data-toggle="validator">
                                <?php if( !isset( $_SESSION['user'] )): ?>
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
                                    <div class="form-group has-feedback">
                                        <label for="name">Имя</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Имя" value="<?= isset( $_SESSION['form_data']['name'] ) ? h( $_SESSION['form_data']['name'] ) : ''; ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="name">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="email" value="<?= isset( $_SESSION['form_data']['email'] ) ? h( $_SESSION['form_data']['email'] ) : ''; ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="name">Адрес</label>
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Адрес" value="<?= isset( $_SESSION['form_data']['address'] ) ? h( $_SESSION['form_data']['address'] ) : ''; ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="comment">Комментарий к заказу</label>
                                    <textarea name="comment" id="comment" class="form-control" ></textarea>
                                </div>
                                <button type="submit" class="btn btn-default order-btn">Оформить</button>


                                <div class="clearfix"></div>
                            </form>
                            <?php if ( isset( $_SESSION['form_data'] )) unset( $_SESSION['form_data'] ); ?>
                        </div>
                    <?php else: ?>
                        <h3>Корзина пуста</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  ent-prdt -->
