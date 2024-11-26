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
jQuery(window).load(function(){
    $('#ybc-nivo-slider').nivoSlider({
        pauseTime: YBCNIVO_PAUSE,        
        textFrameWidth: YBCNIVO_FRAME_WIDTH,
        captionDelay : YBCNIVO_CAPTION_SPEED,
        animSpeed: YBCNIVO_SPEED,  
        startSlide: YBCNIVO_START_SLIDE - 1, 
        controlNav: YBCNIVO_SHOW_CONTROL,
        pauseOnHover: YBCNIVO_PAUSE_ON_HOVER,
        manualAdvance: !YBCNIVO_LOOP,
        directionNav: YBCNIVO_SHOW_PREV_NEXT,
        afterLoad: function(){   
            $('#ybc-nivo-slider').css('opacity',1);
            $('.ybc-nivo-link').fadeIn();
            $('#ybc-nivo-slider-loader').fadeOut();
        }
    });
});