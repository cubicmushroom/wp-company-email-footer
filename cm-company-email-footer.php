<?php
/*
 Plugin Name: CM Company Email Footer
 Plugin URI: http://cibicmushroom.co.uk
 Description: Adds company details to the footer of all site emails
 Author: Cubic Mushroom Ltd.
 Version: 0.1
 Author URI: http://cubicmushroom.co.uk
 */

namespace CubicMushroom\WordPress\Plugin;

define('CM_COMPANY_FOOTER', __FILE__);

require('vendor/autoload.php');

$CMCompanyEmailFooter = CompanyEmailFooter::load();