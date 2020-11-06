<?php

namespace app\models;

use app\A;
use Illuminate\Support\Facades\App;
use RedBeanPHP\R;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Order extends AppModel {

    public  $attributes = [
        'user_id' => '',
        'currency' => '',
        'note' => '',
    ];

    public static function saveOrder( $order_data ) {

            $order = new self();
            $order->load( $order_data );
            $order_id = $order->save( 'order' );
            self::saveOrderProduct( $order_id );
            return $order_id;
    }

    public static function saveOrderProduct( $order_id ) {

        $sql_part = '';
        foreach ( $_SESSION['cart'] as $product_id => $product ) {
            $product_id = (int)$product_id;
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}), ";
        }

        $sql_part = rtrim( $sql_part, ', ' );
        R::exec( "INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
    }

    public static function mailOrder( $order_id, $user_email ) {

        // Create the Transport
        $transport = ( new Swift_SmtpTransport( \ishop\App::$app->getProperty( 'smtp_host' ), \ishop\App::$app->getProperty( 'smtp_port'), \ishop\App::$app->getProperty( 'smtp_protocol' )))
            ->setUsername( \ishop\App::$app->getProperty( 'smtp_login' ))
            ->setPassword( \ishop\App::$app->getProperty( 'smtp_password' ));

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        ob_start();
        require \APP . '/views/mail/mail_order.php';
        $body = ob_get_clean();

        // The message to client
        $message_client = (new Swift_Message( "Ваш заказ №{$order_id} на сайте " . \ishop\App::$app->getProperty( 'shop_name' ) . " принят" ))
            ->setFrom([\ishop\App::$app->getProperty( 'smtp_login' ) => \ishop\App::$app->getProperty( 'shop_name' )])
            ->setTo( $user_email )
            ->setBody( $body, 'text/html' );

        // Send the message to admin
        $message_admin = (new Swift_Message( "Сделан заказ №{$order_id}" ))
            ->setFrom([\ishop\App::$app->getProperty( 'smtp_login' ) => \ishop\App::$app->getProperty( 'shop_name' )])
            ->setTo( \ishop\App::$app->getProperty( 'admin_email' ))
            ->setBody( $body, 'text/html' );

        // Send the message to client
        $result = $mailer->send( $message_client );

        // Send the message to admin
        $result = $mailer->send( $message_admin );
        unset( $_SESSION['cart'] );
        unset( $_SESSION['cart.qty'] );
        unset( $_SESSION['cart.sum'] );
        unset( $_SESSION['cart.currency'] );
        $_SESSION['success'] = 'Спасибо за Ваш заказ, в ближайшее время с Вами свяжется наш менеджер.';
    }
}