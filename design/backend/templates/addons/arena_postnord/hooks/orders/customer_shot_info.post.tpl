{** if shipments has booked get information **}
{if $order_info.shipment_ids}
    {foreach from=$shippo_shipment_data item="shipment"}
        {if $shipment.carrier=='postnord'}
            <div class="well orders-right-pane form-horizontal">
                <div class="control-group">
                    <div class="control-label">{__("arena_postnord.shipment_date")}</div>
                    <div id="tygh_payment_info" class="controls">
                        {$shipment.timestamp|date_format:"`$settings.Appearance.date_format`"},{$shipment.timestamp|date_format:"`$settings.Appearance.time_format`"}
                    </div>
                </div>
                {if $shipment.order_data}
                    {foreach from=$shipment.order_data item="v" key="k"}
                        <div class="control-group">
                            <div class="control-label">{__("arena_postnord.`$k`")}</div>
                            <div id="tygh_payment_info" class="controls">
                                {if is_bool($v)}
                                    {if $v}{__("yes")}{else}{__("no")}{/if}
                                {elseif $k=='label_url' || $k=='manifest_url'}
                                    {if $v}<a href="{$v}" target="_blank">Download</a>{else}-{/if}

                                {elseif $k=='tracking_url_provider' || $k=='manifest_url'}
                                    {if $v}<a href="{$v}" target="_blank">{$v}</a>{else}-{/if}

                                {elseif $k=='cod'}
                                    {if $v==1}{__("yes")}{/if}
                                {elseif $k == 'labelPrintout'}
                                   {if !fn_arena_postnord_contains_some_image($v) }
                                      <form action="{"postnord.generate_pdf"|fn_url}"  id="generate_pdf_form" method="post"> 
                                        <input type="hidden" name="label_base64" value="{$v}">
                                      </form>
                                      <input type="submit" data-ca-target-form="generate_pdf_form" class="btn btn-primary" name="dispatch[postnord.generate_pdf]" value="{__("arena_postnord.labelPrintout")}" />
                                    {/if}
                                   {if fn_arena_postnord_contains_some_image($v) }
                                      <img src="{$v}" /> 
                                   {/if}
                                {elseif $k == 'urls'}
                                    <a href="{$v.url}" target="_blank">Tracking Url</a>
                                {else}
                                    {$v}
                                {/if}
                            </div>
                        </div>
                    {/foreach}
                {else}
                    Get It
                {/if}
            </div>
        {/if}
    {/foreach}
{else}
    <div class="well orders-right-pane form-horizontal">
        {include file="common/subheader.tpl" title=__("arena_postnord.create_awb")}
        <div style="margin-top:15px;text-align: center;">
        <a class="btn cm-dialog-opener cm-ajax"
           href="{"postnord.step1?order_id=`$order_info.order_id`&mode=step1"|fn_url}"
           data-ca-dialog-title="Postnord"
        >{__("arena_postnord.generate_pre")}</a>
        </div>
    </div>
{/if}

