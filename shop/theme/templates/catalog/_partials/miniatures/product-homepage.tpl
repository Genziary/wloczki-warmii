{block name='product_miniature_item'}
<div class="item-product col-xs-12 col-sm-6 col-md-6 col-lg-3">
  <article class="js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
    <div class="img_block">
      {if $product.cover}
        <a href="{$product.url}" class="thumbnail product-thumbnail">
          <img
            src="{$product.cover.bySize.home_default.url}"
            alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
            loading="lazy"
            data-full-size-image-url="{$product.cover.large.url}"
            width="{$product.cover.bySize.home_default.width}"
            height="{$product.cover.bySize.home_default.height}"
          />
        </a>
      {else}
        <a href="{$product.url}" class="thumbnail product-thumbnail">
          <img
            src="{$urls.no_picture_image.bySize.home_default.url}"
            loading="lazy"
            width="{$urls.no_picture_image.bySize.home_default.width}"
            height="{$urls.no_picture_image.bySize.home_default.height}"
          />
        </a>
      {/if}

      {include file='catalog/_partials/product-flags.tpl'}

      <div class="quick_view">
        <a class="quick-view js-quick-view" href="#" data-link-action="quickview" aria-label="{l s='Quick view' d='Shop.Theme.Actions'}">
          <i class="material-icons search">&#xE8B6;</i>
        </a>
      </div>
    </div>
    <div class="product_desc">
      <div class="desc_info">
        <h4>
          <a class="product_name" href="{$product.url}" content="{$product.url}">
            {$product.name|truncate:30:'...'}
          </a>
        </h4>

        <div class="hook-reviews">
          {l s='Quantity' d='Shop.Theme.Catalog'}: {$product.quantity}
        </div>

        <div class="hover">
          {if $product.show_price}
            <div class="product-price-and-shipping">
              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}

                <span class="regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
                {if $product.discount_type === 'percentage'}
                  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                {elseif $product.discount_type === 'amount'}
                  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                {/if}
              {/if}

              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              <span class="price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
                {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                {if '' !== $smarty.capture.custom_price}
                  {$smarty.capture.custom_price nofilter}
                {else}
                  {$product.price}
                {/if}
              </span>

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
          {/if}
          <div class="add-to-links">
            <div class="product-add-to-cart">
               <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                  <input type="hidden" name="token" value="{$static_token}" />
                  <input type="hidden" name="id_product" value="{$product.id}" class="product_page_product_id" />
                  <input type="hidden" name="qty" value="1" />
                  <button
                    class="button btn-default ajax_add_to_cart_button add-to-cart"
                    data-button-action="add-to-cart"
                    type="submit"
                    {if !$product.add_to_cart_url}
                      disabled
                    {/if}
                  >
                    {l s='Add to cart' d='Shop.Theme.Actions'}
                  </button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>
</div>
{/block}
