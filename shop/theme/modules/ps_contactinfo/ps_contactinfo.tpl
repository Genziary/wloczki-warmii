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

<div class="footer_about_us">
  <div class="desc_info">
    <p class="txt_info">
      <strong>{$contact_infos.company}</strong>
      <br />
      {$contact_infos.address.address1}
      <br />
      {$contact_infos.address.postcode} {$contact_infos.address.city}
    </p>
    <div class="need_help">
      <p>Skontaktuj się</p>
      <p class="phone">
        {l
        s='Tel. %phone%'
        sprintf=[
        '%phone%' => $contact_infos.phone
        ]
        d='Modules.Contactinfo.Shop'
        }
      </p>
    </div>
    <p class="txt_info">
      {if $contact_infos.email && $display_email}
          <br />
          {mailto address=$contact_infos.email encode="javascript"}
      {/if}
      <br />
    </p>
  </div>
  <div class="cocial_follow">
    <ul class="socialmedia1">
      <li>
        <a href="https://www.facebook.com/wloczkiwarmii/" target="_blank" class="img_desktop" rel="noopener">
          <img src="https://wloczkiwarmii.pl/themes/theme_optima_jewelry5/assets/img/fb.png">
        </a>
      </li>
      <li>
        <a href="https://www.ravelry.com/projects/joskiba" target="_blank" class="img_desktop" rel="noopener">
          <img src="https://wloczkiwarmii.pl/themes/theme_optima_jewelry5/assets/img/r.png">
        </a>
      </li>
      <li>
        <a href="https://www.instagram.com/wloczkiwarmii/?hl=pl" target="_blank" class="img_desktop" rel="noopener">
          <img src="https://wloczkiwarmii.pl/themes/theme_optima_jewelry5/assets/img/in.png">
        </a>
      </li>
    </ul>
  </div>
</div>
