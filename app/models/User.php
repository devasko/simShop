<?php

namespace app\models;

use RedBeanPHP\R;

class User extends AppModel {

    public  $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
    ];

    public  $rules = [
        'required'=> [
            ['login'],
            ['password'],
            ['name'],
            ['email'],
            ['address'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ],
    ];

    public function checkUnique() {

        $user = R::findOne( 'user', 'login = ? OR email = ?', [$this->attributes['login'], $this->attributes['email']] );

        if ( $user ) {
            if ( $user->login == $this->attributes['login'] ) {
                $this->errors['unique'][] = 'Введенный логин уже занят';
            }

            if ( $user->email == $this->attributes['email'] ) {
                $this->errors['unique'][] = 'Введенный email уже зарегистрирован';
            }
            return false;
        }
        return true;
    }

    public function login( $isAdmin = false ) {
        $login = !empty( trim( $_POST['login'] )) ? trim( $_POST['login'] ) : null;
        $password = !empty( trim( $_POST['password'] )) ? trim( $_POST['password'] ) : null;
        if ( $login && $password ) {
            if ( $isAdmin ) {
                $user = R::findOne( 'user', "login = ? AND role = 'admin'", [$login, $password] );
            } else {
                $user = R::findOne( 'user', "login = ?", [$login] );

            }

            if ( $user ) {
                if ( password_verify( $password, $user->password )) {
                    foreach ( $user as $key => $val ) {
                        if ( $key != 'password' ) $_SESSION['user'][$key] = $val;
                     }
                    return true;
                }
            }
        }

        return false;
    }

    public static function checkAuth() {

        return isset( $_SESSION['user'] );
    }

    public static function isAdmin() {

        return ( isset( $_SESSION['user'] ) && ( $_SESSION['user']['role'] === 'admin' ));
    }
}