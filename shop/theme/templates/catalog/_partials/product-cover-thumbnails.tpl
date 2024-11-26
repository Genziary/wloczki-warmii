{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
<div class="images-container">
  {block name='product_images'}
    <div class="js-qv-mask mask pos_content">
      <div class="product-images js-qv-product-images owl-carousel owl-loaded owl-drag">
        <div class="owl-stage-outer">
          <div class="owl-stage">
            {assign "image_step" 4}
            {for $group=0 to $product.images|count step $image_step}
              <div class="owl-item">
                <div class="thumb-container">
                  {for $image_index=$group*$image_step to min($product.images|count - 1, ($group+1)*$image_step)}
                    {assign "image" $product.images[$image_index]}
                    <img
                      class="thumb js-thumb {if $image.id_image == $product.default_image.id_image} selected js-thumb-selected {/if}"
                      data-image-medium-src="{$image.bySize.medium_default.url}"
                      data-image-large-src="{$image.bySize.large_default.url}"
                      src="{$image.bySize.small_default.url}"
                      {if !empty($image.legend)}
                        alt="{$image.legend}"
                        title="{$image.legend}"
                      {else}
                        alt="{$product.name}"
                      {/if}
                      loading="lazy"
                      width="{$product.default_image.bySize.small_default.width}"
                      height="{$product.default_image.bySize.small_default.height}"
                    >
                  {/for}
                </div>
              </div>
            {/for}
          </div>
        </div>
      </div>
    </div>
  {/block}

{block name='product_cover'}
    <div class="product-cover">
      {if $product.default_image}
        <img
          class="js-qv-product-cover img-fluid"
          src="{$product.default_image.bySize.large_default.url}"
          {if !empty($product.default_image.legend)}
            alt="{$product.default_image.legend}"
            title="{$product.default_image.legend}"
          {else}
            alt="{$product.name}"
          {/if}
          loading="lazy"
          width="{$product.default_image.bySize.large_default.width}"
          height="{$product.default_image.bySize.large_default.height}"
        >
        <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
          <i class="material-icons zoom-in">search</i>
        </div>
      {else}
        <img
          class="img-fluid"
          src="{$urls.no_picture_image.bySize.medium_default.url}"
          loading="lazy"
          width="{$urls.no_picture_image.bySize.medium_default.width}"
          height="{$urls.no_picture_image.bySize.medium_default.height}"
        >
      {/if}
    </div>
  {/block}

{hook h='displayAfterProductThumbs' product=$product}
</div>
<script type="module">
  var owl = $("#product .images-container .product-images");
  if(owl) {
    owl.owlCarousel({
      loop: true,
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      autoPlay : false ,
      smartSpeed: 1000,
      autoplayHoverPause: true,
      nav: true,
      dots : false,	
      responsive:{
        0:{
          items:1,
        },
        480:{
          items:1,
        },
        768:{
          items:1,
          nav:false,
        },
        992:{
          items:1,
        },
        1200:{
          items:1,
        }
      }
    }); 
  }

  var owl = $(".quickview .images-container .product-images");
  if(owl) {
    owl.owlCarousel({
      loop: true,
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      autoPlay : false ,
      smartSpeed: 1000,
      autoplayHoverPause: true,
      nav: true,
      dots : false,	
      responsive:{
        0:{
          items:1,
        },
        480:{
          items:1,
        },
        768:{
          items:1,
          nav:false,
        },
        992:{
          items:1,
        },
        1200:{
          items:1,
        }
      }
    }); 
  }
</script>
