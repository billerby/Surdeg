<?php

function bfa_ata_add_admin() {

    global $themename, $shortname, $options;

#    if ( $_GET['page'] == basename(__FILE__) ) {
   if ( $_GET['page'] == "functions.php" ) {
	
        if ( 'save' == $_REQUEST['action'] ) {
 
			foreach ($options as $value) {
				if ( $value['category'] == $_REQUEST['category'] ) {
					if ( $value['escape'] == "yes" )  
						update_option( $value['id'], stripslashes(bfa_escape($_REQUEST[ $value['id'] ] )));  
					elseif ( $value['stripslashes'] == "no" )    
						update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
					else 
						update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ] )); 
				}
			}
				
            foreach ($options as $value) {
				if ( $value['category'] == $_REQUEST['category'] ) {
					if ( $value['escape'] == "yes" ) {
						if( isset( $_REQUEST[ $value['id'] ] ) ) 
							update_option( $value['id'], stripslashes(bfa_escape($_REQUEST[ $value['id'] ]  ))); 
						else 
							delete_option( $value['id'] ); 
					} elseif ($value['stripslashes'] == "no") { 
						if( isset( $_REQUEST[ $value['id'] ] ) ) 
							update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
						else 
							delete_option( $value['id'] );  
					} else { 
						if( isset( $_REQUEST[ $value['id'] ] ) ) 
							update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ]  )); 
						else 
							delete_option( $value['id'] ); 
					} 
				}
			} 
				
            header("Location: themes.php?page=functions.php&saved=true");
            die;

		} else if( 'reset' == $_REQUEST['action'] ) {
		
            foreach ($options as $value) {
				if ( $value['category'] == $_REQUEST['category'] OR "reset-all" == $_REQUEST['category'] ) 
					delete_option( $value['id'] ); 
				}
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
		
    }
#    add_theme_page($themename. " Options", "Atahualpa Theme Options", 'edit_themes', basename(__FILE__), 'bfa_ata_admin');
    add_theme_page($themename. " Options", "Atahualpa Theme Options", 'edit_themes', 'functions.php', 'bfa_ata_admin');	
}
?>