{**
* 2012-2014 PAYMILL
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author    PAYMILL <support@paymill.com>
*  @copyright 2012-2014 PAYMILL
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

{if $prefilledFormData.last4 == '' || $prefilledFormData.expire_date == ''}
    <script lang="text/javascript">
        paymillcheckout.iframe.create = true;
    </script>
{else}
    <table id="paymill_fast_checkout_table">
        <tr>
            <td>{l s='Credit Card Number' mod='pigmbhpaymill'}: </td>
            <td>
                {if $prefilledFormData.last4}************{$prefilledFormData.last4}{/if}
                <img src="{$modul_base|escape:'html':'UTF-8'}img/32x20_{$prefilledFormData.card_type}.png" alt="{$prefilledFormData.card_type}">
            </td>
        </tr>
        <tr>
            <td>{l s='CVC' mod='pigmbhpaymill'}: </td>
            <td>***</td>
        </tr>
        <tr>
            <td>{l s='Credit Card Holder' mod='pigmbhpaymill'}: </td>
            <td>{$prefilledFormData.card_holder}</td>
        </tr>
        <tr>
            <td>{l s='Valid until (MM/YYYY)' mod='pigmbhpaymill'}: </td>
            <td>{$prefilledFormData.expire_date}</td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button id="paymill_fast_checkout_iframe_change" class="btn btn-default button-small" type="button">{l s='Change' mod='pigmbhpaymill'}</button>
            </td>
        </tr>
    </table>
{/if}
