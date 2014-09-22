<?php

/*-----------------------------------------------------------------------------------*/
/*	Paths Defenitions
/*-----------------------------------------------------------------------------------*/

define('COLL_TINYMCE_PATH', COLL_FILEPATH . '/tinymce');
define('COLL_TINYMCE_URI', COLL_DIRECTORY . '/tinymce');


/*-----------------------------------------------------------------------------------*/
/*	Load TinyMCE dialog
/*-----------------------------------------------------------------------------------*/

require_once( COLL_TINYMCE_PATH . '/tinymce.class.php' );		// TinyMCE wrapper class
new col_tinymce();											// do the magic

?>