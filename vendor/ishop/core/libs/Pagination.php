<?php

namespace ishop\libs;

class Pagination {

    public $curPage;
    public  $perPage;
    public  $countItems;
    public  $countPages;
    public  $uri;

    public function __construct( $page, $perPage, $countItems ) {

        $this->perPage = $perPage;
        $this->countItems = $countItems;
        $this->countPages = $this->getCountPages();
        $this->curPage = $this->getCurrentPage( $page );
        $this->uri = $this->getParams();
    }
    public function getHtml(  ) {
        $back = null;
        $forward = null;
        $startpage = null;
        $endpage = null;
        $page2left = null;
        $page1left = null;
        $page1right = null;
        $page2right = null;

        if ( $this->curPage > 1 ) {
            $back = "<li><a class='nav-link' href='{$this->uri}page=" . ( $this->curPage - 1 ) . "'>&lt;</a></li>";
        }

        if ( $this->curPage < $this->countPages ) {
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->curPage + 1) . "'>&gt;</a></li>";
        }

        if ( $this->curPage > 3 ) {
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }

        if ( $this->curPage < ( $this->countPages - 2 )) {
            $endpage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";

        }

        if ( $this->curPage - 2 > 0 ) {
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" . ( $this->curPage - 2 ) . "'>" . ( $this->curPage - 2 ) . "</a></li>";
        }

        if ( $this->curPage - 2 > 0 ) {
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" . ( $this->curPage-2 ) . "'>" . ( $this->curPage - 2 ) . "</a></li>";
        }
        if ( $this->curPage - 1 > 0 ) {
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" . ( $this->curPage-1 ) . "'>" . ( $this->curPage-1 ) . "</a></li>";
        }
        if ( $this->curPage + 1 <= $this->countPages ) {
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" . ( $this->curPage + 1 ) . "'>" . ( $this->curPage+1 ) . "</a></li>";
        }
        if( $this->curPage + 2 <= $this->countPages ) {
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" . ( $this->curPage + 2 ) . "'>" . ( $this->curPage + 2 ) . "</a></li>";
        }

        return '<ul class="pagination">' . $startpage.$back.$page2left.$page1left.'<li class="active"><a>' . $this->curPage . '</a></li>' . $page1right . $page2right . $forward . $endpage . '</ul>';
    }

    public function __toString() {
        return $this->getHtml();
    }


    public function getCountPages() {

    return ceil( $this->countItems / $this->perPage ) ?: 1;
}

    public function getCurrentPage( $page ) {

        if ( !$page || $page < 1 ) $page = 1;
        if ( $page > $this->countPages ) $page = $this->countPages;

        return $page;
    }

    public function getStart(  ) {

        return ( $this->curPage - 1 ) * $this->perPage;
    }

    public function getParams(  ) {

        $url = $_SERVER['REQUEST_URI'];
        preg_match_all( "#filter=[\d,&]#", $url, $matches );

        if ( count( $matches[0] ) > 1 ) {
            $url = preg_replace( "#filter=[\d,&]+#", "", $url, 1 );
        }

        $url = explode( '?', $url );
        $uri = $url[0] . '?';

        if ( isset( $url[1] ) && $url[1] !== '' ) {
            $params = explode( '&', $url[1] );

            foreach ( $params as $param ) {
                if ( !preg_match( "#page=#", $param )) $uri .= "{$param}&amp;";
            }
        }
        return urldecode( $uri );
    }
}