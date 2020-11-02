<?php

namespace app\models;

use ishop\App;

class Breadcrumbs {

    public static function getBreadcrumbs( $category_id, $name = '' ) {

        $cats = App::$app->getProperty( 'cats' );
        $breadcrumbs_arr = self::setParts( $cats, $category_id );
        $breadcrumbs = "<li><a href='" . PATH . "/'>Главная</a> </li>";
        if ( $breadcrumbs_arr ) {
            foreach ( $breadcrumbs_arr as $alias => $title ) {
                $breadcrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";
            }
        }

        if ( $name ) {
            $breadcrumbs .= "<li class='active'>$name</li>";
        }

        return $breadcrumbs;
    }

    public static function setParts( $cats, $id ) {
        if ( !$id ) return false;

        $breadcrumbs = [];

        foreach ( $cats as $key => $cat ) {
            if ( isset( $cats[$id] )) {
                $breadcrumbs[$cats[$id]['alias']] = $cats[$id]['title'];
                $id = $cats[$id]['parent_id'];
            } else break;
        }

        return array_reverse( $breadcrumbs, true );
    }
}