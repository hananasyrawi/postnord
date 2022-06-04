<div id="shipment_wizard">
<h4 class="subheader">{__("order")}: {$order_id}{if $is_return=="Y"} - {__("rma_return")}: {$return_id}{/if} - Step 2</h4>
<form action="{""|fn_url}" method="post" name="shippo_form" class="form-horizontal form-edit">
    <input type="hidden" name="order_id" value="{$order_id}" />
    <input type="hidden" name="mode" value="{$mode}" />
    <input type="hidden" name="is_return" value="{$is_return}" />
    <input type="hidden" name="return_id" value="{$return_id}" />
    <input type="hidden" name="addressFrom" value="{$addressFrom|json_encode}" />
    <input type="hidden" name="addressTo" value="{$addressTo|json_encode}" />
    <input type="hidden" name="parcels" value="{$parcels|json_encode}" />

    {foreach from=$package item="v" key="k"}
        <input type="hidden" name="package[{$k}]" value="{$v}" />
    {/foreach}
    <div id="shipment_wizard">
    {if $couries}
        <fieldset>
            <div class="control-group">
                <div class="select-field">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{__("arena_shippo.choice")}</th>
                            <th>{__("Provider")}</th>
                            <th>{__("arena_shippo.service_level  ")}</th>
                            <th>{__("arena_shippo.deliver")}</th>
                            <th>{__("Amount")}</th>
                            <th>{__("Currency")}</th>
                            <th>{__("Image")}</th>
                        </tr>
                        </thead>
                        {foreach from=$couries item="courier"}
                            <tr>
                                <td style="padding: 4px;">
                                    <input type="radio" value="{$courier|json_encode}" name="shippo_provider" id="courier-{$courier->object_id}"
                                           {if count($couriers)==1}checked="checked"{/if}
                                    />
                                </td>
                                <td><input type="hidden" name="provider[name]" value="{$courier->object_id}" /></td>
                                <td>{$courier->provider}</td>
                                <td>{$courier->servicelevel->name}</td>
                                <td>{$courier->days} Days</td>
                                <td>{$courier->amount}</td>
                                <td>{$courier->currency_local}</td>
                                <td>
                                  <img width=20 height=20 src="{$courier->provider_image_200}" />
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </div>
            </div>
        </fieldset>
        <div class="buttons-container">
            <input type="submit" class="btn btn-primary" name="dispatch[shippo.generate]" value="{__("create")}" />
            {include file="addons/arena_shippo/components/close_popup.tpl"}
        </div>
    {else}
        <p class="no-items">{__("arena_shippo.no_couriers_found")}</p>

        <div class="buttons-container">
            {include file="addons/arena_shippo/components/close_popup.tpl"}
        </div>
    {/if}
    </div>
</form>
<!--shipment_wizard--></div>
