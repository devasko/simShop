<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Product;
use RedBeanPHP\R;

class ProductController extends AppController {

    public function viewAction() {

     $alias = $this->route['alias'];
     $product = R::findOne( 'product', "alias = ? AND status = '1'", [$alias] );
     if ( !$product ) {
         throw new \Exception( "Страница продукта '{$alias}' не найдена", 404 );
     }

        // Хлебные крошки
     $breadcrumbs = Breadcrumbs::getBreadcrumbs( $product->category_id, $product->title );

        // Связанные товары
     $related = R::getAll( "SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id] );

        // Модификации  товаров
     $mods = R::findAll( 'modification', 'product_id = ?', [$product->id] );

     // Запись в куки запрошенного товара

     $p_model = new Product();

     $p_model->setRecentlyViewed( $product->id );

        // Просмотренные товары из кук
     $viewed = $p_model->getRecentlyViewed();

     $recentlyViewed = null;

     if ( $viewed ) {
         $recentlyViewed = R::find( 'product', 'id IN (' . R::genSlots($viewed) . ') LIMIT 3', $viewed );
     }

        // Галерея
     $gallery = R::findAll( 'gallery', 'product_id = ?', [$product->id] );

        //  Вывод в вид
     $this->setMeta( $product->title, $product->description, $product->keywords );
     $this->set( compact( 'product', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs', 'mods' ));
    }
}