/**
 * Created by JetBrains PhpStorm.
 * User: sQrt121
 * Date: 2/1/12
 * Time: 12:27 PM
 * To change this template use File | Settings | File Templates.
 */
//global variables
jQuery.noConflict();

jQuery(document).ready(function ($) {
    window.location = $('#redirect').attr('href');
});

