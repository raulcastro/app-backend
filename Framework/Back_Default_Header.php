<?php 
/**
 * This file the one that controls the sessions on the application
 *
 * @package    Blog Control
 * @subpackage My Perfect Wedding
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <raul@crc-software.com>
 */

date_default_timezone_set('America/Bogota');

$root = $_SERVER['DOCUMENT_ROOT'];
require_once ($root . '/Framework/Connection_Data.php');
require_once ($root . '/Framework/Mysqli_Tool.php');


