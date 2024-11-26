{**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div class="img_content">
  <img class="product-image img-responsive" src="{$product.images[0].small.url}">
  <span class="product-quantity">{$product.quantity}x</span>
</div>
<div class="right_block">
  <span class="product-name">{$product.name}</span>
  <span class="product-price">{$product.price}</span>
  <a class="remove-from-cart"
     rel="nofollow"
     href="{$product.remove_from_cart_url}"
     data-link-action="remove-from-cart"
  >
    <i class="material-icons pull-xs-left">delete</i>
  </a>
  {if $product.attributes|count}
    <div class="attributes_content">
      {foreach from=$product.attributes item=value key=name}
        <span>
          <strong>{$name}</strong>: {$value}
        </span>
        <br />
      {/foreach}
    </div>
{/if}
</div>

