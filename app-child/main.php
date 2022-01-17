<?php

include 'service/example.php';


add_action( 'admin_menu', function() {

    add_submenu_page( 
        'yourMainPageSlug',
        'yourTitleName-child', 
        'yourMenuName-child', 
        'edit_users', # capability https://wordpress.org/support/article/roles-and-capabilities/#capability-vs-role-table
        'yourChildPageSlug', 
        'render_app_child' # your service (render admin view)
	);
    
});