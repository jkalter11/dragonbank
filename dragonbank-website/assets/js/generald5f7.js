maps=[];
jQuery(document).ready(function() {
 	var $ = jQuery;
    // for accordion toggle
    jQuery('.panel-group .panel:first-child').find('.panel-collapse').addClass('in');
    var screenRes = $(window).width(),
        screenHeight = $(window).height(),
        html = $('html');

    $(window).resize(function() {
        screenRes = $(window).width();
        screenHeight = $(window).height();
    });

// IE<8 Warning
    if (html.hasClass("oldie")) {
        $("body").empty().html('Please, Update your Browser to at least IE8');
    }

// Remove outline in IE
	$("a, input, textarea").attr("hideFocus", "true").css("outline", "none");

// Disable Empty Links
    $("[href=#]").click(function(event){
        event.preventDefault();
    });

// Tooltip
    $("[data-toggle='tooltip']").tooltip();

// Placeholders
    if($("[placeholder]").size() > 0) {
        $.Placeholder.init({color : "#291c1c"});
    }

// SyntaxHighlighter
    if ($("pre").hasClass("brush: plain")) {
        SyntaxHighlighter.defaults['gutter'] = false;
        SyntaxHighlighter.defaults['toolbar'] = true;
        SyntaxHighlighter.all();
    }

// Styled Select, CheckBox, RadioBox
    if ($(".select-styled").length) {
        cuSel({changedEl: ".select-styled", visRows: 6, itemPadding: 17});
        // for cuselBox position
        $('.field-select').on('click', function() {
            var postion_select = jQuery(this).offset();
            jQuery('#cuselBox').css({
                    "top": postion_select.top+56,
                    "left": postion_select.left
            });
        });
        $('.field-select').each(function() {
            $(this).on('change', 'input', function() {
                $(this).closest('.cusel').addClass('hasValue');
            });
        });
    }
    if ($(".input-styled").length) {
        $(".input-styled input").customInput();
    }

// DatePicker
    if ($(".datepicker").length) {
        $(".datepicker").each(function() {
            $(this).children('[type="text"]').datepicker();
        });
    }

// PrettyPhoto LightBox, check if <a> has attr data-rel and hide for Mobiles
    if($('a').is('[data-rel]') && screenRes > 600) {
        $('a[data-rel]').each(function() {
            $(this).attr('rel', $(this).data('rel'));
        });
        $("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
    }

// Framed Slider
    $.fn.framedSliderApi = function() {
        var slider = $(this);

        // Slider Dynamic Height
        function sliderHeight() {
            var sliderHeight = slider.find('.carousel-inner').height();
            slider.css('height', sliderHeight + 10);
        }

        sliderHeight();

        slider.on('slid.bs.carousel', function () {
            sliderHeight();
        });
        $(window).on('resize', function () {
            sliderHeight();
        });

        if (Modernizr.touch) {
            slider.find('.carousel-inner').swipe( {
                swipeLeft: function() {
                    $(this).parent().carousel('prev');
                },
                swipeRight: function() {
                    $(this).parent().carousel('next');
                },
                threshold: 30
            })
        }
    };

    $('#adopt-slider').carousel({interval: 9000, pause: 'none'}).framedSliderApi();
    $('#services-slider').carousel({interval: 10000, pause: 'none'}).framedSliderApi();
    $('#testimonials-slider').carousel({interval: 10000, pause: 'none'}).framedSliderApi();

    // Main Menu
    $(".nav-menu").find('ul').addClass('hidden');
    $(".nav-menu").find('.mega-nav-widget').find('ul').removeClass('hidden');
    $(".nav-menu > li").not('.mega-nav-widget').has('ul').addClass('parent');

    $(".nav-menu li").hover(function() {
        var $this = $(this),
            dropdown = $this.children('ul');

        if(dropdown.length) {
            dropdown.append('<li class="arrow-dropdown"></li>').removeClass();

            // Set Mega Nav Width according to # of Widgets
            // Set Widgets Height according to the Tallest Widget
            if($this.hasClass('mega-nav')) {
                var ul = $this.children('ul'),
                    li = ul.children('li'),
                    widthFinal = 20,
                    liHeight = 0;

                li.not('.arrow-dropdown').each(function() {
                    var width = $(this).outerWidth(),
                        height = $(this).outerHeight();

                    if (height > liHeight) {
                        liHeight = height;
                    }
                    widthFinal = widthFinal + width;
                });
                ul.css('width', widthFinal);
                li.not('.arrow-dropdown').css('height', liHeight);
            }

            if (Modernizr.cssanimations) {
                dropdown.addClass('fadeInDownSmall').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    dropdown.removeClass('fadeInDownSmall hidden');
                });
            }
        }

        // Set Dropdown (Level 1) to the center of the parent Item
        if($this.parent().hasClass('nav-menu') && dropdown.length) {
            var menuItemWidth = $this.outerWidth(),
                menuItemOffset = parseInt($this.offset().left, 10),
                submenuItemWidth = dropdown.outerWidth();

            if (menuItemOffset + menuItemWidth/2 + submenuItemWidth/2 >= screenRes) {
                dropdown
                    .css('left' , screenRes - submenuItemWidth - menuItemOffset)
                    .children('.arrow-dropdown')
                    .css('left' , submenuItemWidth + menuItemOffset + menuItemWidth/2 - screenRes + 8);
            }
            else if (menuItemOffset + menuItemWidth/2 - submenuItemWidth/2 < 0) {
                dropdown.css('left' , - menuItemOffset)
                    .children('.arrow-dropdown')
                    .css('left' , menuItemOffset + menuItemWidth/2 - 8);
            }
            else {
                dropdown.css('left' , (menuItemWidth-submenuItemWidth)/2);
            }
        }

        // Move Dropdown (Level 2+) to the left side of its Parent if it doesn't fit to the screen
        else
        {
            if(($this).hasClass('parent')) {
                var dropdownWidth = dropdown.outerWidth(),
                    dropdownOffset = parseInt(dropdown.offset().left, 10);

                if (dropdownWidth + dropdownOffset > screenRes - 5) {
                    dropdown.addClass('left');
                }
            }
        }

    }, function() {
        var $this = $(this),
            dropdown = $this.children('ul');

        dropdown.find('.arrow-dropdown').remove();

        if (Modernizr.cssanimations) {
            dropdown.removeClass('fadeInDownSmall hidden').addClass('fadeOutUpSmall').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                dropdown.removeClass('fadeOutUpSmall').addClass('hidden');
            })
        } else {
            dropdown.addClass('hidden');
        }
    });

