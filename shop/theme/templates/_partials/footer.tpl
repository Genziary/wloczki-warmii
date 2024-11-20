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
<div class="footer-container">
  <div class="container">
    <div class="footer-middle">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-4 col-xs-12">
          {widget name='ps_contactinfo'}
        </div>

        <div class="col-sm-12 col-md-12 col-lg-4 col-xs-12">
          {block name='hook_footer'}
            {hook h='displayFooter'}
          {/block}
        </div>

        <div class="col-sm-12 col-md-12 col-lg-4 col-xs-12">
          {block name='hook_footer_before'}
            {hook h='displayFooterBefore'}
          {/block}
        </div>
      </div>
    </div>
  </div>

  <div class="footer_bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-4 links footer_block">
          <div class="copyright">Copyright © Włóczki Warmii 2024. Realizacja <a href="https://github.com/Genziary/wloczki-warmii" target="_blank" rel="noopener">Genziary</a></div>
        </div>
        <div class="col-md-8 links footer_block">
        <div class="payment"></div>
        </div>
      </div>
    </div>
  </div>
</div>
