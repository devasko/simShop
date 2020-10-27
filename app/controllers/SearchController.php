<?php

namespace app\controllers;

use RedBeanPHP\R;

class SearchController extends AppController {

    public function indexAction() {

        $query = !empty( trim( $_GET['search'] )) ? trim( $_GET['search'] ) : null;

        if ( $query ) {
            $products = R::find( 'product', "title LIKE ?", ["%{$query}%"] );
        }
        $this->setMeta( 'Поиск: ' . h( $query ) );
        $this->set( compact( 'products', 'query' ));
    }

    public function typeaheadAction() {

        if ( $this->isAjax() ) {
            $query = !empty( trim( $_GET['query'] )) ? trim( $_GET['query'] ) : null;

            if ( $query ) {
                $products = R::getAll( 'SELECT id, title FROM product WHERE title LIKE ? LIMIT 11', ["%{$query}%"] );
                echo json_encode( $products );
            }
        }
        die;
    }
}