// Image Gallery with Thumbs
    $.fn.imageSliderApi = function () {
        var slider = $(this),
            images = slider.find('.slider-images'),
            thumbs = slider.find('.slider-thumbs');

        images.carouFredSel({
            prev : {
                button: function() {
                    return slider.find(".prev");
                }
            },
            next : {
                button: function() {
                    return slider.find(".next");
                }
            },
            circular: false,
            infinite: false,
            items: 1,
            auto: false,
            scroll: {
                fx: "fade",
                onBefore: function() {
                    var pos = $(this).triggerHandler('currentPosition');

                    thumbs.find('li').removeClass('active');
                    thumbs.find('li.item'+pos).addClass('active');
                    if(pos < 1) {
                        thumbs.trigger('slideTo', [pos, true]);
                    } else {
                        thumbs.trigger('slideTo', [pos - 1, true]);
                    }
                }
            },
            onCreate: function() {
                images.children().each(function(i) {
                    $(this).addClass('item'+i);
                });
            }
        });

        thumbs.carouFredSel({
            direction: "up",
            auto: false,
            infinite: false,
            circular: false,
            scroll: {
                items : 1
            },
            onCreate: function() {
                thumbs.children().each(function(i) {
                    $(this).addClass( 'item'+i ).on('click', function() {
                        images.trigger('slideTo', [i, true]);
                    });
                });
                thumbs.children('.item0').addClass('active');
            }
        });
    };

    if($('#pet-slider').length) {
        $('#pet-slider').imageSliderApi();
        $(window).on('resize', function(){
            $('#pet-slider').imageSliderApi();
        });
    }

