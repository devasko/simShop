<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use ishop\App;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class CategoryController extends AppController {

    public function viewAction() {

        $alias = $this->route['alias'];
        $category = R::findOne( 'category', 'alias = ?', [$alias] );

        if ( !$category ) {
            throw new \Exception('Категория не найдена', 404);
        }

        // Хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs( $category->id );

        $cat_model = new Category();
        $childsIds = $cat_model->getChildsIds( $category->id );
        $childsIds = !$childsIds ? $category->id : $childsIds . $category->id;

        // Пагинация
        $page = isset( $_GET['page'] ) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty( 'pagination' );
        $countItems = R::count( 'product', "category_id IN ( $childsIds )" );

        $pagination = new Pagination( $page, $perpage, $countItems );
        $start = $pagination->getStart();

        $products = R::find(  'product',"category_id IN ( $childsIds ) LIMIT $start, $perpage");
        $this->setMeta( $category->title, $category->description, $category->keywords );
        $this->set( compact( 'products', 'breadcrumbs', 'category', 'pagination', 'countItems' ));

    }

}