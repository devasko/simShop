<?php

namespace app\models;

use ishop\App;

class Category extends AppModel {

    public function getChildsIds( $currCat ) {

        $cats = App::$app->getProperty( 'cats' );
        $ids = null;

        foreach ( $cats as $key => $cat ) {
            if ( $cat['parent_id'] == $currCat ) {
                $ids .= $key . ',';
                $ids .= $this->getChildsIds( $key );
            }
        }

        return $ids;
    }
}