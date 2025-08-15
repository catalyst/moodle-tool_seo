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

namespace tool_seo\local;

use dml_exception;

/**
 * SEO utils class.
 *
 * @package    tool_seo
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2019 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class seo {
    /**
     * Checks whether the current URL is listed in the URLs to not be indexed in admin tools.
     *
     * @param string $currentpath The path component of the current URL to compare against.
     * @return bool Returns true if the URL should be indexable by search engines.
     */
    public static function is_url_indexable($currentpath): bool {

        // Get the list of URLs to be excluded from the admin settings.
        try {
            $nonindexableurlstring = get_config('tool_seo', 'nonindexable');
        } catch (dml_exception $e) {
            return true;
        }

        $nonindexableurls = array_map('trim', explode(PHP_EOL, $nonindexableurlstring));

        $currentpathliteral = preg_quote($currentpath, '/');

        foreach ($nonindexableurls as $nonindexableurl) {
            // If the url is empty, ignore.
            if ($nonindexableurl == '') {
                continue;
            }

            // Checks if a non-indexable url is part of the current path.
            if (strpos($currentpath, $nonindexableurl) !== false) {
                return false;
            }

            // Checks if the current path is a slug of the non-indexable url.
            if (preg_match("/^.*$currentpathliteral$/", $nonindexableurl)) {
                return false;
            }
        }

        return true;
    }
}
