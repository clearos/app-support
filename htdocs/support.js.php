<?php

/**
 * Javascript helper for Support.
 *
 * @category   apps
 * @package    support
 * @subpackage javascript
 * @author     ClearCenter <developer@clearcenter.com>
 * @copyright  2011 ClearCenter
 * @license    http://www.clearcenter.com/app_license ClearCenter license
 * @link       http://www.clearcenter.com/support/documentation/clearos/support/
 */

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('support');
clearos_load_language('base');


///////////////////////////////////////////////////////////////////////////////
// J A V A S C R I P T
///////////////////////////////////////////////////////////////////////////////

header('Content-Type: application/x-javascript');

?>
var lang_error = '<?php echo lang('base_error'); ?>';
var lang_warning = '<?php echo lang('base_warning'); ?>';

$(document).ready(function() {
   get_support_info();
});

/**
 * Returns support information from the SDN.
 *
 * @return JSON SDN information
 */

function get_support_info() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/app/support/get_support_info',
        data: 'ci_csrf_token=' + $.cookie('ci_csrf_token'),
        success: function(data) {
            if (data == undefined || data.code != 0) {
                clearos_dialog_box('data_err0', lang_error, data.errmsg, options);
                return;
            }
            console.log(data.links.knowledgebase);
            $('#support-knowledgebase').attr('href', data.links.knowledgebase);
        },
        error: function(xhr, text, err) {
            // Don't display any errors if ajax request was aborted due to page redirect/reload
            if (xhr['abort'] == undefined) {
                var options = new Object();
                options.type = 'warning';
                clearos_dialog_box('data_err1', lang_warning, xhr.responseText.toString(), options);
            }
        }
    });
}
<?php
// vim: syntax=javascript ts=4
?>
