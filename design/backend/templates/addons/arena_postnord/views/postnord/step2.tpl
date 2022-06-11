<div id="shipment_wizard">
<h4 class="subheader">Postnord</h4>
<form action="{""|fn_url}" method="post" name="postnord_form" class="form-horizontal form-edit">
    {if $postnord_method === 'edi'}
        <fieldset>
            <div class="control-group">
                <div class="select-field">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{"Booking Id"}</th>
                            <th>{"References"}</th>
                            <th>{"Shipment"}</th>
                            <th>{"returnId"}</th>
                            <th>{"itemId"}</th>
                            <th>{"urls"}</th>
                            <th>{"Label"}</th>
                        </tr>
                        </thead>
                        <tbody>
                          <tr>
                             <td>{$postnord.bookingId}</td>
                             <td>{$postnord.references}</td>
                             <td>{$postnord.shipment}</td>
                             <td>{$postnord.returnId}</td>
                             <td>{$postnord.itemId}</td>
                             <td>
                               <a href="{$postnord.urls->url}">Track</a>
                             </td>

                             <td>
                               <img src="{$postnord.labelPrintout}" /> 
                             </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    {/if}
    <div class="buttons-container">
        {include file="addons/arena_shippo/components/close_popup.tpl"}
    </div>
</form>
<!--shipment_wizard--></div>
