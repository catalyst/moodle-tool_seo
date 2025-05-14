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

namespace tool_seo;

use tool_seo\local\seo;

/**
 * Test case class for the noindex tool.
 *
 * @package    tool_seo
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2019 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class noindex_test extends \advanced_testcase {

    /**
     * Sets up test.
     */
    protected function setUp(): void {
        parent::setUp();
        // Set up non-indexable array in config.
        set_config('nonindexable', "
                /login/index.php\n
                /course/view.php\n
                user\n
                test.php\n
                https://www.sitename.com/assignment/grade.php
                ", 'tool_seo');
    }

    /**
     * Test non-indexable URLs have been added to the admin tool setting.
     *
     * @dataProvider get_noindex_url_testcases
     * @param string $url A URL path representing a moodle page url.
     * @param bool $expected True if the URL should be indexable.
     * @covers \tool_seo\local\seo::is_url_indexable
     */
    public function test_nonindexable_url_configuration($url, $expected): void {
        $this->resetAfterTest(true);
        $result = seo::is_url_indexable($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test checks if the config value is empty.
     *
     * @dataProvider get_noindex_url_testcases
     * @param string $url A URL path representing a moodle page url.
     * @param bool $expected True if the URL should be indexable.
     * @covers \tool_seo\local\seo::is_url_indexable
     */
    public function test_empty_configuration($url, $expected): void {
        $this->resetAfterTest(true);
        set_config('nonindexable', "", 'tool_seo');
        $result = seo::is_url_indexable($url);
        $this->assertTrue($result);
    }

    /**
     * Provider for Moodle page URL paths. Expected true if the URL should be indexable.
     *
     * @return array
     */
    public static function get_noindex_url_testcases(): array {
        return [
            // Exact matches.
            'Login URL' => ['/login/index.php', false],
            'Course URL' => ['/course/view.php', false],
            'Fake URL' => ['/fake/view.php', true],
            'Test URL' => ['/test/view.php', true],
            'Root URL' => ['/', true],

            // Partial matches.
            'User URL' => ['/user/view.php', false],
            'A PHP page type' => ['/login/test.php', false],
            'Full URL' => ['http://localhost/user/index.php?id=2', false],
            'slug-only URL' => ['/assignment/grade.php', false],
        ];
    }
}
