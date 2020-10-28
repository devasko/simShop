<?php

namespace app\controllers;

use app\A;
use app\models\Category;
use RedBeanPHP\R;

class CategoryController extends AppController {

    public function viewAction() {

        $alias = $this->route['alias'];
        $category = R::findOne( 'category', 'alias = ?', [$alias] );
//        debug( $category );

        if ( !$category ) {
            throw new \Exception('Категория не найдена', 404);
        }

//        Хлебные крошки
        $breadcrumbs = '';

        $cat_model = new Category();
        $childsIds = $cat_model->getChildsIds( $category->id );
        $childsIds = !$childsIds ? $category->id : $childsIds . $category->id;

        $products = R::find(  'product',"category_id IN ( $childsIds )" );

        $this->setMeta( $category->title, $category->description, $category->keywords );
        $this->set( compact( 'products', 'breadcrumbs', 'category' ));

    }

}