/**
 * Main custom image function start.

 * @package WOOCP
 */

jQuery(document).ready(function($){
    "use strict";
    var cust_fld_tr = $('div.hide_div').closest('tr');
     $(document).on('change' , $("#ka_font_family_field") , change_meta_fields );

      function change_meta_fields() {
        var type = $('#ka_font_family_field').children("option:selected").val();
        if( type === 'custom_font'){
          cust_fld_tr.show();
        } else {
            cust_fld_tr.hide();
        }
      }

      var ka_sel_fld = $("#ka_font_family_field option:selected").val();
    if (ka_sel_fld == 'custom_font') {
      cust_fld_tr.show();
    } else {
        cust_fld_tr.hide();
    }

});

function ka_hide_fld(val) {

  "use strict";
  var cust_fld_tr = $('div.hide_div').closest('tr');
  if (val === 'custom_font' ) {
    cust_fld_tr.show();
  } else {
    cust_fld_tr.hide();
  }
}