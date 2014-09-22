/**
 * Created by JetBrains PhpStorm.
 * User: sQrt121
 * Date: 2/1/12
 * Time: 12:27 PM
 * To change this template use File | Settings | File Templates.
 */
//global variables
jQuery.noConflict();

var Menu = new function () {
};
var Background = new function () {
};
var Shortcodes = new function () {
};
var Portfolio = new function () {
};

jQuery(document).ready(function ($) {


    /*
     *
     *
     *  Menu
     **************************************/
    Menu.init = function () {
        // init superfish
        $('.sf-menu').superfish({
            delay:100,
            animation:{opacity:'show'},
            speed:'fast',
            autoArrows:false
        });
        // show submenu
        $('.sf-menu > li').hover(
            function () {
                var _sub = $(this).find('ul');
                if (_sub.length) {
                    $('.sf-menu').stop().animate({
                        'margin-bottom':_sub.outerHeight()

                    }, 400, 'easeOutExpo');
                }
            },
            function () {
                if ($(this).find('ul').length) {
                    $('.sf-menu').stop().animate({
                        'margin-bottom':'0'
                    }, 400, 'easeOutExpo');
                }
            }
        )
        // improves menu for mobile devices
        var optionsList = '<option value="" selected>Navigate to...</option>';
        $('.sf-menu').first().find('li').each(
            function () {
                var anchor = $(this).children('a');
                var depth = $(this).parents('ul').length - 1;
                var indent = '';

                if (depth) {
                    while (depth > 0) {
                        indent += '&nbsp;-';
                        depth--;
                    }
                }

                optionsList += '<option value="' + anchor.attr('href') + '">' + indent + ' ' + anchor.text() + '</option>';
            }).end();
        $('.header .row .mainmenu').after('<div class="responsive menu "><select class="responsive-mainmenu">' + optionsList + '</select></div>');

        $('body').on('change','.responsive-mainmenu', function () {
            window.location = $(this).val();
        } );
    }


    /*
     *
     *
     *  BACKGROUND
     **********************************************************************/
    Background.init = function () {
        Background.background = $("#background");
        Background.background.data('aspectRatio', $(window).width() / $(window).height())
    }
    Background.resize = function () {
        if (($(window).width() / $(window).height()) < Background.background.data('aspectRatio')) {
            Background.background
                .removeClass('bgheight bgwidth')
                .addClass('bgheight');
        } else {
            Background.background
                .removeClass('bgheight bgwidth')
                .addClass('bgwidth');
        }
    }


    /*
     *
     *
     *  SHORTCODES
     **********************************************************************/

    Shortcodes.aTTB = [];
    Shortcodes.init = function () {
        // text types
        // --------------------------------------------------------------
        // add borders
        var $needsBorder = $('div.text.type.three .text').add('div.text.type.four .text')
        $needsBorder.after('<span class="left"></span>')
        $needsBorder.after('<span class="right"></span>')
        Shortcodes.aTTB = $('div.text.type .left').add('div.text.type .right')
        Shortcodes.aTTB.css('border-color', function () {
            return $(this).parent().css('color');
        });
        // fix background on five
        $('div.text.type.five .text').before('<span class="bg"></span>')


    }
    Shortcodes.resize = function () {

        /* Text Types ------------------------------*/
        Shortcodes.aTTB.css('width', function () {
            return ($(this).parent().width() - $(this).parent().children('.text').width() - 30) / 2;
        });

        // resize text
        if ($(window).width() < 1140) {
            $('div.text.type.resizable').css('font-size', function () {
                var _size = ($(window).width() - 320) * ($(this).data('coll-font-size').max - $(this).data('coll-font-size').min) / (1140 - 320) + $(this).data('coll-font-size').min;
                return _size + 'px';
            })
        }
        else {
            $('div.text.type.resizable').css('font-size', function () {
                return $(this).data('coll-font-size').max + 'px';
            })
        }

        $('div.text.type.five .bg').css('height', function () {
            return $(this).parent().height();
        });


        /* Smart Padding ------------------------------*/
        if ($(window).width() < 1140) {
            $('.smart-padding').css('padding-top', function (index, value) {
                var _sp = ($(window).width() - 320) * ($(this).data('max') - $(this).data('min')) / (1140 - 320) + $(this).data('min');
                return _sp + '%';
            })
        }
        else {
            $('.smart-padding').css('padding-top', function (index, value) {
                return $(this).data('max') + '%';
            })
        }
        /* Twitter ------------------------------*/
        $('.tweet-line').css('width', function () {
            return ($(this).parent().width() - $(this).parent().children('.time').outerWidth() - 2);
        });

        /* Tabs Shortcode ------------------------------*/
        $("#tabs").tabs({ fx:{ opacity:'show' } });
        $(".tabs").tabs({ fx:{ opacity:'show' }, show:function (event, ui) {
            $(window).trigger('contentResized');
        } });


        /* Toggle Shortcode ----------------------------*/
        $(".toggle").each(function () {
            if ($(this).attr('data-id') == 'closed') {
                $(this).accordion({ header:'h4', animated:false, collapsible:true, autoHeight:false, active:false  });
            } else {
                $(this).accordion({ header:'h4', animated:false, autoHeight:false, collapsible:true});
            }
        });
        $(".toggle").on("accordionchange", function (event, ui) {
            $(window).trigger('contentResized');
        });

    }


    /*
     *
     *
     *  PORTFOLIO
     **********************************************************************/

    Portfolio.portContainer = $('.portfolio .items');

    Portfolio.init = function () {
        // filter items when filter link is clicked
        $('.portfolio .filter a').click(function () {
            // select current category
            $('.portfolio .filter a').removeClass('current');
            $(this).addClass('current');

            var selector = $(this).attr('data-filter');


            // init isotope
            if (Portfolio.portContainer.hasClass('isotope')) {
                Portfolio.portContainer.isotope({
                    filter:selector,
                    animationOptions:{
                        duration:750,
                        easing:'linear',
                        queue:false
                    },
                    resizable:false,
                    onLayout:function ($elems, instance) {
                        $(window).trigger('contentResized');
                    }
                });
            } else {
                Portfolio.portContainer.isotope({animationOptions:{duration:0}});
                setTimeout(function () {
                    Portfolio.portContainer.isotope({
                        filter:selector,
                        animationOptions:{
                            duration:750,
                            easing:'linear',
                            queue:false
                        },
                        resizable:false,
                        onLayout:function ($elems, instance) {
                            $(window).trigger('contentResized');
                        }
                    });
                }, 100)

            }


            return false;
        });

        // open slidebox on portfolio item click
        //$('.portfolio .items .hentry').slidebox();
        $('.portfolio .items .hentry').on('click', function () {
            //$(this).find('.x-preloader').show();
            //return false
            return true;
        })
    }
    Portfolio.resize = function () {
        if (Portfolio.portContainer.hasClass('isotope')) Portfolio.portContainer.isotope('reLayout');
    }


    /*
     *
     *
     *  ALL CONTENT HAS BEEN LOADED
     *************************************************************************************************/
    $(window).load(function () {
        Background.init();
        // on resize
        $(window).smartresize(function () {
            Background.resize();
            Shortcodes.resize();
            Portfolio.resize();
        }).trigger("smartresize");

        $('.flexslider.entry-assets').flexslider();
    });


    // START
    Menu.init();
    Shortcodes.init();
    Portfolio.init();

    // resize videos
    $('.fitvid').fitVids();
});

