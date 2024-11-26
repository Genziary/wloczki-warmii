/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */
(function($) {
    var NivoSlider = function(element, options){
        // Defaults are below
        var settings = $.extend({}, $.fn.nivoSlider.defaults, options);

        // Useful variables. Play carefully.
        var vars = {
            currentSlide: 0,
            currentImage: '',
            totalSlides: 0,
            running: false,
            paused: false,
            stop: false,
            controlNavEl: false
        };

        // Get this slider
        var slider = $(element);
        slider.data('nivo:vars', vars).addClass('nivoSlider');

        // Find our slider children
        var kids = slider.children();
        kids.each(function() {
            var child = $(this);
            var link = '';
            if(!child.is('img')){
                if(child.is('a')){
                    child.addClass('nivo-imageLink');
                    link = child;
                }
                child = child.find('img:first');
            }
            // Get img width & height
            var childWidth = (childWidth === 0) ? child.attr('width') : child.width(),
                childHeight = (childHeight === 0) ? child.attr('height') : child.height();

            if(link !== ''){
                link.css('display','none');
            }
            child.css('display','none');
            vars.totalSlides++;
        });
        // If randomStart
        if(settings.randomStart){
            settings.startSlide = Math.floor(Math.random() * vars.totalSlides);
        }
        
        // Set startSlide
        if(settings.startSlide > 0){
            if(settings.startSlide >= vars.totalSlides) { settings.startSlide = vars.totalSlides - 1; }
            vars.currentSlide = settings.startSlide;
        }
        
        // Get initial image
        if($(kids[vars.currentSlide]).is('img')){
            vars.currentImage = $(kids[vars.currentSlide]);
        } else {
            vars.currentImage = $(kids[vars.currentSlide]).find('img:first');
        }
        
        // Show initial link
        if($(kids[vars.currentSlide]).is('a')){
            $(kids[vars.currentSlide]).css('display','block');
        }
        
        // Set first background
        var sliderImg = $('<img/>').addClass('nivo-main-image');
        sliderImg.attr('src', vars.currentImage.attr('src')).attr('style', vars.currentImage.attr('style')).show();
        slider.append(sliderImg);

        // Detect Window Resize
        $(window).resize(function() {
            slider.children('img').width(slider.width());
            sliderImg.attr('src', vars.currentImage.attr('src'));
            sliderImg.stop().height('auto');
            $('.nivo-slice').remove();
            $('.nivo-box').remove();
        });

        /**
         * YourBestCode caption, support@yourbestcode.com 
         */
        //Create caption        
        slider.append($('<div class="ybc-caption-wrapper"></div>'));
        
        // Process caption function
        var processCaption = function(settings){            
            var ybcSlideId = vars.currentImage.attr('data-slide-id');
            var caption1 = vars.currentImage.attr('data-caption1') != undefined && vars.currentImage.attr('data-caption1') != '' ? '<div class="caption1 ybc-caption-type"><span class="caption-span">'+vars.currentImage.attr('data-caption1')+'</span></div>' : '';
            
            var caption2 = vars.currentImage.attr('data-caption2') != undefined && vars.currentImage.attr('data-caption2') != '' ? '<div class="caption2 ybc-caption-type"><span class="caption-span">'+vars.currentImage.attr('data-caption2')+'</span></div>' : '';
            var caption3 = vars.currentImage.attr('data-caption3') != undefined && vars.currentImage.attr('data-caption3') != '' ? '<div class="caption3 ybc-caption-type"><span class="caption-span">'+vars.currentImage.attr('data-caption3')+'</span></div>' : '';
            var caption4 = $('.ybc-nivo-description-'+ybcSlideId).length > 0 && $('.ybc-nivo-description-'+ybcSlideId).html()!='' ? '<div class="caption4 ybc-caption-type"><span class="caption-span">'+$('.ybc-nivo-description-'+ybcSlideId).html()+'</span></div>' : '';            
            var caption5 = $('.ybc_button_slider.ybc_button_'+ybcSlideId).length > 0 && $('.ybc_button_slider.ybc_button_'+ybcSlideId).html()!='' ? '<p class="caption5 ybc-caption-type ybc_button_slider ybc_button_'+ybcSlideId+'">'+$('#ybc-nivo-caption-text-hidden .ybc_button_slider.ybc_button_'+ybcSlideId).html()+'</p>' : '';            
            var captionTextDirection = (vars.currentImage.attr('data-text-direction') != undefined && vars.currentImage.attr('data-text-direction') != '') ? 'ybc-caption-text-' + vars.currentImage.attr('data-text-direction') : 'ybc-caption-text-left';
            var captionTop = (vars.currentImage.attr('data-caption-top') != undefined && vars.currentImage.attr('data-caption-top') != '') ? vars.currentImage.attr('data-caption-top') : '0';
            var captionLeft = (vars.currentImage.attr('data-caption-left') != undefined && vars.currentImage.attr('data-caption-left') != '') ? vars.currentImage.attr('data-caption-left') : '0';
            var captionRight = (vars.currentImage.attr('data-caption-right') != undefined && vars.currentImage.attr('data-caption-right') != '') ? vars.currentImage.attr('data-caption-right') : '0';
            var captionPosition = (vars.currentImage.attr('data-caption-position') != undefined && vars.currentImage.attr('data-caption-position') != '') ? 'ybc-caption-position-' + vars.currentImage.attr('data-caption-position') : 'ybc-caption-position-left';
            var captionWidth = (vars.currentImage.attr('data-caption-width') != undefined && vars.currentImage.attr('data-caption-width') != '') ?  vars.currentImage.attr('data-caption-width') : '40%';
            var captionAnimation = (vars.currentImage.attr('data-caption-animate') != undefined && vars.currentImage.attr('data-caption-animate') != '') ? vars.currentImage.attr('data-caption-animate') : 'random';
            if(caption1 != '' || caption2 != '' || caption3 != '' || caption4 != '')
            {
                var ybcCaption = '<div class="ybc-caption-frame caption-id-'+vars.currentImage.attr('data-slide-id')+' caption-skin-'+vars.currentImage.attr('data-caption-skin')+'" style="width:'+settings.textFrameWidth+';"><div class="ybc-caption '+captionPosition+' '+captionTextDirection+'" style="padding-top: '+captionTop+';margin-left: '+captionLeft+';margin-right: '+captionRight+'; width: '+captionWidth+';">' + caption1 + caption2 + caption3 +  caption4 + caption5 + '</div></div>';
                $('.ybc-caption-wrapper').html(ybcCaption);
                $('.ybc-caption-wrapper').stop().show();
                //alert(captionAnimation);
                switch(captionAnimation)
                {
                    case 'left':
                        ybcCaptionFlyLeft(settings);
                        break;
                    case 'right':
                        ybcCaptionFlyRight(settings);
                        break;
                    case 'repeat':
                        ybcCaptionRepeat(settings);
                        break;
                    case 'close':
                        ybcCaptionClose(settings);
                        break;
                    case 'fade':
                        ybcCaptionFade(settings);
                        break;
                    case 'left-right':
                        ybcCaptionFlyLeftRight(settings);
                        break;
                    default:
                        ybcCaptionRandom(settings);
                        break;
                }                                
            }
            else
            {
                $('.ybc-caption-wrapper').stop().fadeOut(settings.animSpeed);
            }           
            
        }
        
        /**
         * Caption animation types 
         */
        
        var ybcCaptionRandom = function(settings)
        {
            var animations = ['left','right','repeat','close','fade','left-right'];
            var min = 0;
            var max = 5;
            var captionIndex = Math.floor(Math.random()*(max-min+1)+min);
            if(captionIndex < 0)
                captionIndex = 0;
            if(captionIndex > 5)
                captionIndex = 5;
            switch(animations[captionIndex])
            {
                case 'left':
                    ybcCaptionFlyLeft(settings);
                    break;
                case 'right':
                    ybcCaptionFlyRight(settings);
                    break;
                case 'repeat':
                    ybcCaptionRepeat(settings);
                    break;
                case 'close':
                    ybcCaptionClose(settings);
                    break;
                case 'fade':
                    ybcCaptionFade(settings);
                    break;
                case 'left-right':
                    ybcCaptionFlyLeftRight(settings);
                    break;
            } 
        }
        var ybcCaptionRepeat = function(settings)
        {
            if($('.ybc-caption-type').length > 0)
            {
                $('.ybc-caption-type').css('opacity','0');
                $('.ybc-caption-type').css('top','-20px');
                $('.ybc-caption-type').addClass('ybc-caption-repeat');
                var captions = Array();
                for(i = 1; i<=5; i++)
                {
                    if($('.caption'+i).length > 0)
                        captions.push('.caption'+i);
                }
                
                var captionNumber = captions.length;
                
                var captionInex = 0;
                if(captionNumber > 0)
                {
                    var captionInterval = setInterval(function(){
                        if(captionInex <= captionNumber-1)
                        {
                            $(captions[captionInex]).stop(1,1).animate({
                                        'opacity' : '0.6',
                                        'top' : '5px'
                            }, settings.captionDelay).animate(
                                    {
                                        'top' : '0',
                                        'opacity' : '1'
                                    },settings.captionDelay);                         
                            captionInex++;
                        }
                        else
                            clearInterval(captionInterval);
                    }, settings.captionDelay);   
                }                                 
            }            
        }
        var ybcCaptionFlyLeft = function(settings)
        {
            if($('.ybc-caption-type').length > 0)
            {
                $('.ybc-caption-type').addClass('ybc-caption-left');
                $('.ybc-caption-type').css('opacity','0');
                $('.ybc-caption-type').css('left','-50px');
                
                var captions = Array();
                for(i = 1; i<=5; i++)
                {
                    if($('.caption'+i).length > 0)
                        captions.push('.caption'+i);
                }
                
                var captionNumber = captions.length;
                
                var captionInex = 0;
                if(captionNumber > 0)
                {
                    var captionInterval = setInterval(function(){
                        if(captionInex <= captionNumber-1)
                        {
                            $(captions[captionInex]).stop(1,1).animate({
                                        'opacity' : '1',
                                        'left' : '0'
                            }, settings.captionDelay * 2);                            
                            captionInex++;
                        }
                        else
                            clearInterval(captionInterval);
                    }, settings.captionDelay);   
                }                                 
            }            
        }
        var ybcCaptionClose = function(settings)
        {
            if($('.ybc-caption-type').length > 0)
            {
                $('.ybc-caption-type').css('opacity','0');
                $('.ybc-caption-type').addClass('ybc-caption-close');
                $('.ybc-caption-type').eq(0).css('top','-50px');
                $('.ybc-caption-type').eq(0).animate({
                                        'opacity' : '1',
                                        'top' : '0'
                            }, settings.captionDelay * 8);
               if($('.ybc-caption-type').length > 1)
               {
                    for(i = 1; i<= $('.ybc-caption-type').length; i++ )
                    {
                        $('.ybc-caption-type').eq(i).css('bottom','-50px');
                        $('.ybc-caption-type').eq(i).animate({
                                        'opacity' : '1',
                                        'bottom' : '0'
                            }, settings.captionDelay * 8);
                    }
               } 
                               
            }            
        }
        var ybcCaptionFlyRight = function(settings)
        {
            if($('.ybc-caption-type').length > 0)
            {
                $('.ybc-caption-type').css('opacity','0');
                $('.ybc-caption-type').css('right','-50px');
                $('.ybc-caption-type').addClass('ybc-caption-right');
                var captions = Array();
                for(i = 1; i<=5; i++)
                {
                    if($('.caption'+i).length > 0)
                        captions.push('.caption'+i);
                }
                
                var captionNumber = captions.length;
                
                var captionInex = 0;
                if(captionNumber > 0)
                {
                    var captionInterval = setInterval(function(){
                        if(captionInex <= captionNumber-1)
                        {
                            $(captions[captionInex]).stop(1,1).animate({
                                        'opacity' : '1',
                                        'right' : '0'
                            }, settings.captionDelay * 2);                            
                            captionInex++;
                        }
                        else
                            clearInterval(captionInterval);
                    }, settings.captionDelay * 2);   
                }                                 
            }            
        }
        var ybcCaptionFlyLeftRight = function(settings)
        {
            if($('.ybc-caption-type').length > 0)
            {
                $('.ybc-caption-type').addClass('ybc-caption-left-right');
                $('.ybc-caption-type').css('opacity','0');
                var captions = Array();
                var flag = true;
                for(i = 1; i<=5; i++)
                {
                    if($('.caption'+i).length > 0)
                    {
                        captions.push('.caption'+i);
                        if(flag)
                        {
                            $('.caption'+i).css('left','-50px');
                            flag = false; 
                        }  
                        else
                        {
                            $('.caption'+i).css('left','50px');
                            flag = true; 
                        } 
                    }
                        
                }
                
                var captionNumber = captions.length;
                
                var captionInex = 0;
                if(captionNumber > 0)
                {
                    var captionInterval = setInterval(function(){
                        if(captionInex <= captionNumber-1)
                        {
                            $(captions[captionInex]).stop(1,1).animate({
                                        'opacity' : '1',
                                        'left' : '0'
                            }, settings.captionDelay * 2);                            
                            captionInex++;
                        }
                        else
                            clearInterval(captionInterval);
                    }, settings.captionDelay);   
                }                                 
            }            
        }
        
        var ybcCaptionFade = function(settings)
        {
            if($('.ybc-caption-type').length > 0)
            {
                $('.ybc-caption-type').addClass('ybc-caption-fade');
                $('.ybc-caption-type').css('top','-50px');
                $('.ybc-caption-type').css('opacity','0');
                $('.ybc-caption-type').animate({'opacity' : '1','top' : '0'}, settings.captionDelay * 10);                                             
            }            
        }
        
        
        //Process initial  caption
        processCaption(settings);
        
        // In the words of Super Mario "let's a go!"
        var timer = 0;
        if(!settings.manualAdvance && kids.length > 1){
            timer = setInterval(function(){ nivoRun(slider, kids, settings, false); }, settings.pauseTime);
        }
        
        // Add Direction nav
        if(settings.directionNav){
            slider.append('<div class="nivo-directionNav"><a class="nivo-prevNav">'+ settings.prevText +'</a><a class="nivo-nextNav">'+ settings.nextText +'</a></div>');
            
            $(slider).on('click', 'a.nivo-prevNav', function(){
                if(vars.running) { return false; }
                clearInterval(timer);
                timer = '';
                vars.currentSlide -= 2;
                nivoRun(slider, kids, settings, 'prev');
            });
            
            $(slider).on('click', 'a.nivo-nextNav', function(){
                if(vars.running) { return false; }
                clearInterval(timer);
                timer = '';
                nivoRun(slider, kids, settings, 'next');
            });
        }
        
        // Add Control nav
        if(settings.controlNav){
            vars.controlNavEl = $('<div class="nivo-controlNav"></div>');
            slider.after(vars.controlNavEl);
            for(var i = 0; i < kids.length; i++){
                if(settings.controlNavThumbs){
                    vars.controlNavEl.addClass('nivo-thumbs-enabled');
                    var child = kids.eq(i);
                    if(!child.is('img')){
                        child = child.find('img:first');
                    }
                    if(child.attr('data-thumb')) vars.controlNavEl.append('<a class="nivo-control" rel="'+ i +'"><img src="'+ child.attr('data-thumb') +'" alt="" /></a>');
                } else {
                    vars.controlNavEl.append('<a class="nivo-control" rel="'+ i +'">'+ (i + 1) +'</a>');
                }
            }

            //Set initial active link
            $('a:eq('+ vars.currentSlide +')', vars.controlNavEl).addClass('active');
            
            $('a', vars.controlNavEl).bind('click', function(){
                if(vars.running) return false;
                if($(this).hasClass('active')) return false;
                clearInterval(timer);
                timer = '';
                sliderImg.attr('src', vars.currentImage.attr('src'));
                vars.currentSlide = $(this).attr('rel') - 1;
                nivoRun(slider, kids, settings, 'control');
            });
        }
        
        //For pauseOnHover setting
        if(settings.pauseOnHover){
            slider.hover(function(){
                vars.paused = true;
                clearInterval(timer);
                timer = '';
            }, function(){
                vars.paused = false;
                // Restart the timer
                if(timer === '' && !settings.manualAdvance){
                    timer = setInterval(function(){ nivoRun(slider, kids, settings, false); }, settings.pauseTime);
                }
            });
        }
        
        // Event when Animation finishes
        slider.bind('nivo:animFinished', function(){
            sliderImg.attr('src', vars.currentImage.attr('src'));
            vars.running = false; 
            // Hide child links
            $(kids).each(function(){
                if($(this).is('a')){
                   $(this).css('display','none');
                }
            });
            // Show current link
            if($(kids[vars.currentSlide]).is('a')){
                $(kids[vars.currentSlide]).css('display','block');
            }
            // Restart the timer
            if(timer === '' && !vars.paused && !settings.manualAdvance){
                timer = setInterval(function(){ nivoRun(slider, kids, settings, false); }, settings.pauseTime);
            }
            // Trigger the afterChange callback
            settings.afterChange.call(this);
        }); 
        
        // Add slices for slice animations
        var createSlices = function(slider, settings, vars) {
        	if($(vars.currentImage).parent().is('a')) $(vars.currentImage).parent().css('display','block');
            $('img[src="'+ vars.currentImage.attr('src') +'"]', slider).not('.nivo-main-image,.nivo-control img').width(slider.width()).css('visibility', 'hidden').show();
            var sliceHeight = ($('img[src="'+ vars.currentImage.attr('src') +'"]', slider).not('.nivo-main-image,.nivo-control img').parent().is('a')) ? $('img[src="'+ vars.currentImage.attr('src') +'"]', slider).not('.nivo-main-image,.nivo-control img').parents('.nivoSlider').find('.ybc-nivo-link.nivo-imageLink:not(:hidden) img').height() : $('img[src="'+ vars.currentImage.attr('src') +'"]', slider).not('.nivo-main-image,.nivo-control img').height();

            for(var i = 0; i < settings.slices; i++){
                var sliceWidth = Math.round(slider.width()/settings.slices);
                
                if(i === settings.slices-1){
                    slider.append(
                        $('<div class="nivo-slice" name="'+i+'"><img src="'+ vars.currentImage.attr('src') +'" style="position:absolute; width:'+ slider.width() +'px; height:auto; display:block !important; top:0; left:-'+ ((sliceWidth + (i * sliceWidth)) - sliceWidth) +'px;" /></div>').css({ 
                            left:(sliceWidth*i)+'px', 
                            width:(slider.width()-(sliceWidth*i))+'px',
                            height:sliceHeight+'px', 
                            opacity:'0',
                            overflow:'hidden'
                        })
                    );
                } else {
                    slider.append(
                        $('<div class="nivo-slice" name="'+i+'"><img src="'+ vars.currentImage.attr('src') +'" style="position:absolute; width:'+ slider.width() +'px; height:auto; display:block !important; top:0; left:-'+ ((sliceWidth + (i * sliceWidth)) - sliceWidth) +'px;" /></div>').css({ 
                            left:(sliceWidth*i)+'px', 
                            width:sliceWidth+'px',
                            height:sliceHeight+'px',
                            opacity:'0',
                            overflow:'hidden'
                        })
                    );
                }
            }
            
            $('.nivo-slice', slider).height(sliceHeight);
            sliderImg.stop().animate({
                height: $(vars.currentImage).height()
            }, settings.animSpeed);
        };
        
        // Add boxes for box animations
        var createBoxes = function(slider, settings, vars){
        	if($(vars.currentImage).parent().is('a')) $(vars.currentImage).parent().css('display','block');
            $('img[src="'+ vars.currentImage.attr('src') +'"]', slider).not('.nivo-main-image,.nivo-control img').width(slider.width()).css('visibility', 'hidden').show();
            var boxWidth = Math.round(slider.width()/settings.boxCols),
                boxHeight = Math.round($('img[src="'+ vars.currentImage.attr('src') +'"]', slider).not('.nivo-main-image,.nivo-control img').height() / settings.boxRows);
            
                        
            for(var rows = 0; rows < settings.boxRows; rows++){
                for(var cols = 0; cols < settings.boxCols; cols++){
                    if(cols === settings.boxCols-1){
                        slider.append(
                            $('<div class="nivo-box" name="'+ cols +'" rel="'+ rows +'"><img src="'+ vars.currentImage.attr('src') +'" style="position:absolute; width:'+ slider.width() +'px; height:auto; display:block; top:-'+ (boxHeight*rows) +'px; left:-'+ (boxWidth*cols) +'px;" /></div>').css({ 
                                opacity:0,
                                left:(boxWidth*cols)+'px', 
                                top:(boxHeight*rows)+'px',
                                width:(slider.width()-(boxWidth*cols))+'px'
                                
                            })
                        );
                        $('.nivo-box[name="'+ cols +'"]', slider).height($('.nivo-box[name="'+ cols +'"] img', slider).height()+'px');
                    } else {
                        slider.append(
                            $('<div class="nivo-box" name="'+ cols +'" rel="'+ rows +'"><img src="'+ vars.currentImage.attr('src') +'" style="position:absolute; width:'+ slider.width() +'px; height:auto; display:block; top:-'+ (boxHeight*rows) +'px; left:-'+ (boxWidth*cols) +'px;" /></div>').css({ 
                                opacity:0,
                                left:(boxWidth*cols)+'px', 
                                top:(boxHeight*rows)+'px',
                                width:boxWidth+'px'
                            })
                        );
                        $('.nivo-box[name="'+ cols +'"]', slider).height($('.nivo-box[name="'+ cols +'"] img', slider).height()+'px');
                    }
                }
            }
            
            sliderImg.stop().animate({
                height: $(vars.currentImage).height()
            }, settings.animSpeed);
        };

        // Private run method
        var nivoRun = function(slider, kids, settings, nudge){          
            // Get our vars
            var vars = slider.data('nivo:vars');
            
            // Trigger the lastSlide callback
            if(vars && (vars.currentSlide === vars.totalSlides - 1)){ 
                settings.lastSlide.call(this);
            }
            
            // Stop
            if((!vars || vars.stop) && !nudge) { return false; }
            
            // Trigger the beforeChange callback
            settings.beforeChange.call(this);

            // Set current background before change
            if(!nudge){
                sliderImg.attr('src', vars.currentImage.attr('src'));
            } else {
                if(nudge === 'prev'){
                    sliderImg.attr('src', vars.currentImage.attr('src'));
                }
                if(nudge === 'next'){
                    sliderImg.attr('src', vars.currentImage.attr('src'));
                }
            }
            
            vars.currentSlide++;
            // Trigger the slideshowEnd callback
            if(vars.currentSlide === vars.totalSlides){ 
                vars.currentSlide = 0;
                settings.slideshowEnd.call(this);
            }
            if(vars.currentSlide < 0) { vars.currentSlide = (vars.totalSlides - 1); }
            // Set vars.currentImage
            if($(kids[vars.currentSlide]).is('img')){
                vars.currentImage = $(kids[vars.currentSlide]);
            } else {
                vars.currentImage = $(kids[vars.currentSlide]).find('img:first');
            }
            
            // Set active links
            if(settings.controlNav){
                $('a', vars.controlNavEl).removeClass('active');
                $('a:eq('+ vars.currentSlide +')', vars.controlNavEl).addClass('active');
            }
            
            // Process caption
            processCaption(settings);            
            
            // Remove any slices from last transition
            $('.nivo-slice', slider).remove();
            
            // Remove any boxes from last transition
            $('.nivo-box', slider).remove();
            
            var currentEffect = settings.effect,
                anims = '';
                
            // Generate random effect
            if(settings.effect === 'random'){
                anims = new Array('sliceDownRight','sliceDownLeft','sliceUpRight','sliceUpLeft','sliceUpDown','sliceUpDownLeft','fold','fade',
                'boxRandom','boxRain','boxRainReverse','boxRainGrow','boxRainGrowReverse');
                currentEffect = anims[Math.floor(Math.random()*(anims.length + 1))];
                if(currentEffect === undefined) { currentEffect = 'fade'; }
            }
            
            // Run random effect from specified set (eg: effect:'fold,fade')
            if(settings.effect.indexOf(',') !== -1){
                anims = settings.effect.split(',');
                currentEffect = anims[Math.floor(Math.random()*(anims.length))];
                if(currentEffect === undefined) { currentEffect = 'fade'; }
            }
            
            // Custom transition as defined by "data-transition" attribute
            if(vars.currentImage.attr('data-transition')){
                currentEffect = vars.currentImage.attr('data-transition');
            }
        
            // Run effects
            vars.running = true;
            var timeBuff = 0,
                i = 0,
                slices = '',
                firstSlice = '',
                totalBoxes = '',
                boxes = '';
            
            if(currentEffect === 'sliceDown' || currentEffect === 'sliceDownRight' || currentEffect === 'sliceDownLeft'){
                createSlices(slider, settings, vars);
                timeBuff = 0;
                i = 0;
                slices = $('.nivo-slice', slider);
                if(currentEffect === 'sliceDownLeft') { slices = $('.nivo-slice', slider)._reverse(); }
                
                slices.each(function(){
                    var slice = $(this);
                    slice.css({ 'top': '0px' });
                    if(i === settings.slices-1){
                        setTimeout(function(){
                            slice.animate({opacity:'1.0' }, settings.animSpeed, '', function(){ slider.trigger('nivo:animFinished'); });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function(){
                            slice.animate({opacity:'1.0' }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    i++;
                });
            } else if(currentEffect === 'sliceUp' || currentEffect === 'sliceUpRight' || currentEffect === 'sliceUpLeft'){
                createSlices(slider, settings, vars);
                timeBuff = 0;
                i = 0;
                slices = $('.nivo-slice', slider);
                if(currentEffect === 'sliceUpLeft') { slices = $('.nivo-slice', slider)._reverse(); }
                
                slices.each(function(){
                    var slice = $(this);
                    slice.css({ 'bottom': '0px' });
                    if(i === settings.slices-1){
                        setTimeout(function(){
                            slice.animate({opacity:'1.0' }, settings.animSpeed, '', function(){ slider.trigger('nivo:animFinished'); });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function(){
                            slice.animate({opacity:'1.0' }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    i++;
                });
            } else if(currentEffect === 'sliceUpDown' || currentEffect === 'sliceUpDownRight' || currentEffect === 'sliceUpDownLeft'){
                createSlices(slider, settings, vars);
                timeBuff = 0;
                i = 0;
                var v = 0;
                slices = $('.nivo-slice', slider);
                if(currentEffect === 'sliceUpDownLeft') { slices = $('.nivo-slice', slider)._reverse(); }
                
                slices.each(function(){
                    var slice = $(this);
                    if(i === 0){
                        slice.css('top','0px');
                        i++;
                    } else {
                        slice.css('bottom','0px');
                        i = 0;
                    }
                    
                    if(v === settings.slices-1){
                        setTimeout(function(){
                            slice.animate({opacity:'1.0' }, settings.animSpeed, '', function(){ slider.trigger('nivo:animFinished'); });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function(){
                            slice.animate({opacity:'1.0' }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    v++;
                });
            } else if(currentEffect === 'fold'){
                createSlices(slider, settings, vars);
                timeBuff = 0;
                i = 0;
                
                $('.nivo-slice', slider).each(function(){
                    var slice = $(this);
                    var origWidth = slice.width();
                    slice.css({ top:'0px', width:'0px' });
                    if(i === settings.slices-1){
                        setTimeout(function(){
                            slice.animate({ width:origWidth, opacity:'1.0' }, settings.animSpeed, '', function(){ slider.trigger('nivo:animFinished'); });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function(){
                            slice.animate({ width:origWidth, opacity:'1.0' }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    i++;
                });
            } else if(currentEffect === 'fade'){
                createSlices(slider, settings, vars);
                
                firstSlice = $('.nivo-slice:first', slider);
                firstSlice.css({
                    'width': slider.width() + 'px'
                });
    
                firstSlice.animate({ opacity:'1.0' }, (settings.animSpeed*2), '', function(){ slider.trigger('nivo:animFinished'); });
            } else if(currentEffect === 'slideInRight'){
                createSlices(slider, settings, vars);
                
                firstSlice = $('.nivo-slice:first', slider);
                firstSlice.css({
                    'width': '0px',
                    'opacity': '1'
                });

                firstSlice.animate({ width: slider.width() + 'px' }, (settings.animSpeed*2), '', function(){ slider.trigger('nivo:animFinished'); });
            } else if(currentEffect === 'slideInLeft'){
                createSlices(slider, settings, vars);
                
                firstSlice = $('.nivo-slice:first', slider);
                firstSlice.css({
                    'width': '0px',
                    'opacity': '1',
                    'left': '',
                    'right': '0px'
                });

                firstSlice.animate({ width: slider.width() + 'px' }, (settings.animSpeed*2), '', function(){ 
                    // Reset positioning
                    firstSlice.css({
                        'left': '0px',
                        'right': ''
                    });
                    slider.trigger('nivo:animFinished'); 
                });
            } else if(currentEffect === 'boxRandom'){
                createBoxes(slider, settings, vars);
                
                totalBoxes = settings.boxCols * settings.boxRows;
                i = 0;
                timeBuff = 0;

                boxes = shuffle($('.nivo-box', slider));
                boxes.each(function(){
                    var box = $(this);
                    if(i === totalBoxes-1){
                        setTimeout(function(){
                            box.animate({ opacity:'1' }, settings.animSpeed, '', function(){ slider.trigger('nivo:animFinished'); });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function(){
                            box.animate({ opacity:'1' }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 20;
                    i++;
                });
            } else if(currentEffect === 'boxRain' || currentEffect === 'boxRainReverse' || currentEffect === 'boxRainGrow' || currentEffect === 'boxRainGrowReverse'){
                createBoxes(slider, settings, vars);
                
                totalBoxes = settings.boxCols * settings.boxRows;
                i = 0;
                timeBuff = 0;
                
                // Split boxes into 2D array
                var rowIndex = 0;
                var colIndex = 0;
                var box2Darr = [];
                box2Darr[rowIndex] = [];
                boxes = $('.nivo-box', slider);
                if(currentEffect === 'boxRainReverse' || currentEffect === 'boxRainGrowReverse'){
                    boxes = $('.nivo-box', slider)._reverse();
                }
                boxes.each(function(){
                    box2Darr[rowIndex][colIndex] = $(this);
                    colIndex++;
                    if(colIndex === settings.boxCols){
                        rowIndex++;
                        colIndex = 0;
                        box2Darr[rowIndex] = [];
                    }
                });
                
                // Run animation
                for(var cols = 0; cols < (settings.boxCols * 2); cols++){
                    var prevCol = cols;
                    for(var rows = 0; rows < settings.boxRows; rows++){
                        if(prevCol >= 0 && prevCol < settings.boxCols){
                            /* Due to some weird JS bug with loop vars 
                            being used in setTimeout, this is wrapped
                            with an anonymous function call */
                            (function(row, col, time, i, totalBoxes) {
                                var box = $(box2Darr[row][col]);
                                var w = box.width();
                                var h = box.height();
                                if(currentEffect === 'boxRainGrow' || currentEffect === 'boxRainGrowReverse'){
                                    box.width(0).height(0);
                                }
                                if(i === totalBoxes-1){
                                    setTimeout(function(){
                                        box.animate({ opacity:'1', width:w, height:h }, settings.animSpeed/1.3, '', function(){ slider.trigger('nivo:animFinished'); });
                                    }, (100 + time));
                                } else {
                                    setTimeout(function(){
                                        box.animate({ opacity:'1', width:w, height:h }, settings.animSpeed/1.3);
                                    }, (100 + time));
                                }
                            })(rows, prevCol, timeBuff, i, totalBoxes);
                            i++;
                        }
                        prevCol--;
                    }
                    timeBuff += 100;
                }
            }           
        };
        
        // Shuffle an array
        var shuffle = function(arr){
            for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i, 10), x = arr[--i], arr[i] = arr[j], arr[j] = x);
            return arr;
        };
        
        // For debugging
        var trace = function(msg){
            if(this.console && typeof console.log !== 'undefined') { console.log(msg); }
        };
        
        // Start / Stop
        this.stop = function(){
            if(!$(element).data('nivo:vars').stop){
                $(element).data('nivo:vars').stop = true;
                trace('Stop Slider');
            }
        };
        
        this.start = function(){
            if($(element).data('nivo:vars').stop){
                $(element).data('nivo:vars').stop = false;
                trace('Start Slider');
            }
        };
        
        // Trigger the afterLoad callback
        settings.afterLoad.call(this);
        
        return this;
    };
        
    $.fn.nivoSlider = function(options) {
        return this.each(function(key, value){
            var element = $(this);
            // Return early if this element already has a plugin instance
            if (element.data('nivoslider')) { return element.data('nivoslider'); }
            // Pass options to plugin constructor
            var nivoslider = new NivoSlider(this, options);
            // Store plugin object in this element's data
            element.data('nivoslider', nivoslider);
        });
    };
    
    //Default settings
    $.fn.nivoSlider.defaults = {
        effect: 'random',
        textFrameWidth: '100%',
        captionDelay : 200,        
        slices: 15,
        boxCols: 8,
        boxRows: 4,
        animSpeed: 500,
        pauseTime: 3000,
        startSlide: 0,
        directionNav: true,
        controlNav: true,
        controlNavThumbs: false,
        pauseOnHover: true,
        manualAdvance: false,
        prevText: 'Prev',
        nextText: 'Next',
        randomStart: false,
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){},
        lastSlide: function(){},
        afterLoad: function(){}
    };

    $.fn._reverse = [].reverse;
    
})(jQuery);