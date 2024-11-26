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
<div class="panel"><h3><i class="icon-list-ul"></i> {l s='Slides list' mod='ybc_nivoslider'}
	
    <span class="panel-heading-action">
        <a style="padding-left: 5px;" id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}&configure=ybc_nivoslider&show_setting=true">
			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Settings" data-html="true">
				<i style="color: #ff5450;" class="icon-wrench"></i>
			</span>
		</a>
		<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}&configure=ybc_nivoslider&addSlide=1">
			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
				<i style="color: #2ba8e3;" class="process-icon-new "></i>
			</span>
		</a>
	</span>
	</h3>
	<div id="slidesContent">
		<div id="slides">
			{if $slides}
			{foreach from=$slides item=slide}
				<div id="slides_{$slide.id_slide|escape:'html':'UTF-8'}" data-id="{$slide.id_slide|escape:'html':'UTF-8'}" class="panel">
					<div class="row">
						<div class="col-lg-1">
							<span><i class="icon-arrows "></i></span>
						</div>
						<div class="col-md-3">
							<img src="{$image_baseurl|escape:'html':'UTF-8'}{$slide.image|escape:'html':'UTF-8'}" alt="{$slide.title|escape:'html':'UTF-8'}" class="img-thumbnail" />
						</div>
						<div class="col-md-8">
							<h4 class="pull-left">#{$slide.id_slide|escape:'html':'UTF-8'} - {$slide.title|escape:'html':'UTF-8'}</h4>
							<div class="btn-group-action pull-right">
								{$slide.status nofilter}
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}&configure=ybc_nivoslider&id_slide={$slide.id_slide nofilter}">
									<i class="icon-edit"></i>
									{l s='Edit' mod='ybc_nivoslider'}
								</a>
								<a onclick="return confirm('{l s='Do you want to delete this slide?' mod='ybc_nivoslider'}')" class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}&configure=ybc_nivoslider&delete_id_slide={$slide.id_slide nofilter}">
									<i class="icon-trash"></i>
									{l s='Delete' mod='ybc_nivoslider'}
								</a>
							</div>
						</div>
					</div>
				</div>
			{/foreach}
			{else}
				{l s='No slides available' mod='ybc_nivoslider'}
			{/if}
		</div>
	</div>
</div>