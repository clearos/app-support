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
var lang_day = '<?php echo lang('base_day'); ?>';
var lang_days = '<?php echo lang('base_days'); ?>';
var lang_upgrade = '<?php echo lang('support_upgrade'); ?>';
var lang_upgrade_window = '<?php echo lang('support_upgrade_window'); ?>';
var lang_phone = '<?php echo lang('support_phone'); ?>';
var lang_email = '<?php echo lang('support_email'); ?>';
var lang_web = '<?php echo lang('support_web'); ?>';
var lang_not_available = '<?php echo lang('support_not_available'); ?>';
var lang_no_open_tickets = '<?php echo lang('support_no_open_tickets'); ?>';
var lang_please_open_ticket = '<?php echo lang('support_please_open_ticket'); ?>';
var lang_chat_not_available = '<?php echo lang('support_chat_not_available'); ?>';
var lang_contact_upgrades = '<?php echo addslashes(lang('support_contact_upgrades')); ?>';

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
            // Unregistered
            if (data.code != 0) {
                var options = new Object();
                options.type = 'warning';
                clearos_dialog_box('data_err0', lang_error, data.errmsg, options);
                $('#submit-ticket-container div.support-item, #realtime-chat-container div.support-item').append(
                    '<div class=\'support-banner support-not-available\'>' +
                    '<div class=\'support-title\'>' + lang_not_available + '</div>' +
                    '<div class=\'support-additional-info\'></div>' +
                    '</div>'
                );
                $('#support-ticket').hide();
                $('#support-chat').hide();
            } else if (data.code == 0) {
                if (data.edition != 'community') {
                    // Community Edition
                    if (data.upgrade_eligible) {
                        var options = new Object();
                        $('#message_container').html(clearos_infobox_info(lang_upgrade_window, data.upgrade_text +
                            '<div class=\'support-upgrade-days-remaining\'>' + data.days_remaining + ' ' +
                            (data.days_remaining > 1 ? lang_days : lang_day) + '</div>', options)
                        );
                        $('#submit-ticket-container div.support-item').append('<div class=\'support-banner support-upgrade-required\'>' + lang_upgrade + '</div>');
                        $('#support-ticket').hide();
                        $('#realtime-chat-container div.support-item').append('<div class=\'support-banner support-upgrade-required\'>' + lang_upgrade + '</div>');
                        $('#support-chat').hide();
                    } else {
                        $('#submit-ticket-container div.support-item, #realtime-chat-container div.support-item').append(
                            '<div class=\'support-banner support-not-available\'>' +
                            '<div class=\'support-title\'>' + lang_not_available + '</div>' +
                            '<div class=\'support-additional-info\'>Contact our <a href=\'#\' class=\'support-contact\'>upgrade team</a> for options.</div>' +
                            '</div>'
                        );
                    }
                } else if (data.edition == 'professional') {
                    if (!data.has_open_ticket) {
                        $('#realtime-chat-container div.support-item').append(
                            '<div class=\'support-banner support-no-open-tickets\'>' +
                            '<div class=\'support-title\'>' + lang_no_open_tickets + '</div>' +
                            '<div class=\'support-additional-info\'>' + lang_please_open_ticket + '</div>' +
                            '</div>'
                        );
                        $('#support-chat').hide();
                    } else if (!data.chat_not_available) {
                        $('#realtime-chat-container div.support-item').append(
                            '<div class=\'support-banner support-no-open-tickets\'>' +
                            '<div class=\'support-title\'>' + lang_not_available + '</div>' +
                            '<div class=\'support-additional-info\'>' + lang_chat_not_available + '</div>' +
                            '</div>'
                        );
                        $('#support-chat').hide();
                    }
                }
            }
            $('#support-knowledgebase').attr('href', data.links.knowledgebase);
            $('#support-documentation').attr('href', data.links.documentation);
            $('#support-ticket').attr('href', data.links.submit_ticket);
            $('#support-forums').attr('href', data.links.forums);
            $('#support-bug-report').attr('href', data.links.bug_report);
            $('#support-chat').attr('href', data.links.chat);
            $('.support-contact').on('click', function(e) {
                e.preventDefault();
                clearos_dialog_box('support-contact', data.support_contact_title,
                '<div class=\'col-md-2\'>' + lang_phone + ':</div><div class=\'col-md-10\'>' + data.sales_phone + '</div>' +
                '<div class=\'col-md-2\'>' + lang_email + ':</div><div class=\'col-md-10\'>' + data.sales_email + '</div>' +
                '<div class=\'col-md-2\'>' + lang_web + ':</div><div class=\'col-md-10\'><a href=\'' + data.sales_web + '\' target=\'_blank\'>' + data.sales_web + '</a></div>' +
                '<div class=\'clearfix\'></div>'
                );
            });
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
