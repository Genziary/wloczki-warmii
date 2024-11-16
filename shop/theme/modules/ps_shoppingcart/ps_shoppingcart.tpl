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
<div id="_desktop_cart_block">
  <div class="blockcart cart-preview" data-refresh-url="{$refresh_url}" data-cartitems="{$cart.products_count}">
    <div class="button_cart">
      <a class="desktop hidden-md-down" rel="nofollow" href="{$cart_url}">
        <i class="material-icons cart-icon">&#xE8CB;</i>
        <span class="item_count">{$cart.products_count}</span>
        <span class="item_total">{$cart.totals.total.value}</span>
      </a>
      <a class="mobile hidden-lg-up" rel="nofollow" href="{$cart_url}">
        <span class="item_count">{$cart.products_count}</span>
      </a>
    </div>
    <div class="popup_cart">
      <div class="content-cart">
        <div class="mini_cart_arrow"></div>
        <ul>
          {foreach from=$cart.products item=product}
            <li>{include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}</li>
          {/foreach}
        </ul>
        <div class="price_content">
          <div class="cart-subtotals">
            <div id="cart-subtotal-products" class="cart-summary-line">
                <span class="label js-subtotal">{$cart.summary_string}</span>
                <span class="value">{$cart.subtotals.products.value}</span>
           </div>
            <div id="cart-subtotal-shipping" class="cart-summary-line">
                <span class="label js-subtotal">{$cart.subtotals.shipping.label}</span>
                <span class="value">{$cart.subtotals.shipping.value}</span>
            </div>
          </div>
          <div class="cart-total price_inline">
            <span class="label" style="font-weight: 700;">{$cart.totals.total.label}</span>
            <span class="value" style="font-weight: 700;">{$cart.totals.total.value}</span>
          </div>
        </div>
        <div class="checkout">
          <a class="btn btn-primary" href="{$cart_url}">
            {l s='Cart' d='Shop.Theme.Actions'}
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
