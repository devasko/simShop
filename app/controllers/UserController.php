<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController {

    public function signupAction() {
        if ( !empty( $_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load( $data );
            if ( !$user->validate( $data ) || !$user->checkUnique() ) {
                $user->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $user->attributes['password'] = password_hash( $user->attributes['password'], PASSWORD_DEFAULT );
                if ( $id = $user->save( 'user' )) {
                    $_SESSION['success'] = "Пользователь {$data['name']} зарегистрирован!";
                    foreach ( $data as $key => $val ) {
                        $_SESSION['user'][$key] = $val;
                    }
                } else {
                    $_SESSION['error'] = 'Ошбка регистрации';
                }
            }

            redirect( PATH );
        }
        $this->setMeta( 'Регистрация' );
    }

    public function loginAction() {

        if ( !empty( $_POST )) {
            $user = new User();
            if ( $user->login() ) {
                $_SESSION['success'] = 'вы успешно авторизованы';
            } else {
                $_SESSION['error'] = 'Логин или пароль введен неверно';
            }
            redirect();
        }
        $this->setMeta( 'Вход' );
    }

    public function logoutAction() {

        if ( isset( $_SESSION['user'] )) unset( $_SESSION['user'] );
        redirect( PATH );
    }
}