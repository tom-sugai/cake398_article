$( function() {
    $( '#jquery-menu-1-title' ) . click( function() {
        $( "#jquery-menu-1-sub" ) . slideToggle( 'slow' );
        $( "#jquery-menu-2-sub" ) . slideUp( 'slow' );
        $( "#jquery-menu-3-sub" ) . slideUp( 'slow' );
    } );
    $( '#jquery-menu-2-title' ) . click( function() {
        $( "#jquery-menu-1-sub" ) . slideUp( 'slow' );
        $( "#jquery-menu-2-sub" ) . slideToggle( 'slow' );
        $( "#jquery-menu-3-sub" ) . slideUp( 'slow' );
    } );
    $( '#jquery-menu-3-title' ) . click( function() {
        $( "#jquery-menu-1-sub" ) . slideUp( 'slow' );
        $( "#jquery-menu-2-sub" ) . slideUp( 'slow' );
        $( "#jquery-menu-3-sub" ) . slideToggle( 'slow' );
    } );
} );