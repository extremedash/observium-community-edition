<?php

/**
 * Observium
 *
 *   This file is part of Observium.
 *
 * @package    observium
 * @subpackage graphs
 * @copyright  (C) 2006-2013 Adam Armstrong, (C) 2013-2019 Observium Limited
 *
 */

$scale_min = "0";

$rrd_filename = get_rrd_path($device, "bng-active-sessions.rrd");

include_once($config['html_dir']."/includes/graphs/common.inc.php");

$rrd_options .= " DEF:value=".$rrd_filename_escape.":value:AVERAGE";
$rrd_options .= " 'COMMENT:Sessions   Current  Minimum  Maximum  Average\\l'";
$rrd_options .= " AREA:value#EEEEEE:'Subscribers   '";
$rrd_options .= " LINE1.25:value#36393D:";
$rrd_options .= " GPRINT:value:LAST:%6.2lf  GPRINT:value:MIN:%7.2lf";
$rrd_options .= " GPRINT:value:MAX:%7.2lf  'GPRINT:value:AVERAGE:%7.2lf\\l'";

// EOF
