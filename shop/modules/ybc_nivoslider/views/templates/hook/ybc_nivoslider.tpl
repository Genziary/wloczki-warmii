{*
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
*}

{if $page_name =='index'}
<!-- Module ybc_nivoslider -->
    {if isset($homeslider_slides) && $homeslider_slides}
		<div id="ybc-nivo-slider-wrapper" class="theme-default {if $hide_caption}hide-caption-on-mobile{/if}">
			<div id="ybc-nivo-slider"{if isset($smarty.capture.height) && $smarty.capture.height} style="max-height:{$smarty.capture.height|escape:'html':'UTF-8'}px;"{/if}>
				{foreach from=$homeslider_slides item=slide}
					{if $slide.active}
						<a class="ybc-nivo-link" href="{if $slide.url}{$slide.url|escape:'html':'UTF-8'}{else}#{/if}" title="{$slide.title|escape:'htmlall':'UTF-8'}">
						  <img data-caption-skin="{if (int)$slide.button_type}regular{else}default{/if}" 
                          data-slide-id="{$slide.id_slide|escape:'html':'UTF-8'}" 
                          data-caption-animate="{if $slide.caption_animate}{$slide.caption_animate|escape:'html':'UTF-8'}{else}random{/if}" 
                          {if $slide.slide_effect!='random'}data-transition="{$slide.slide_effect|escape:'html':'UTF-8'}"{/if} 
                          data-caption1="{$slide.title|escape:'html':'UTF-8'}" 
                          data-bg-caption1="{$slide.color1|escape:'html':'UTF-8'}" 
                          data-caption2="{$slide.legend|escape:'htmlall':'UTF-8'}" 
                          data-bg-caption2="{$slide.color3|escape:'htmlall':'UTF-8'}" 
                          data-caption3="{$slide.legend2|escape:'html':'UTF-8'}" 
                          data-bg-caption3="{$slide.color5|escape:'html':'UTF-8'}" 
                          data-bg-description="{$slide.color6|escape:'html':'UTF-8'}" 
                          data-text-direction="{$slide.caption_text_direction|escape:'html':'UTF-8'}" 
                          data-caption-top="{$slide.caption_top|escape:'html':'UTF-8'}" 
                          data-caption-left="{$slide.caption_left|escape:'html':'UTF-8'}" 
                          data-caption-right="{$slide.caption_right|escape:'html':'UTF-8'}" 
                          data-caption-width="{$slide.caption_width|escape:'html':'UTF-8'}" 
                          data-caption-position="{$slide.caption_position|escape:'html':'UTF-8'}"    
                          src="{$link->getMediaLink("`$smarty.const._PS_IMG_`ybc_nivoslider/`$slide.image|escape:'htmlall':'UTF-8'`")}" alt="{$slide.title|escape:'htmlall':'UTF-8'}" title="{$slide.title|escape:'htmlall':'UTF-8'}"
                          style="max-width: {$options.max_width|escape:'html':'UTF-8'}; max-height: {$options.max_height|escape:'html':'UTF-8'};" />						  
                        </a>
                    {/if}
				{/foreach}
			</div>
            <div id="ybc-nivo-caption-text-hidden">
                {foreach from=$homeslider_slides item=slide}
					{if $slide.active && ($slide.description || $slide.button_text)}
                        <div class="ybc-nivo-description ybc-nivo-description-{$slide.id_slide|escape:'html':'UTF-8'}">
                            {$slide.description nofilter}
                        </div>
                        {if $slide.button_text} 
                            <p class="ybc_button_slider ybc_button_{$slide.id_slide|escape:'html':'UTF-8'}">
                                <a class="button btn ybc-nivo-button btn-default" href="{if $slide.url}{$slide.url|escape:'html':'UTF-8'}{else}#{/if}">{$slide.button_text|escape:'html':'UTF-8'}</a>
                            </p>
                        {/if}
                    {/if}
                {/foreach}
            </div>
            
            <div id="ybc-nivo-slider-loader">
                <div class="ybc-nivo-slider-loader">
                    <div id="ybc-nivo-slider-loader-img">
                        <img src="{$ybc_nivo_dir|escape:'html':'UTF-8'}views/img/loading.gif" alt=""/>
                    </div>
                </div>
            </div>
		</div>        
	{/if}
<!-- /Module ybc_nivoslider -->
{/if}