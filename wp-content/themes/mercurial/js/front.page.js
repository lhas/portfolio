/**
 * Created by JetBrains PhpStorm.
 * User: sQrt121
 * Date: 2/1/12
 * Time: 12:27 PM
 * To change this template use File | Settings | File Templates.
 */
//global variables
jQuery.noConflict();

var Scroll = new function () {
};
var BackgroundSection = new function () {
};

// detect browser
var browser = '';
var browserVersion = 0;
var bNoanim = false;

if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Opera';
} else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
    browser = 'MSIE';
} else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Netscape';
} else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Chrome';
} else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Safari';
    /Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
    browserVersion = new Number(RegExp.$1);
} else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Firefox';
}
if (browserVersion === 0) {
    browserVersion = parseFloat(new Number(RegExp.$1));
}

if (browser == "Safari" && parseInt(browserVersion) > 5) {
    bNoanim = true;
}


// detect mobile
function detectmob() {
    if (navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
        ) {
        return true;
    }
    else {
        return false;
    }
}
var nBgSpeed;
if (detectmob())
{
    nBgSpeed = 0;
}
else
{
    nBgSpeed = .5;
}
//(detectmob()) ? nBgSpeed = 0 : nBgSpeed = .5;

jQuery(document).ready(function ($) {
    /*
     *
     *
     *  SITE PRELOADER
     **************************************/

    var _pContainer = $('<div id="coll-preloader"></div>')
    var _pPercent = $('<div class="percent">0</div>')

    if (!$('.lt-ie9').length) {
        _pContainer.append(_pPercent);
        $('body.home').append(_pContainer);

        document.addEventListener("collpercent", function () {
            _pPercent.text(Math.round(myPreloader.percentage));
        })

        var myPreloader = new sPreloader({
            contentDiv:'main', //ID of your mainContent
            loaderDiv:'coll-preloader', //ID of your loading DIV
            excludingClass:'no', //Name of class to exclude from the preloader
            logProgress:true, //log the percentage through console.log
            animation:'fade', //animation type: fade | none
            animationSpeed:'1.0' //animation speed

        });

        myPreloader.start();
    }


    /*
     *
     *
     *  Menu
     **************************************/
    Menu.nMarker = 0;
    Menu.checkMenu = function () {
        (Menu.nMarker <= Scroll.nScrollPosition) ? $('.header.no-front-page').show() : $('.header.no-front-page').hide();
    }
    Menu.duplicate = function () {
        // duplicate menu if no-front-page
        var $dupMenu = $('.header.no-front-page').clone();
        $dupMenu.addClass('duplicate').removeClass('no-front-page');
        $('.home .page-container:eq(1)').prepend($dupMenu);

        // init superfish
        $('.duplicate .sf-menu').superfish({
            delay:100,
            animation:{opacity:'show'},
            speed:'fast',
            autoArrows:false
        });
        // show submenu
        $('.duplicate .sf-menu > li').hover(
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
    }

    /*
     *
     *
     *  SCROLLING
     **********************************************************************/

    // public
    Scroll.nScrollPosition = 0;
    Scroll.nMaxScroll = 0;
    Scroll.bScrolling = false;
    Scroll.init = function () {
        // menu
        $.easing.easeOutExpo = function (x, t, b, c, d) {
            return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
        }
        $('.sf-menu').localScroll({onBefore:function (e, page, win) {
            Scroll.nScrollPosition = $(page).offset().top;
            Scroll.bScrolling = true;
            BackgroundSection.reposition();
        }, 'duration':400, 'easing':'easeOutExpo', onAfter:function () {
            Scroll.bScrolling = false;
        }});


        // mousewheel
        if (!bNoanim) {
            disable_scroll();
            $(window).on('mousewheel', Scroll.mouseJump);
        }


        $('.page-container').bind('inview', function (event, isInView, visiblePartX, visiblePartY) {
            var elem = $(this);
            var menuItem = $('.sf-menu').find('a[href=#' + $(this).attr('id') + ']');

            if (isInView) {
                // element is now visible in the viewport
                if (visiblePartY == 'top') {
                    // top part of element is visible

                    elem.data('seenTop', true);

                } else if (visiblePartY == 'bottom') {
                    // bottom part of element is visible

                    elem.data('seenBottom', true);

                } else {
                    // whole part of element is visible

                    elem.data('seenTop', true);
                    elem.data('seenBottom', true);
                }
            } else {
                // element has gone out of viewport
                elem.data('left', true);
                elem.data('seenTop', false);
                elem.data('seenBottom', false);

                menuItem.removeClass('current');
            }


            if (elem.data('seenTop') || elem.data('seenBottom')) {
                menuItem.addClass('current')
            }

        });
    }
    Scroll.mouseJump = function (event, delta) {

        Scroll.nScrollPosition -= delta * 200;
        Scroll.nScrollPosition = Math.max(0, Math.min(Scroll.nMaxScroll, Scroll.nScrollPosition))

        Scroll.bScrolling = true;

        // move bg
        BackgroundSection.reposition();

        // move page
        $(this)._scrollable().stop(true, false).scrollTo(Scroll.nScrollPosition, {'duration':400, 'easing':'easeOutExpo', onAfter:function () {
            Scroll.bScrolling = false;
        }})

        return false;
    }
    $(window).on('enableFPS', function () {

        if (!bNoanim) {
            disable_scroll();
            $(window).on('mousewheel', Scroll.mouseJump);
        }
    })
    $(window).on('disableFPS', function () {
        if (!bNoanim) {
            $(window).off('mousewheel', Scroll.mouseJump);
            enable_scroll();
        }
    })
    /*
     *
     *
     *  BACKGROUND
     **********************************************************************/

    BackgroundSection.background = new Array();


    BackgroundSection.init = function () {
        // select all backgrounds
        BackgroundSection.background = $(".page-background .bgimage");

        // store info
        BackgroundSection.background.each(function (i) {
            var _ar = $(this).width() / $(this).height();
            $(this).data('aspectRatio', _ar);
        });
    }
    BackgroundSection.resize = function () {
        // adjust bgs
        $('.page-container.min-full').css('min-height', function () {
            return $(window).height();
        })
        $('.page-container .page-background').css('min-height', function () {
            return $(window).height();
        })

        BackgroundSection.background.each(function (i) {
            if (($(this).parent().width() / $(this).parent().height()) < $(this).data('aspectRatio')) {
                $(this)
                    .removeClass('bgheight bgwidth')
                    .addClass('bgheight');
            } else {
                $(this)
                    .removeClass('bgheight bgwidth')
                    .addClass('bgwidth');
            }
        });


    }
    BackgroundSection.reposition = function () {
        BackgroundSection.background.each(function (i) {
            var _y = -( $(this).parent().offset().top - Scroll.nScrollPosition) * nBgSpeed;

            $(this).stop(true, false).animate({
                top:_y
            }, 400, 'easeOutExpo');
        });
    }
    BackgroundSection.position = function () {
        BackgroundSection.background.each(function (i) {
            var _y = -( $(this).parent().offset().top - Scroll.nScrollPosition) * nBgSpeed;
            $(this).stop(true, false).css({'top':_y})
        });
    }


    /*
     *
     *
     *  ALL CONTENT HAS BEEN LOADED
     *************************************************************************************************/
    $(window).load(function () {

        BackgroundSection.init();

        // get current scroll
        Scroll.nScrollPosition = $(window).scrollTop();


        // webkit fix
        $(window).scroll(shitfuck);
        function shitfuck() {
            Scroll.nScrollPosition = $(window).scrollTop();
            BackgroundSection.position();
            $(window).unbind('scroll', shitfuck);

            $(this).scroll(function () {
                if (!Scroll.bScrolling) {
                    Scroll.nScrollPosition = $(window).scrollTop();
                    BackgroundSection.position();
                }

                Menu.checkMenu();


            })
        }

        // on resize
        $(window).smartresize(function () {
            BackgroundSection.resize();

            //
            // refresh menu settings
            Scroll.nScrollPosition = $(window).scrollTop();
            Scroll.nMaxScroll = $('body')[0].scrollHeight - $(window).height();

            if ($('.home').length) Menu.nMarker = $('.home .page-container:eq(1)').offset().top;
            Menu.checkMenu();

            Scroll.nMaxScroll = $('body')[0].scrollHeight - $(window).height();

        }).trigger("smartresize").trigger('scroll');

        // on content resize
        $(window).on('contentResized', function () {
            BackgroundSection.resize();
            BackgroundSection.reposition();
            Scroll.nMaxScroll = $('body')[0].scrollHeight - $(window).height();
        });
        // check hash for porftolio item redirect
        $(location.hash).trigger('click');


        // remove preloader
        _pContainer.remove();
        $('#preloadImages').remove();
    });


    /*
     *
     * START
     * */
    Scroll.init();
    Menu.duplicate();
});


/*-----------------------------------------------------------------------------------*/
// Utilities
/*-----------------------------------------------------------------------------------*/


function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}


function wheel(e) {
    preventDefault(e);
}

function disable_scroll() {
    if (window.addEventListener) {
        window.addEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = wheel;

}

function enable_scroll() {
    if (window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = null;
}

function parseBol(s) {
    return s == 'true';
}
