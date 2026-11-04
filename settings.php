<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin settings for tool
 *
 * @package    tool_seo
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2019 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $settings = new admin_settingpage('tool_seo', get_string('pluginname', 'tool_seo'));

    $ADMIN->add('tools', $settings);
    if (!during_initial_install()) {

        // List of URLs that won't be profiled ever.
        $settings->add(new admin_setting_configtextarea('tool_seo/nonindexable',
            new lang_string('nonindexable', 'tool_seo'),
            new lang_string('nonindexable_help', 'tool_seo'),
            ''));

        // List of URLs that won't be profiled ever.
        $settings->add(new admin_setting_configtextarea('tool_seo/robotstxt',
            new lang_string('robotstxt', 'tool_seo'),
            new lang_string('robotstxt_help', 'tool_seo', (new moodle_url('/robots.txt'))->out()),
            ''));
    }
}


