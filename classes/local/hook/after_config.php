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

namespace tool_seo\local\hook;

/**
 * Hook for after_config
 *
 * @package   tool_seo
 * @author    Matthew Hilton <matthewhilton@catalyst-au.net>
 * @copyright 2025 Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class after_config {
    /**
     * Callback called after_config
     * @param \core\hook\after_config $hook hook data (unused)
     */
    public static function callback(\core\hook\after_config $hook): void {
        \tool_seo\robots::serve();
    }
}
