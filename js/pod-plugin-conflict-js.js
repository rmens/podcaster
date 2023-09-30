
  jQuery(function($) {
    
    $( document ).on( 'click', '.notice-pod-plugin-conflict .notice-dismiss', function (e) {
      e.preventDefault();
        
        var type = $( this ).closest( '.notice-pod-plugin-conflict' ).data( 'notice' );
        
        $.ajax( ajaxurl,
          {
            type: 'POST',
            data: {
              action: 'dismissed_notice_handler',
              type: type,
            }
          } );
        
      } );
  });