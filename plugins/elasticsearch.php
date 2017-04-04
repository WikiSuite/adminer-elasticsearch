<?php

/**
 * Adminer Elasticsearch plugin for ClearOS.
 *
 * @category   apps
 * @package    elasticsearch
 * @subpackage scripts
 * @author     eGloo
 * @copyright  2017 WikiSuite
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('base');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

// Classes
//--------

use \clearos\apps\base\Authorization as Authorization;
use \clearos\apps\base\Posix_User as Posix_User;
use \clearos\apps\groups\Group_Factory as Group_Factory;

clearos_load_library('base/Authorization');
clearos_load_library('base/Posix_User');
clearos_load_library('groups/Group_Factory');

// Exceptions
//-----------

use \Exception as Exception;

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Adminer Elasticsearch plugin for ClearOS.
 *
 * @category   apps
 * @package    elasticsearch
 * @subpackage scripts
 * @author     eGloo
 * @copyright  2017 WikiSuite
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 */

class AdminerElasticsearch {
	var $servers;
	
	function __construct() {
		$this->servers = [ '127.0.0.1:9200' ];
	}
	
	function login($login, $password)
    {
        // Validation
        //-----------

        try {
            $posix = new Posix_User();
            $valid_user = $posix->validate_username($login);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if (empty($login) || !empty($valid_user))
            return FALSE;

        // Authentication
        //---------------

        try {
            $authorization = new Authorization();
            $authenticated = $authorization->authenticate($login, $password);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if (!$authenticated)
            return FALSE;

        // Authorization
        //--------------

        if ($login === 'root')
            return TRUE;

        try {
            $group = Group_Factory::create('elasticsearch_plugin');
            $members = $group->get_members();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if (in_array($login, $members))
            return TRUE;
        else
            return 'Not authorized';
	}

	function loginForm()
    {
        ?>
            <table cellspacing="0">
                <tr>
                    <th><?php echo lang('Server'); ?></th>
                    <td>
                        <input type="hidden" name="auth[driver]" value="elastic">
                        <input type="hidden" name="auth[server]" value="127.0.0.1:9200">
                        <input name="server" value="Elasticsearch" readonly disabled>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('Username'); ?></th>
                    <td><input id="username" name="auth[username]" value="<?php echo h($_GET["username"]);  ?>"></td>
                </tr>
                <tr>
                    <th><?php echo lang('Password'); ?></th>
                    <td><input type="password" name="auth[password]"></td>
                </tr>
            </table>
            <p><input type="submit" value="<?php echo lang('Login'); ?>">
        <?php

		return TRUE;
	}
}
