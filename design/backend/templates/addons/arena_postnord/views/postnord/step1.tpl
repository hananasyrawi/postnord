
<div id="shipment_wizard">
<h4 class="subheader">- Book Shipment </h4>
<form action="{"postnord.step2"|fn_url}" method="get" name="postnord_form" class="form-horizontal cm-ajax">
    <input type="hidden" name="order_id"   value="{$order_id}" />
    <input type="hidden" name="mode"       value="{$mode}" />
    <input type="hidden" name="result_ids" value="shipment_wizard" />
    <input type="hidden" name="skip_result_ids_check" value="true" />
     <fieldset>
        <div class="form-group">
            <label class="control-label col-sm-2">{"Shipment Method "}: </label>
            <div class="col-sm-10">
                <select name="postnord_method" class="form-control">
                    <option value="edi">Return EDI</option>
                    <option value="edi_with_label">EDI With Labels PDF</option>
                    <option value="pickups">Pickups</option>
                </select>
            </div>
        <div>
     </fieldset>
    <div class="buttons-container">
        <input type="submit" class="btn btn-primary" name="dispatch[postnord.step2]" value="{__("next")}" />
        {include file="addons/arena_shippo/components/close_popup.tpl"}
    </div>
</form>
</div>
