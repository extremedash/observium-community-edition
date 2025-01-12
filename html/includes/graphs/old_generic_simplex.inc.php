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

// Draw generic bits graph
// args: ds_in, ds_out, rrd_filename, bg, legend, from, to, width, height, inverse, percentile

include($config['html_dir']."/includes/graphs/common.inc.php");

$unit_text = str_pad(truncate($unit_text,18,''),18);
$line_text = str_pad(truncate($line_text,12,''),12);

if ($multiplier)
{
  $rrd_options .= " DEF:".$ds."_o=".$rrd_filename_escape.":".$ds.":AVERAGE";
  $rrd_options .= " CDEF:".$ds."=".$ds."_o,$multiplier,*";
} else {
  $rrd_options .= " DEF:".$ds."=".$rrd_filename_escape.":".$ds.":AVERAGE";
}
if ($print_total)
{
  $rrd_options .= " VDEF:".$ds."_total=ds,TOTAL";
}

if ($percentile)
{
  $rrd_options .= " VDEF:".$ds."_percentile=".$ds.",".$percentile.",PERCENT";
}

if ($vars['previous'] == "yes")
{
  if ($multiplier)
  {
    $rrd_options .= " DEF:".$ds."_oX=".$rrd_filename_escape.":".$ds.":AVERAGE:start=".$prev_from.":end=".$from;
    $rrd_options .= " SHIFT:".$ds."_oX:$period";
    $rrd_options .= " CDEF:".$ds."X=".$ds."_oX,$multiplier,*";
  } else {
    $rrd_options .= " DEF:".$ds."X=".$rrd_filename_escape.":".$ds.":AVERAGE:start=".$prev_from.":end=".$from;
    $rrd_options .= " SHIFT:".$ds."X:$period";
  }
  if ($print_total)
  {
    $rrd_options .= " VDEF:".$ds."_totalX=ds,TOTAL";
  }
  if ($percentile)
  {
    $rrd_options .= " VDEF:".$ds."_percentileX=".$ds.",".$percentile.",PERCENT";
  }
#  if ($graph_max)
#  {
#    $rrd_options .= " AREA:".$ds."_max#".$colour_area_max.":";
#  }
}

$rrd_options .= " AREA:".$ds."#".$colour_area.":";

$rrd_options .= " COMMENT:'".$unit_text."Now       Avg      Max";

if ($percentile)
{
  $rrd_options .= "      ".$percentile."th %";
}

$rrd_options .= "\\n'";
$rrd_options .= " LINE1.25:".$ds."#".$colour_line.":'".$line_text."'";
$rrd_options .= " GPRINT:".$ds.":LAST:%6.2lf%s";
$rrd_options .= " GPRINT:".$ds.":AVERAGE:%6.2lf%s";
$rrd_options .= " GPRINT:".$ds.":MAX:%6.2lf%s";

if ($percentile)
{
  $rrd_options .= " GPRINT:".$ds."_percentile:%6.2lf%s";
}

$rrd_options .= "\\n";
$rrd_options .= " COMMENT:\\n";

if ($print_total)
{
  $rrd_options .= " GPRINT:".$ds."_tot:Total\ %6.2lf%s\)\\l";
}

if ($percentile)
{
  $rrd_options .= " LINE1:".$ds."_percentile#aa0000";
}

if($vars['previous'] == "yes")
{
  $rrd_options .= " LINE1.25:".$ds."X#666666:'Prev \\n'";
  $rrd_options .= " AREA:".$ds."X#99999966:";
}

// EOF
