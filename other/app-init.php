<?php

// add_action('plugins_loaded', function(){
// 	include 'app-install.php';
// 	install();
// });

include 'app/main.php';



// add_action( 'admin_head', function() {
	
// 	remove_submenu_page( 'options-general.php', 'project-management' );

// 	if($_GET['page'] == 'project-management'){

// 		global $menu;

// 		foreach( $menu as $key => $value )
// 		{
// 			if( 'options-general.php?page=project-management' == $value[2] )
// 				$menu[$key][4] .= " current";
			
// 			if( 'options-general.php' == $value[2] )
// 				$menu[$key][4] = str_replace("current", "", $menu[$key][4]);
// 		}

// 		echo '<style>#adminmenu .wp-has-current-submenu .wp-submenu{ position: absolute; top: -1000em; } </style>';
// 		echo '<style>#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu{background: transparent; color: #eee;}</style>';
// 		echo '<style>#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu div.wp-menu-image:before{color: #a0a5aa; color: rgba(240,245,250,.6);}</style>';
// 		echo '<style>#adminmenu a.wp-has-current-submenu:after{display:none}</style>';
// 		echo '<style>#adminmenu a.wp-has-current-submenu:after{display:none}</style>';
// 		echo '<style>#adminmenu > li.current > a.current:after{right: 0; border: solid 8px transparent; content: " "; height: 0; width: 0; position: absolute; pointer-events: none; border-right-color: #f1f1f1; top: 50%; margin-top: -8px;}</style>';	
// 		echo '<style>#adminmenu .wp-has-current-submenu.opensub .wp-submenu{position: relative; top: auto;}</style>';	

// 	}

// });



// add_filter( 'init', function( $template ) {

//     if ( isset( $_GET['id'] ) && preg_match("/\/tracking\//", $_SERVER['REQUEST_URI']) ) {
// 		renderTemplate();
//         die;
// 	}

// 	if ( isset( $_GET['edit'] ) && preg_match("/\/tracking\//", $_SERVER['REQUEST_URI']) ) {
// 		renderTemplateEdit();
//         die;
// 	}

// 	if ( isset( $_GET['create'] ) && preg_match("/\/tracking\//", $_SERVER['REQUEST_URI']) ) {
// 		renderTemplateCreate();
//         die;
// 	}
	
// } );

// function renderTemplate(){
// 	include 'templates/template-main.php';
// }

// function renderTemplateEdit(){
// 	include 'templates/template-edit.php';
// }

// function renderTemplateCreate(){
// 	include 'templates/template-create.php';
// }

function render_option_page(){
	echo 'HiHo';
	#include 'app-main.php';
}


?>