/**
 * Created with JetBrains PhpStorm.
 * User: sQrt121
 * Date: 10/11/12
 * Time: 10:47 AM
 * To change this template use File | Settings | File Templates.
 */
(function ($) {
    $.slidebox = {version:'0.1.0'};
    $.fn.slidebox = function (sb_settings) {
        // load settings
        var settings = jQuery.extend({}, sb_settings);
        // variables
        var $currentItem,
            $container,
            $closeBtn,
            $infoBtn,
            $nextContent,
            $previousContent,
            $currentContent,
            $wrapper,
            $info,
            nCurrentContent,
            nOrigScroll

        var $req,
            $reqSuccess = false;


        $.slidebox.initialize = function () {

            // destroy running instance if necessary
            if ($req) {
                $req.abort()
                $currentItem.find('.x-preloader').hide();
                if ($reqSuccess) {
                    $container.remove();
                }
            }


            // store this
            $currentItem = $(this);

            // load the content
            $.slidebox.loadContent();


            return false;
        }
        $.slidebox.loadContent = function () {
            var _url = $currentItem.find('a.thumb').attr('href');

            $req = $.ajax({
                url:_url,
                success:function (data) {
                    // add to body
                    $container = $(data).filter("#slidebox");
                    $container.hide();
                    $container.appendTo('body');

                    $reqSuccess = true;

                    // start after all the content is loaded
                    var _num = $container.find('img,iframe,frame,script').length,
                        _counter = 0;

                    if (_num > 0) {
                        $container.find('img,iframe,frame,script').load(function () {
                            // store img dim
                            if ($(this).is('img')) {
                                var img = new Image();
                                img.src = $(this).attr('src');

                                var _s = '{"w":' + img.width + ',"h":' + img.height + '}';
                                $(this).attr('data-coll-img-dim', _s)
                            }


                            // move on
                            _counter++;
                            if (_counter == _num) {
                                $.slidebox.open();
                            }
                        });
                    } else {
                        $.slidebox.open();
                    }

                }
            });


        }
        $.slidebox.open = function () {
            $reqSuccess = false;
            $currentItem.find('.x-preloader').hide();

            // hide site
            $(window).trigger('disableFPS');
            nOrigScroll = $(window).scrollTop();
            $('#main').css('display', 'none');


            // show lightbox
            $container.show();
            //go to top
            $(window).scrollTop(0);

            $.slidebox.initVars();
            $.slidebox.initContent();
            $.slidebox.setupEventListeners();
            $.slidebox.showContentItem();
            $(window).trigger('smartresize')
        }
        $.slidebox.initVars = function () {
            nCurrentContent = 0;

            $closeBtn = $('.slidebox .options .close');
            $infoBtn = $('.slidebox .options .details');
            $nextContent = $('.slidebox .content .navigation .next');
            $previousContent = $('.slidebox .content .navigation .previous');
            $wrapper = $('.slidebox .content.wrapper');
            $info = $('.slidebox .info.wrapper');

            return false;
        }
        $.slidebox.initContent = function () {
            $wrapper.addClass('show')

            // first position
            $('.slidebox div.item.wrapper').addClass('next');

            // store original video dimentions
            $('.slidebox div.item.wrapper .video').each(function () {
                var _dim = {};
                _dim.w = $(this).children('iframe').attr('width');
                _dim.h = $(this).children('iframe').attr('height');
                _dim.r = _dim.w / _dim.h;
                $(this).data('dim', _dim)

                // remove width/height
                $(this).children('iframe').removeAttr('width').removeAttr('height');
            })


            // hide info
            $info.addClass('hide')

        }
        $.slidebox.setupEventListeners = function () {
            // close
            $closeBtn.on('click', $.slidebox.close);
            // info
            $infoBtn.on('click', $.slidebox.manageInfo);
            // content nav
            $nextContent.on('click', $.slidebox.goToNext);
            $previousContent.on('click', $.slidebox.goToPrevious);

            // add touch
            $wrapper.swipe({
                swipeLeft:function (event, direction, distance, duration, fingerCount) {
                    $.slidebox.goToNext();
                },
                swipeRight:function (event, direction, distance, duration, fingerCount) {
                    $.slidebox.goToPrevious();
                }
            });
            // window resize
            $(window).on('smartresize', $.slidebox.resize);

            return false;
        }
        $.slidebox.removeEventListeners = function () {
            $closeBtn.off('click', $.slidebox.close);
            $infoBtn.off('click', $.slidebox.manageInfo);
            $nextContent.off('click', $.slidebox.goToNext);
            $previousContent.off('click', $.slidebox.goToPrevious);
            $(window).off('smartresize', $.slidebox.resize);
            $wrapper.swipe('destroy');
            return false;
        }
        $.slidebox.showContentItem = function () {
            if (nCurrentContent > 0)$('.slidebox div.item.wrapper:eq(' + (nCurrentContent - 1) + ')').removeClass('current').addClass('previous');
            $('.slidebox div.item.wrapper:eq(' + nCurrentContent + ')').removeClass('previous next').addClass('current');
            $('.slidebox div.item.wrapper:eq(' + (nCurrentContent + 1) + ')').removeClass('current').addClass('next');
        }
        $.slidebox.goToNext = function () {
            if (nCurrentContent < $('.slidebox div.item.wrapper').length - 1) {
                nCurrentContent++;
                $.slidebox.showContentItem();
            }
        }
        $.slidebox.goToPrevious = function () {
            if (nCurrentContent > 0) {
                nCurrentContent--;
                $.slidebox.showContentItem();
            }
        }
        $.slidebox.resize = function () {
            //items

            $('.slidebox div.item.wrapper .image')
                .css('height', function () {
                    return Math.min($(window).height(), $(this).children('img').data('coll-img-dim').h) + "px";
                })
                .css('top', function () {
                    return ($(window).height() - $(this).children('img').height()) / 2;
                });

            $('.slidebox div.item.wrapper .video').each(function () {
                var _top, _left, _width, _height, _war;

                _war = $(window).width() / $(window).height();

                if (_war > $(this).data('dim').r && $(window).height() < $(this).data('dim').h) {
                    // window ratio > video ratio
                    _width = $(window).height() * $(this).data('dim').r;
                    _height = $(window).height();
                } else {
                    _width = Math.min($(window).width(), $(this).data('dim').w)
                    _height = _width / $(this).data('dim').r;
                }

                _top = ($(window).height() - _height) / 2;
                _left = ($(window).width() - _width) / 2;

                $(this).css({
                    'top':_top,
                    'left':_left,
                    'width':_width,
                    'height':_height
                });


            });


        }
        $.slidebox.manageInfo = function () {
            if ($wrapper.hasClass('show')) {
                $wrapper.removeClass('show').addClass('hide');
                $info.removeClass('hide').addClass('show');
            }
            else {
                $wrapper.removeClass('hide').addClass('show');
                $info.removeClass('show').addClass('hide');
            }

            return false;
        }
        $.slidebox.close = function () {
            // remove slidebox
            $container.remove();
            // remove listeners
            $.slidebox.removeEventListeners();

            // show site
            $('#main').css('display', 'block');
            $(window).scrollTop(nOrigScroll).trigger('smartresize');
            $(window).trigger('enableFPS');


            return false;
        }
        return this.unbind('click.slidebox').bind('click.slidebox', $.slidebox.initialize);
    }
})(jQuery);