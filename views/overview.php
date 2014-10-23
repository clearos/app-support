<?php

/**
 * Support manager view.
 *
 * @category   apps
 * @package    support
 * @subpackage views
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2011 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/support/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.  
//  
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('base');

$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-knowledgebase'))
);

$options = array(
    'class' => 'text-right'
);

echo row_open();
echo column_open(4);
echo box_open(lang('support_knowledge_base'), array('class' => 'support-knowledgebase'));
echo box_content(image('gateway.svg', array('class' => 'support-item')));
$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-knowledgebase', 'target' => '_blank'))
);
echo box_footer('knowledge_base', button_set($buttons), $options);
echo box_close();
echo column_close();
echo column_open(4);
echo box_open(lang('support_submit_ticket'), array('class' => 'support-ticket'));
echo box_content(image('gateway.svg', array('class' => 'support-item')));
$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-ticket', 'target' => '_blank'))
);
echo box_footer('knowledge_base', button_set($buttons), $options);
echo box_close();
echo column_close();
echo column_open(4);
echo box_open(lang('support_realtime_chat'), array('class' => 'support-chat'));
echo box_content(image('gateway.svg', array('class' => 'support-item')));
$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-chat', 'target' => '_blank'))
);
echo box_footer('knowledge_base', button_set($buttons), $options);
echo box_close();
echo column_close();
echo row_close();

echo row_open();
echo column_open(4);
echo box_open(lang('support_documentation'), array('class' => 'support-documentation'));
echo box_content(image('gateway.svg', array('class' => 'support-item')));
$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-documentation', 'target' => '_blank'))
);
echo box_footer('knowledge_base', button_set($buttons), $options);
echo box_close();
echo column_close();
echo column_open(4);
echo box_open(lang('support_community_forums'), array('class' => 'support-forums'));
echo box_content(image('gateway.svg', array('class' => 'support-item')));
$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-forums', 'target' => '_blank'))
);
echo box_footer('knowledge_base', button_set($buttons), $options);
echo box_close();
echo column_close();
echo column_open(4);
echo box_open(lang('support_submit_bug_report'), array('class' => 'support-bug-report'));
echo box_content(image('gateway.svg', array('class' => 'support-item')));
$buttons = array(
    anchor_custom('#', lang('base_go'), 'high', array('id' => 'support-bug-report', 'target' => '_blank'))
);
echo box_footer('knowledge_base', button_set($buttons), $options);
echo box_close();
echo column_close();
echo row_close();
