{**
 * 2007-2020 PrestaShop SA and Contributors
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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{assign var=_counter value=0}
{function name="menu" nodes=[] depth=0 parent=null}
    {if $nodes|count}
      <ul class="menu-content top-menu"{if $depth == 0} id="top-menu"{/if} data-depth="{$depth}">
        {foreach from=$nodes item=node}
            <li class="{if $node.children|count} hasChild {/if} {if $depth > 0} col-xs-6 col-sm-3 {else} menu-item  {/if}" id="{$node.page_identifier}">
            {assign var=_counter value=$_counter+1}
              <a
                class="{if $depth >= 0}dropdown-item{/if}{if $depth === 1} dropdown-submenu{/if}"
                href="{$node.url}" data-depth="{$depth}"
                {if $node.open_in_new_window} target="_blank" {/if}
              >
                {if $node.image_urls|count}
                  {foreach from=$node.image_urls item=image_url}
                    <img src="{$image_url}">
                  {/foreach}
                {/if}
                {$node.label}
                {if $node.children|count}
                  {* Cannot use page identifier as we can have the same page several times *}
                  {assign var=_expand_id value=10|mt_rand:100000}
                  <span>
                    <span data-target="#top_sub_menu_{$_expand_id}" data-toggle="collapse" class="navbar-toggler collapse-icons">
                      <i class="material-icons add">&#xE313;</i>
                    </span>
                  </span>
                {/if}
              </a>
              {if $node.children|count}
              <div {if $depth === 0}class="popover sub-menu js-sub-menu collapse col-xs-12 col-sm-12 menu_slidedown"{else}class="collapse"{/if} id="top_sub_menu_{$_expand_id}">
                {menu nodes=$node.children depth=$node.depth parent=$node}
              </div>
              {/if}
            </li>
        {/foreach}
      </ul>
    {/if}
{/function}

<div class="js-top-menu pos-menu-horizontal" id="_desktop_top_menu">
    <ul class="socialmedia">
      <li>
        <a class="img_desktop" href="https://www.facebook.com/wloczkiwarmii" target="_blank">
          <img src="https://wloczkiwarmii.pl/themes/theme_optima_jewelry5/assets/img/fb.png" />
        </a>
      </li>
      <li>
        <a class="img_desktop" href="https://www.ravelry.com/projects/joskiba" target="_blank">
          <img src="https://wloczkiwarmii.pl/themes/theme_optima_jewelry5/assets/img/r.png" />
        </a>
      </li>
      <li>
        <a class="img_desktop" href="https://www.instagram.com/wloczkiwarmii" target="_blank">
          <img src="https://wloczkiwarmii.pl/themes/theme_optima_jewelry5/assets/img/in.png" />
        </a>
      </li>
    </ul>
    {menu nodes=$menu.children}
    <div class="clearfix"></div>
</div>
