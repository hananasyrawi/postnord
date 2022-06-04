
{include file="common/subheader.tpl" title=__("arena_postnord.warehouse") target="#acc_addon_postnord_warehouse"}

<div id="acc_addon_postnord_warehouse" class="collapsed in">
    <div class="control-group">
        <label class="control-label" for="elm_postnord_status">{__("status")}:</label>
        <div class="controls">
            <select id="elm_postnord_status" name="company_data[postnord_status]"
                    value="{$company_data.postnord_status}" class="input-small">
                <option value="A"
                        {if $company_data.postnord_status=='A'}selected="selected"{/if}>{__("active")}</option>
                <option value="D"
                        {if $company_data.postnord_status=='D'}selected="selected"{/if}>{__("disabled")}</option>
            </select>
        </div>
    </div>

    <p>{__("arena_postnord.company_information_text")}</p>
    <div class="control-group">
        <label class="control-label cm-regexp"
               {literal}data-ca-regexp="^[0-9]{10}$"{/literal}
               data-ca-message="Must be 10 digits long"
               data-ca-regexp-allow-empty="true"
               for="elm_postnord_phone"
        >{__("arena_postnord.phone_number")}:</label>
        <div class="controls">
            <input type="text" id="elm_postnord_phone" name="company_data[postnord_phone]"
                   value="{$company_data.postnord_phone}" class="input-large"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label cm-regexp cm-str-len"
               {literal}data-ca-regexp="\w*([0-9]+)\w*"{/literal}
               data-ca-message="Must contain a number (Street, Floor, Apt No)"
               data-ca-regexp-allow-empty="true"
               for="elm_postnord_address">{__("arena_postnord.address")}:</label>
        <div class="controls">
            <input type="text" id="elm_postnord_address"
                   name="company_data[postnord_address]"
                   data-max-str-len="80"
                   data-min-str-len="0"
                   data-min-max-message="Address length can be up to 80 chars"
                   value="{$company_data.postnord_address}"
                   class="input-large"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="elm_postnord_city">{__("arena_postnord.city")}:</label>
        <div class="controls">
            <input type="text" id="elm_postnord_city" name="company_data[postnord_city]"
                   value="{$company_data.city}" class="input-large"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="elm_postnord_state">{__("arena_postnord.state")}:</label>
        <div class="controls">
            <input type="text" id="elm_postnord_state" name="company_data[postnord_state]"
                   value="{$company_data.postnord_state}" class="input-large"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="elm_postnord_country">{__("arena_postnord.country")}:</label>
        <div class="controls">
            <input type="text" id="elm_postnord_country" name="company_data[postnord_country]"
                   value="{$company_data.postnord_country}" class="input-large"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label cm-regexp"
               {literal}data-ca-regexp="[0-9]{4}"{/literal}
               data-ca-message="Pincode can be 6 digits"
               data-ca-regexp-allow-empty="true"
               for="elm_postnord_pincode">{__("arena_postnord.postal_code")}:</label>
        <div class="controls">
            <input type="text" id="elm_postnord_pincode" name="company_data[postnord_postal_code]"
                   value="{$company_data.postnord_pincode}" class="input-large"/>
        </div>
    </div>
</div>


<script>
    (function (_, $) {
        $.ceFormValidator('registerValidator', {
            class_name: 'cm-str-len',
            message: '',
            func: function (id) {
                let chkFld = $('#' + id);
                this.message = chkFld.data("min-max-message");
                let txt = chkFld.val().trim();
                let min = chkFld.data('min-str-len');
                let max = chkFld.data('max-str-len');
                return (min <= txt.length && txt.length <= max);
            }
        });
    }(Tygh, Tygh.$));
</script>