// Smooth Transition to Anchors
    $('.anchor[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var speed = 2,
            boost = 1,
            offset = 60,
            target = $(this).attr('href'),
            currPos = parseInt($(window).scrollTop(), 10),
            targetPos = target!="#" && $(target).length==1 ? parseInt($(target).offset().top, 10)-offset : currPos,
            distance = targetPos-currPos,
            boost2 = Math.abs(distance*boost/1000);
        $("html, body").animate({ scrollTop: targetPos }, parseInt(Math.abs(distance/(speed+boost2)), 10));
    });

// Entry Meta
    $('.entry-meta').each(function(index) {
        $(this).children('span').last().addClass('last');
    });

// Post Detail Images
    $('.post-details').find('.entry-image').each(function() {
        var $this = $(this);

        if ($this.prev().hasClass('entry-image') && !$this.prev().hasClass('omega')) {
            $this.addClass('omega');
        }
    });

// Similar Posts
    $('.post-similar').find('a').each(function(index) {
        if (index % 2 == 1) {
            $(this).addClass('omega');
        }
    });

// Toggles
    $('.panel')
        .on('show.bs.collapse', function () {
            $(this).addClass('opened');
        })
        .on('hide.bs.collapse', function () {
            $(this).removeClass('opened');
        });

// Video Iframe ratio
    function videoRatio() {
        $('.video').find('iframe').each(function(){
            var $this = $(this),
                iframeAttrWidth = $this.attr('width'),
                iframeAttrHeight = $this.attr('height'),
                iframeWidth = $this.width(),
                iframeHeight = parseInt(iframeAttrHeight*iframeWidth/iframeAttrWidth, 10);

            $this.css('height', iframeHeight);
        });
    }
    videoRatio();
    $(window).on('resize', function () {
        videoRatio();
    });

// Events Calendar
    if($('#calendar').length) {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month)+"-"+(day);

        // ajax request to return event from curent category
        var id = jQuery('input[name="current_event"]').attr("value");
        var lang = '';
        if( typeof tf_qtrans_lang !== 'undefined' )
            lang = '&lang=' + tf_qtrans_lang.lang;

        var x_data = "action=tfuse_archive_events&id="+id + lang;
        jQuery.ajax({
            type: "POST",
            url: tf_script.ajaxurl,
            data: x_data,
            success: function(rsp){
                //console.log(rsp);
                var data = jQuery.parseJSON(rsp);
                var calendar = $('#calendar').calendar({
                    events_source: data,
                    view: 'month',
                    tmpl_path: tf_script.TFUSE_THEME_URL+'/tmpls/',
                    tmpl_cache: false,
                    first_day: 2,
                    modal: '#events-modal',
                    day: today,
                    onAfterEventsLoad: function(events) {
                        if(!events) {
                            return;
                        }
                        var list = $('#eventlist');
                        list.html('');

                        $.each(events, function(key, val) {
                            $(document.createElement('li'))
                                .html('<a href="' + val.url + '">' + val.title + '</a>')
                                .appendTo(list);
                        });
                    },
                    onAfterViewLoad: function(view) {
                        $('.calendar-title').text(this.getTitle());

                        $('.cal-month-day').each(function () {
                            var $this = $(this);
                            if($this.find('.events-list').length) {
                                $this.addClass('cal-day-event');

                                var events = $this.find('.event').length;
                                if(events == 1) {
                                    $this.find('.events-list').text(events + ' Event');
                                } else {
                                    $this.find('.events-list').text(events + ' Events');
                                }
                            }
                        });
                    },
                    classes: {
                        months: {
                            general: 'label'
                        }
                    }
                });

                $('[data-calendar-nav]').on('click', function(e) {
                    e.preventDefault();
                    calendar.navigate($(this).data('calendar-nav'));
                });
                $('[data-calendar-view]').on('click', function(e) {
                    e.preventDefault();
                    calendar.view($(this).data('calendar-view'));
                });
            }
        });
    }
    // hide clearfix for faq form
    jQuery('.faq-form .contactForm .clearfix').hide();
    tfuse_send_contact_widget();

    // Mobile Menu (SlickNav)
    /*    $('#primary-navigation').children('ul').first().slicknav({parentTag: 'div'});
     $('.slicknav_nav').children('.mega-nav').find('.slicknav_item').removeClass('slicknav_item');*/

