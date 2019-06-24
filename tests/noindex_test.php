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
 * Test case for the noindex tool.
 *
 * @package    tool_seo
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2019 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../locallib.php');

/**
 * Test case class for the noindex tool.
 *
 * @package    tool_seo
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2019 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class noindex_testcase extends advanced_testcase {

    /**
     * Test when no exceptions have been added to the admin tool setting.
     *
     * @dataProvider get_noindex_url_testcases
     * @param string A URL path representing a moodle page url.
     */
    public function test_no_exceptions($url) {
        $this->resetAfterTest(true);

        // Set up empty exception array in config.
        global $CFG;
        $CFG->forced_plugin_settings['tool_seo']['noindexexcluded'] = '';

        $result = tool_seo_is_url_excluded($url);

        $this->assertFalse($result);
    }

    /**
     * Provider for Moodle page URL paths.
     *
     * @return array
     */
    public function get_noindex_url_testcases() {
        return [
            ['Login view is loaded.' => '/login/index.php'],
            ['Course view is loaded.' => '/course/view.php'],
        ];
    }
}
