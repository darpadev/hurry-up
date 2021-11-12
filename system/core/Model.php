<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {
	const MAX_LIMIT_SIZE = 100000;
	const DEFAULT_LIMIT_SIZE = 200;
	const MIN_LIMIT_SIZE = 1;

	// approval status
	const SUBMITTED = 1;
	const APPROVED = 2;
	const REJECTED = 3;
	const WAITING_FOR_APPROVAL = 4;
	const CANCELLED = 5;
	const REPORTED = 6;
	const VERIFICATION = 7;
	const DRAFT = 8;
	const PUBLISHED = 9;

	// period
	const END_YEAR = 1;
	const MID_YEAR = 2;

	// roles
	const ADMINISTRATOR = 1;
	const HRD = 2;
	const EMPLOYEE = 3;

	// week of day
	const WEEKEND = 1;
	const WEEKDAY = 2;

	// user group
	const TENDIK = 1;
	const LECTURE = 2;
	const FREELANCE = 3;

	// employee status
	const ACTIVE = 1;
	const RESIGN = 2;
	const UNPAID = 3;
	const STUDY_ASSIGNMENT = 4;

	// presence type
	const WFO = 1;
	const WFH = 2;

	// presence status
	const OK = 1;
	const LATE = 2;
	const ATTENDANCE_LESS = 3;
	const LEAVE = 4;
	const BUSINESS_TRIP = 5;
	const OTHER = 6;

	// org type
	const STRUCTURAL = 1;
	const FUNCTIONAL = 2;

	// overtime type
	const REQUEST = 1;
	const REPORT = 2;
	
	/**
	 * Class constructor
	 *
	 * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
	 * @return	void
	 */
	public function __construct() {}

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

}
