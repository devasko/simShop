//  Корзина
$(  );

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