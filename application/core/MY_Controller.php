<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
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
	const CONTRACT = 2;
	const RESIGN = 3;

	// employee active status
	const AS_ACTIVE = 1;
	const AS_UNPAID = 2;
	const AS_STUDY_ASSIGNMENT = 3;

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

	public function __construct()
	{
		parent::__construct();
		$this->authorization->guard();
	}
}
