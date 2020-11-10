<?php

namespace app\widgets\filter;

use ishop\Cache;
use RedBeanPHP\R;

class Filter {

    public $groups;
    public $attrs;
    public $tpl;

    public function __construct() {

        $this->tpl = APP . '/views/Filter/filter_tpl.php';
        $this->run();
    }
    protected  function  run() {

        $cache = Cache::instance();
        $this->groups = $cache->get( 'filter_group' );

        if ( !$this->groups ) {
            $this->groups = $this->getGroups();
            $cache->set( 'filter_group', $this->groups, 30 );
        }

        $this->attrs = $cache->get( 'filter_attrs' );

        if ( !$this->attrs ) {
            $this->attrs = self::getAttrs();
            $cache->set( 'filter_attrs', $this->attrs, 30 );
        }
        $filters = $this->getHtml();
        echo $filters;
    }

    protected function getHtml() {

        ob_start();

        $filter = self::getFilter();

        if ( !empty( $filter )) {
            $filter = rtrim( $filter, ',' );
            $filter = explode( ',', $filter );
        }
        require $this->tpl;
        return ob_get_clean();
    }

    protected function getGroups() {
        return R::getAssoc( 'SELECT id, title FROM attribute_group' );
    }

    protected static function getAttrs() {
        $data = R::getAssoc( 'SELECT * FROM attribute_value' );
        $attrs = [];
        foreach ( $data as $key => $val ) {
            $attrs[$val['attr_group_id']][$key] = $val['value'];
        }
        return $attrs;
    }

    public static function getFilter() {
        $filter = null;

        if ( !empty( $_GET['filter'] )) {
            $filter = preg_replace( "#[^\d,]+#", '', $_GET['filter'] );

            $filter = trim( $filter, ',' );
        }

        return $filter;
    }

    public static function getCountGroups( $filter ) {
        $filters = explode( ',', $filter );
        $cache = Cache::instance();
        $attrs = $cache->get( 'filter_attrs' );
        if ( !$attrs ) {
            $attrs = self::getAttrs();
        }
        $data = [];
        foreach ( $attrs as $key => $attr ) {
            foreach ( $attr as $index => $val ) {
                if ( in_array( $index, $filters )) {
                    $data[] = $key;
                    break;
                }
            }
        }
        
        return count( $data );
    }
}