// Mobile Menu (artMenu)
    var myMenu = $('#primary-navigation').html();

    $('body').prepend('<div id="artMenu">'+myMenu+'</div><a href="#" id="artMenuCall"></a>');

    var artMenu = $('#artMenu'),
        artMenuCall = $('#artMenuCall'),
        page = $('#page');

    artMenu.children('ul').removeClass();
    artMenu.find('.mega-nav').children('ul').remove();
    artMenu.find('.parent').children('a').on('click', function(){
        $(this).siblings('ul').toggleClass('hidden');
        $(this).closest('li').toggleClass('opened');
    });
    artMenuCall.on('click', function(e){
        e.preventDefault();
        artMenuCall.toggleClass('active');
        artMenu.toggleClass('active');
        page.toggleClass('active');
    });
    $(window).on('resize', function(){
        artMenuCall.removeClass('active');
        artMenu.removeClass('active');
        page.removeClass('active');
    });
    $(document).on('click', function(e) {
        var clicked = $(e.target);
        if (artMenu.hasClass('active') && !clicked.is('#artMenuCall') && !clicked.closest('#artMenu').length) {
            artMenuCall.removeClass('active');
            artMenu.removeClass('active');
            page.removeClass('active');
        }
    });
});


// for change values in pets filter widget
function change_values_for_breeds(type_id){
    var all_breed = jQuery('#pet_breeds').val();
    var breeds_json = jQuery.parseJSON(all_breed);
    var breed = jQuery("#breed");
    var breed_options = breed.parent().find('.cusel-scroll-pane');
    var firs_item = breed_options.find('.cuselItem:first').html();
    var addedSelect = '';
    addedSelect += '<div class="cusel-scroll-pane" id="cusel-scroll-breed">';
    addedSelect += '<span val="" class="cuselItem">'+firs_item+'</span>';
    jQuery.each( breeds_json[type_id], function(key, value){
        addedSelect +='<span val="'+key+'" class="cuselItem"><label>'+value+'</label></span>';
    });
    addedSelect += '</div>';
    jQuery(breed_options).replaceWith(addedSelect);
    cuselSetValue(breed, '');
}


function tfuse_send_contact_widget()
{
    jQuery('.adopt_pet_form .adopt_pet_submit').on('click', function(e)
    {
        e.preventDefault();
        var my_error = false;

        var this_form = jQuery(this).parent().parent('.adopt_pet_form');
        var name = this_form.find('#adopt-name').val();
        var email = this_form.find('#adopt-email');
        var email_value = email.val();
        var subject = this_form.find('#adopt-subject').val();
        var message = this_form.find('#adopt-message').val();
        var post_id = this_form.find('#post_id').val();

        email.removeClass('error valid');
        baseclases = email.attr('class');
        if(!email_value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/)) {
            email.attr('class',baseclases).addClass('error');
            my_error = true;
        } else {
            email.attr('class',baseclases).addClass('valid');
        }

        if (!my_error)
        {
            var datastring = 'action=tfuse_send_contact_widget&client_email=' + email_value + '&client_name=' + name + '&client_message=' + message + '&subject=' + subject+ '&post_id=' + post_id;

            jQuery.ajax({
                type: 'POST',
                url: tf_script.ajaxurl,
                data: datastring,
                success: function(response)
                {
                    //console.log(response);
                    if (response == 'true')
                    {
                        this_form.hide();
                        this_form.parent().find('.adopt_pet_form_succes').css('display','block');
                    }
                    else
                    {
                        this_form.hide();
                        this_form.parent().find('.adopt_pet_form_error').css('display','block');
                    }
                }
            });

        }
        return false;
    });
}