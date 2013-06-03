/*jslint browser: true */
/*global */

var cm_company_email = {

    cb_inc_company_details: null,

    load: function() {
        var enabled;
        this.options_form = document.getElementById('')
        this.cb_inc_company_details = document.getElementById('inc_company_info');
        enabled = this.cb_inc_company_details.checked;

        if (!enabled) {
            document.getElementByClassName('')
        }
    },
};

cm_company_email.load();