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
                <a href="https://wloczkiwarmii.pl/pl/content/1-delivery">
                  <img class="img-responsive" src="/img/cms/wysylka.png" alt="WYSYŁKA" width="164" height="164" />
                </a>
                <div class="banner-top-title">Wysyłka</div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="https://wloczkiwarmii.pl/pl/content/">
                  <img class="img-responsive" src="/img/cms/platnosci.png" alt="PŁATNOŚCI" width="164" height="164" />
                </a>
                <div class="banner-top-title">Płatności</div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="https://wloczkiwarmii.pl/pl/content/">
                  <img class="img-responsive" src="/img/cms/rabat.png" alt="RABAT" width="164" height="164" />
                </a>
                <div class="banner-top-title">Rabat</div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="col banner-top-container">
                <a href="https://wloczkiwarmii.pl/pl/content/">
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
      <section id="content" class="page-home">
        {block name='page_content_top'}{/block}

        {block name='page_content'}
          {block name='hook_home'}
            {$HOOK_HOME nofilter}
          {/block}
        {/block}
      </section>
    {/block}
