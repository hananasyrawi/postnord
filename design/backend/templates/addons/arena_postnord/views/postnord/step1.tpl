
<div id="shipment_wizard">
    <h4 class="subheader">{__("order")}: {$order_id}{if $is_return=="Y"} - {__("rma_return")}: {$return_id}{/if} - Step 1</h4>
<form action="{"shippo.step2"|fn_url}" method="get" name="shippo_form" class="form-horizontal cm-ajax">
    <fieldset>
        <div class="control-group">
            <label class="control-label cm-required">{__("arena_shippo.parcel_weight")}</label>
            <div class="controls">
                <input type="number" name="parcel[weight]" step="0.001"  id="elm_package_weight" value="{$parcel.weight}" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label cm-required">{__("arena_shippo.parcel_height")}</label>
            <div class="controls">
                <input type="number" name="parcel[height]" id="elm_package_height" value="{$parcel.height}" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label cm-required">{__("arena_shippo.parcel_length")}</label>
            <div class="controls">
                <input type="number" name="parcel[length]" id="elm_package_length" value="{$parcel.length}" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label cm-required">{__("arena_shippo.parcel_width")}</label>
            <div class="controls">
                <input type="number" name="parcel[width]" id="elm_package_length" value="{$parcel.width}" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label cm-required">{__("arena_shippo.distance_unit")}</label>
            <div class="controls">
                <input type="text" name="parcel[distance_unit]" id="elm_distance_unit" value="{$parcel.distance_unit}" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label cm-required">{__("arena_shippo.mass_unit")}</label>
            <div class="controls">
                <input type="text" name="parcel[mass_unit]" id="elm_mass_unit" value="{$parcel.mass_unit}" />
            </div>
        </div>

    </fieldset>
    <div class="buttons-container">
        <input type="submit" class="btn btn-primary" name="dispatch[shippo.step2]" value="{__("next")}" />
        {include file="addons/arena_shippo/components/close_popup.tpl"}
    </div>
</form>
</div>
