{*
 * 2007-2020 PrestaShop.
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
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

<div class="footer_block links">
  <div class="ft_newsletter">
    <div class="content_newsletter">
      <h3>{l s='Newsletter' d='Modules.Emailsubscription.Shop'}</h3>
    </div>
    <div class="block_content">
      {hook h='displayGDPRConsent' id_module=$id_module}
      {hook h='displayNewsletterRegistration'}
      {if $conditions}
        <p class="newletter-header">{$conditions}</p>
      {/if}
      <form action="{$urls.current_url}#footer" method="post">
        <div class="input-wrapper">
          <input class="input_txt" type="email" name="email" value="{$value}" placeholder="{l s='Your e-mail' d='Modules.Emailsubscription.Shop'}" required />
          <input type="hidden" value="{$hookName}" name="blockHookName" />
          <input type="hidden" name="action" value="0" />
          <div class="clearfix"></div>
        </div>

        <button class="btn btn-primary" type="submit" value="ok" name="submitNewsletter">
          <span>Zapisz się</span>
        </button>
      </form>
      <div class="col-xs-12">
        {if $msg}
          <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">{$msg}</p>
        {/if}
      </div>
    </div>
  </div>
</div>
