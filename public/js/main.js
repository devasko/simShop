//  Корзина
$( 'body' ).on( 'click', '.add-to-cart-link', function ( e ) {
    e.preventDefault();
    var id = $( this ).data( 'id' ),
        qty = $( '.quantity input' ).val(),
        qty = qty ? qty : 1,
        mod = $( '.available select' ).val();

        $.ajax({
            url: path + '/cart/add',
            data: {id: id, qty: qty, mod: mod},
            type: 'GET',

            success: function ( res ) {
                showCart( res );
            },

            error: function () {
                alert( 'Ошибка! Попробуйте позже' );
            }
        });
});

$( '#cart .modal-body' ).on( 'click', '.del-item', function () {
    var id = $( this ).data( 'id' );
    $.ajax({
       url: 'cart/delete',
       data: {id: id},
       type: 'GET',
       success: function ( res ) {
           showCart( res );
       },
        error: function () {
            alert( 'Ошибка отправки запроса' );
        }
    });
});

function showCart( cart ) {
    if ( $.trim( cart ) == '<h3>Корзина пуста</h3>' ) {
        $( '#cart .modal-footer a, #cart .modal-footer .btn-danger' ).css( 'display', 'none' );
    } else {
        $( '#cart .modal-footer a, #cart .modal-footer .btn-danger' ).css( 'display', 'inline-block' );
    }

    $( '#cart .modal-body' ).html( cart );
    $( '#cart' ).modal();
    if ( $( '.cart-sum' ).text() ) {
        $( '.simpleCart_total' ).html( $( '#cart .cart-sum' ).text() );
    } else {
        $( '.simpleCart_total' ).text( 'Корзина пуста' );
    }
}

function getCart() {
    $.ajax({
        url: path + '/cart/show',
        type: 'GET',

        success: function ( res ) {
            showCart( res );
        },

        error: function () {
            alert( 'Ошибка! Попробуйте позже' );
        }
    });
}

function clearCart() {
    $.ajax({
        url: path + '/cart/clear',
        type: 'GET',

        success: function ( res ) {
            showCart( res );
        },

        error: function () {
            alert( 'Ошибка! Попробуйте позже' );
        }
    });
}

//  Валюта
$( '#currency' ).change( function () {
    window.location = 'currency/change?curr=' + $( this ).val();
});

// Модификации товаров
$( '.available select' ).on( 'change', function () {
    var modId = $( this ).val(),
        color = $( this ).find( 'option' ).filter( ':selected' ).data( 'title' ),
        price = $( this ).find( 'option' ).filter( ':selected' ).data( 'price' ),
        basePrice = $( '#base-price' ).data( 'base' );
    if ( price ) {
        $( '#base-price' ).text( symbolLeft + price + symbolRight );
        $( '#base-price ~ del' ).fadeOut();
    } else {
        $( '#base-price' ).text( symbolLeft + basePrice + symbolRight );
        $( '#base-price ~ del' ).fadeIn();
    }

});