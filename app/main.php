<?php

include 'view/example.php';



add_action( 'admin_menu', function() {

    add_menu_page( 
        'yourTitleName', 
        'yourPluginName', 
        'edit_users', # capability https://wordpress.org/support/article/roles-and-capabilities/#capability-vs-role-table
        'yourMainPageSlug', 
        'render_app', # your service (render admin view)
	    'dashicons-universal-access', # icon https://developer.wordpress.org/resource/dashicons/#icons-admin-menu
	    50 # menu structure https://developer.wordpress.org/reference/functions/add_menu_page/#menu-structure
	);

    add_submenu_page( 
        'yourMainPageSlug',
        'yourTitleName', 
        'yourMenuName', 
        'edit_users', # capability https://wordpress.org/support/article/roles-and-capabilities/#capability-vs-role-table
        'yourMainPageSlug', 
        'render_app' # your service (render admin view)
	);
    
});


add_filter( 'init', function( $template ) {

    if ( strpos ($_SERVER['REQUEST_URI'], "/member/dashboard") !== false ) {
		echo 'Hiho Hiho';
        die;
	}
	
} );