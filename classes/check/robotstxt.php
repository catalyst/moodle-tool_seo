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

namespace tool_seo\check;

use core\check\check;
use core\check\result;

/**
 * Performance check that robots.txt is visible and working.
 *
 * @package   tool_seo
 * @author    Brendan Heywood (brendan@catalyst-au.net)
 * @copyright 2026 Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class robotstxt extends check {

    /**
     * Get the short check name.
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('check_robotstxt', 'tool_seo');
    }

    /**
     * Link to the robots.txt settings.
     *
     * @return \action_link|null
     */
    public function get_action_link(): ?\action_link {
        $url = new \moodle_url('/admin/settings.php', ['section' => 'tool_seo']);
        return new \action_link($url, get_string('pluginname', 'tool_seo'));
    }

    /**
     * Fetch robots.txt over HTTP and verify it is served correctly.
     *
     * @return result
     */
    public function get_result(): result {
        $url = (new \moodle_url('/robots.txt'))->out(false);

        $curl = new \curl(['ignoresecurity' => true]);
        $body = $curl->get($url, [], ['CURLOPT_TIMEOUT' => 10, 'CURLOPT_FOLLOWLOCATION' => 0]);
        $info = $curl->get_info();
        $code = (int) ($info['http_code'] ?? 0);
        $details = \html_writer::link($url, $url);

        if ($curl->get_errno() || !$code) {
            $summary = get_string('check_robotstxt_error', 'tool_seo', $curl->error);
            return new result(result::ERROR, $summary, $details);
        }
        if ($code !== 200) {
            $summary = get_string('check_robotstxt_badstatus', 'tool_seo', $code);
            return new result(result::ERROR, $summary, $details);
        }
        if (trim((string) $body) === '') {
            return new result(result::WARNING, get_string('check_robotstxt_empty', 'tool_seo'), $details);
        }
        $type = (string) ($info['content_type'] ?? '');
        if (stripos($type, 'text/plain') !== 0) {
            $summary = get_string('check_robotstxt_badtype', 'tool_seo', $type);
            return new result(result::WARNING, $summary, $details);
        }

        return new result(result::OK, get_string('check_robotstxt_ok', 'tool_seo'), $details);
    }
}
