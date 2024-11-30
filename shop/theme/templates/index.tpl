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
{extends file='page.tpl'}


    {block name='after_header'}
      {hook h='displayTopColumn'}
    {/block}

    {block name='wrapper_top'}
      {if $language.language_code == 'pl'}
        <div class="container">
          <div class="row buttony">
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="/pl/content/1-wysylka">
                  <img class="img-responsive" src="/img/cms/wysylka.png" alt="WYSYŁKA" width="164" height="164" />
                </a>
                <div class="banner-top-title">Wysyłka</div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="/pl/content/5-platnosci">
                  <img class="img-responsive" src="/img/cms/platnosci.png" alt="PŁATNOŚCI" width="164" height="164" />
                </a>
                <div class="banner-top-title">Płatności</div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="/pl/content/7-rabaty">
                  <img class="img-responsive" src="/img/cms/rabat.png" alt="RABAT" width="164" height="164" />
                </a>
                <div class="banner-top-title">Rabat</div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="#">
                  <img class="img-responsive" src="/img/cms/galeria.png" alt="GALERIA PRAC" width="164" height="164" />
                </a>
                <div class="banner-top-title">Galeria prac</div>
              </div>
            </div>

          </div>
        </div>
      {/if}
    {/block}

    {block name='page_content_container'}
      {block name='page_content_top'}{/block}

      <div class="row"> 
        <div class="tabs">
          <div class="tabstop"></div>
          <ul id="home-page-tabs" class="nav nav-tabs clearfix">
            <li class="nav-item" aria-expanded="false">
              <a data-toggle="tab" href="#homefeatured" class="homefeatured nav-link js-product-nav-active" aria-expanded="true">
              {l s='Our Products' d='Modules.Featuredproducts.Shop'}
              </a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#homebestsellerstab" class="homebestsellerstab nav-link">
              {l s='Best Sellers' d='Modules.Bestsellers.Shop'}
              </a>
            </li>
          </ul>
          <div id="tab-content" class="tab-content">
            {block name='page_content'}
              {block name='hook_home'}
                {$HOOK_HOME nofilter}
              {/block}
            {/block}
          </div>
        </div>
      </div>
    {/block}

    {block name='wrapper_bottom'}
      {assign wloczki_category "17-wloczki"}
      {assign colors ["bialy", "bezowy", "zolty", "pomaranczowy", "czerwony", "rozowy", "fioletowy", "niebieski", "brazowy", "szary", "czarny", "kolorowy", "zielony"]}
      <div class="container">
        <div class="pos_logo product_block_container">
          <div class="row pos_content">
            <div class="logo-slider owl-carousel owl-loaded owl-drag">
              <div class="owl-stage-outer">
                <div class="owl-stage">
                  {foreach from=$colors item=color}
                    <div class="owl-item">
                      <div>
                        <div class="item-banklogo">
                          <a href="/{$wloczki_category}?kolor={$color}">
                            <img class="replace-2x img-responsive" src="/img/yarns/{$color}.jpg" alt="Logo">
                          </a>
                        </div>
                      </div>
                    </div>
                  {/foreach}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    {/block}
