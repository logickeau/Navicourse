<?php
 /**
   * @package     Navicourse
   * @uses NV_Mgrs, NV_Tsp
   * @description This class is the generator class for all HTML output for the navicourse plugin.
   * @author      Jean N. Pijeau <nick.pijeau@gmail.com>
   */ 
class NV_Generator
{
    /**
     * @name buildCourseForm()
     * @param $pointsFile - The file containing the uploaded point from the user.
     * @return HTML containting the initial course form.
     */
    public function buildCourseForm($pointsFile = null)
    {
        $numPoints = ($pointsFile != null)? count($pointsFile):"";
        $courseForm = '';
        //Course Form begins
        $courseForm .= '<form id="form1" action="" method="post" enctype="multipart/form-data">';
            $courseForm .= '<fieldset><legend>Course Info</legend>';
            $courseForm .= '<table>
                             <tr>';
                $courseForm .= '<td style="text-align:center" colspan="3">Load points from file: 
                                    <input type="file" name="file" id="file" /> <span>[<a onclick="window.open(\'example.html\',\'Point Example\',
                                    \'height=380, width=300,scrollbars=no\')" >Example File Format</a>]</span>
                                </td>';
            $courseForm .=  '</tr>
                            </table>';
            $courseForm .= '<table cellpadding="5" cellspacing="5">';
                $courseForm .= '<tr id="labels">';
                    $courseForm .= '<th>Number of Points</th>';
                    $courseForm .= '<th>Points Per Lane</th>';
                    $courseForm .= '<th>Number of Lanes</th>';
                    $courseForm .= '<th>Grid Zone Designation</th>';
                    $courseForm .= '<th>Min. Dist. between points</th>';
                    $courseForm .= '<th>Max. Dist. between points</th>';
                $courseForm .= '</tr>';
                $courseForm .= '<tr class="inputs">';
                    $courseForm .= '<td><input required min="5" max="100" type="number" name="numPoints" value="' . $numPoints . '" id="numPoints"/></td>';
                    $courseForm .= '<td><input required min="5" max="10" type="number" name="points_per_lane" id="points_per_lane" value="' . $_POST["points_per_lane"] . '" /></td>';
                    $courseForm .= '<td><input required min="1" max="500" type="number" name="number_slips" id="number_slips" value="' . $_POST["number_slips"] . '" /></td>';
                    $courseForm .= '<td><input required maxlength="3" size="3" type="text" name="grid_ref"  id="grid_ref" value="' . $_POST["grid_ref"]. '" /><span style="padding-left:3px;">[Ex: 17R]</span></td>';
                    $courseForm .= '<td><input maxlength="4" size="4" type="text" name="minDist" id="minDist" value="' . $_POST["minDist"] . '" /><span style="padding-left:3px;">[Meters]</span></td>';
                    $courseForm .= '<td><input maxlength="4" size="4" type="text" name="maxDist" id="maxDist" value="' . $_POST["maxDist"] . '" /><span style="padding-left:3px;">[Meters]</span></td>';
                $courseForm .= '</tr>';
            $courseForm .= '</table>';
        $courseForm .= '</fieldset>';
            $courseForm .= '<div style="width: 100%;text-align: center;margin-top:20px">';
                $courseForm .= '<input name="task" value="coursepoints" class="button" type="hidden" />';
                $courseForm .= '<input name="submit" value="Submit" class="button" type="submit" />';
            $courseForm .= '</div>';
        $courseForm .= '</form>';
        //Couse from ends.
        
        //Output the form to the browser.
        return $courseForm;
    }
    
    /**
     * @name  buildPointsForm()
     * @param $pointsFile - $pointsFile - The file containing the uploaded point from the user.
     * @return HTML containting all the course points and marker inputs.
     */
    public function buildPointsForm($pointsFile = null)
    {
        $pointsForm = '';
        //Points form begins
        $pointsForm .= '<div id="ex"><div>[EXAMPLE : MM81726291 (NO SPACES)]</div>
                        <div><i>At this time the only supported grid system is <b>MGRS</b></i></div></div>';
        $pointsForm .= '<form id="points" action="" method="post">';
            $pointsForm .= '<fieldset><legend>Points</legend>';
                $pointsForm .= '<table>';
                    if (!empty($pointsFile)) //No file uplaoaded
                    {
                        $numPoints = count($pointsFile);
                        
                        for ($i = 0; $i < $numPoints; $i++)
                        {
                            $pointWname[$i] = explode(" ", $pointsFile[$i]);
                            $pointNum = $i+1;
                            $pointsForm .= '<tr">';
                                $pointsForm .= '<td>Point ' . $pointNum . ':</td>';
                                $pointsForm .= '<td><input maxlength="12" type="text" value ="'. $pointWname[$i][1].'" name="point['.$pointNum.']" id="point['. $pointNum. ']" /></td>';
                                $pointsForm .= '<td>Marker ' . $pointNum. ':</td>';
                                $pointsForm .= '<td><input maxlength="2" type="text" value ="' . $pointWname[$i][0] . '" name="pointTitle[' . $pointNum . ']" id="pointTitle[' . $pointNum . ']" /></td>';
                            $pointsForm .= '</tr>';
                        }
                $pointsForm .= '</table>';
                //HIDDEN INPUT FO NUMBER OF POINTS
                $pointsForm .= '<input type="hidden" name="numPoints" id="numPoints" value="' . (count($pointsFile) - 1) . '" />';
                            
                    }
                    else //manually input points
                    {
                        
                        $numPoints = $_POST["numPoints"];
                        
                        for ($i = 1; $i <= $numPoints; $i++)
                        {
                            
                            $pointsForm .= '<tr">
                               <td>Point ' . $i . ':</td>';
                            $pointsForm .= ' <td><input size="12" maxlength="12" type="text" name="point[' . $i . ']" id="point[' . $i . ']" />';
                            $pointsForm .= ' <td>Marker ' . $i . ':</td>';
                            $pointsForm .= ' <td><input size="2" maxlength="2" type="text" name="pointTitle[' . $i . ']" id="pointTitle[' . $i . ']" /></td>';
                            $pointsForm .= '</tr>';
                        }
                        
            //HIDDEN INPUT FOR NUMBER OF POINTS
            $pointsForm .= '<input type="hidden" name="numPoints" id="numPoints" value="' . $numPoints . '" />';
            }
            
        // Remainder of form.
        $pointsForm .= '<input type="hidden" name="points_per_lane" id="points_per_lane" value="' . $_POST["points_per_lane"] . '" />';
        $pointsForm .= '<input type="hidden" name="number_slips" id="number_slips" value="' . $_POST["number_slips"] . '" />';
        $pointsForm .= '<input type="hidden" name="grid_ref" id="grid_ref" value="' . $_POST["grid_ref"] . '" />';
        $pointsForm .= '<input type="hidden" name="minDist" id="minDist" value="' . $_POST["minDist"] . '" />';
        $pointsForm .= '<input type="hidden" name="maxDist" id="maxDist" value="' . $_POST["maxDist"] . '" />';
        $pointsForm .= '<input name="task" value="generate" class="button" type="hidden" />';
        $pointsForm .= '</fieldset>';
        $pointsForm .= '<div style="width: 100%;text-align: center;margin-top:20px">';
        $pointsForm .= '<input name="submit" value="Submit" class="button" type="submit" />';
        $pointsForm .= '</div>';
        $pointsForm .= '</form>';
        
        //Output the form to the browser.
        return $pointsForm;  
    }
    
    /**
     * @name   buildMap()
     * @param  $markerPoints -  The course points
     * @param  $title - The point marker title
     * @param  $numPoints - The total nuber o points in the course.
     * @return HTML containing the google map to the browser along with all the course's points.
     */
    function buildMap($markerPoints, $title, $numPoints)
    {
        //instantiate a new MGRS grid coordinate
        $mgrs    = new NV_Mgrs;
        $longlat = $mgrs->convert($_POST["grid_ref"], $_POST["point"][1]);
        $map  = '';
        $map .= '<script type="text/javascript">';
            $map .= 'jQuery(function ($) {$(document).ready(function() {';
            $map .= 'var myLatlng = new google.maps.LatLng(' . $longlat->lat . ',' . $longlat->lng . ');';
            $map .= 'var myOptions = {center: myLatlng,mapTypeId: google.maps.MapTypeId.SATELLITE };';
            $map .= 'var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);';
            $map .= 'var bounds = new google.maps.LatLngBounds();';
            $map .= 'var image=new Array();';
        
        //Create map icons
        for ($i = 1; $i <= $numPoints; $i++)
        {
            if ($markerPoints[$i] != null)
            {
                $icon = NAVICOURSE_PLUGIN_DIR.'icon.php?title='.$title[$i].'';
                $map .= 'image[' . $i . ']= new google.maps.MarkerImage("data:image/png;base64,'.self::icon($title[$i]).'",';
                // This marker is 20 pixels wide by 32 pixels tall.
                $map .= 'new google.maps.Size(30, 40),';
                // The origin for this image is 0,0.
                $map .= 'new google.maps.Point(0,0),';
                // The anchor for this image is the base of the flagpole at 0,32.
                $map .= 'new google.maps.Point(0, 32));';
            }
        }
        
        //Create each point with marker pop-ups
        for ($i = 1; $i <= $numPoints; $i++)
        {
            if ($markerPoints[$i] != null)
            {
                $longlat = $mgrs->convert($_POST["grid_ref"], $_POST["point"][$i]);
                $map .= 'var myLatLng = new google.maps.LatLng(' . $longlat->lat . ',' . $longlat->lng . ');';
                $map .= 'var Marker = new google.maps.Marker({position: myLatLng,map: map,title: "' . $title[$i] . '|' . $markerPoints[$i] . '",icon:image[' . $i . ']});';
                $map .= 'bounds.extend(myLatLng);';
                $map .= 'map.fitBounds(bounds);';
            }
        }
        $map .=  '});
               });
               </script> ';
        
        //Returns the map with points to the browser
        return $map;
    }

    /**
     * @name  icon()
     * @param $text - the marker text
     * @retun a PNG icon image blended with the original icon and name of the icon.
     */
    function icon($text)
    { 
        $path = NAVICOURSE_PLUGIN_DIR.'markers/image.png';
        $im   = imagecreatefrompng($path);
        $text = $text;
        $font = NAVICOURSE_PLUGIN_DIR .'fonts/verdana.ttf';
        $size = 8;
        $bbox = imagettfbbox($size, 0, $font, $text);
        $x    = 2;
        $y    = 5 - $bbox[5];
        $black = imagecolorallocate($im, 0, 0, 0);
        imagettftext($im, $size, 0, $x, $y, $black, $font, $text);
        imagealphablending($im, false);
        imagesavealpha($im, true);
        ob_start (); 
        imagepng($im);
        $image_data = ob_get_contents (); 
        ob_end_clean (); 
        $image_data_base64 = base64_encode ($image_data);
        imagedestroy($im);
        return $image_data_base64;     
    }
    
    /**
     * @name buildCourse()
     * @return The entire course containing the inputed points and the generating land navigation course with map, grade slips and solution sheets.
     */
    public function buildCourse()
    {
        //Variable Declarations
        $minDistance  = $_POST["minDist"];
        $maxDistance  = $_POST["maxDist"];
        $points       = $_POST["point"];
        $markerPoints = $_POST["point"];
        $numPoints    = $_POST["numPoints"];
        $title        = $_POST["pointTitle"];
        $tries        = 0;
        $noGo         = null;
        $time_start   = microtime(true);
        
        $inPoints  = '';
        //the amount of attempts to generte the course.
        $tries = 0;
        
        //Set defaults
        $minLnDistance = (isset($_POST["minLnDistance"]))? $_POST["minLnDistance"]: 50;
        $maxLnDistance = (isset($_POST["maxLnDistance"]))? $_POST["maxLnDistance"]: 3500;
        
        //Build the inputed course layout
        foreach ($points as $key => $point)
        {
            $inPoints .= '<div class="inpoints pull-left">Point #' . $key . ': ' . $point . '</div>';
        }
        
        
        //LANE SLIPS
        $numberofslips = $_POST["number_slips"];
        $pointNumber    = array();
        $toExcel        = array();
        $toExcelSol     = array();
        $pointsPerLane  = $_POST["points_per_lane"];
        $longlatCon     = array();
        $mgrs           = new NV_Mgrs;
        $distance       = array();
        $dist           = new NV_Tsp;
        $exist = array();
        
        $i = 1;
        while ($i <= $numberofslips)
        {
            $laneNum = $i;
            shuffle($points);
            //Print Lane strips horizontally
            for ($j = 1; $j <= $pointsPerLane; $j++)
            {
                if ($j < $pointsPerLane)
                {
                    $distance[$j]      = $dist->distance(substr($points[$j], 2), substr($points[$j + 1], 2));
                    $distanceCount[$j] = $distance[$j]['dist'];
                }
                ;
            }
            ;
            $avgDistMin = min($distanceCount);
            $avgDistMax = max($distanceCount);
            $laneAvg    = array_sum($distanceCount) / count($distanceCount);
            $totalDist  = array_sum($distanceCount);
            
            $totalCourseMinDist[] = $avgDistMin;
            $totalCourseMaxDist[] = $avgDistMax;
            
            
            if (($avgDistMin > $minDistance && $avgDistMax < $maxDistance) && ($totalDist > $minLnDistance && $totalDist < $maxLnDistance))
            {
                $laneSlTables .= '<div class="pull-left laneBlock">';
                $laneSlTables .= '<div class="laneNum">LANE: ' . $laneNum . '</div>';
                
                for ($lanes = 1; $lanes <= $pointsPerLane; $lanes++)
                {
                    
                    $key = array_search($points[$lanes], $_POST["point"]);
                    $pointNumber[$i][$lanes] = array(
                        $points[$lanes],
                        $title[$key]
                    );
                    $toExcel[$i][$lanes]     = $points[$lanes];
                    $toExcelSol[$i][$lanes]  = array(
                        $points[$lanes],
                        $title[$key]
                    );
                    
                    
                    $laneSlTables .= '<div class="lanePoints" align="center">' . $points[$lanes] . '</div>';
               }
                 $laneSlTables .='<div class="laneDist">MIN: '. round($avgDistMin).' METERS ]</div>';
                 $laneSlTables .='<div class="laneDist">MAX: '. round($avgDistMax).' METERS ]</div>';
                 $laneSlTables .='<div class="laneDist">AVG: '. round($laneAvg).' METERS ]</div>';
                 $laneSlTables .='<div class="laneDist">SUM: '. round($totalDist).' METERS ]</div>';
                 $laneSlTables .='</div>';
                
                $i++;
            }
            else
            {
                $tries++;
                // echo 'Seconds:'.$time_now - $time_start.'<br/>';
                   
                   $totDist =  array_sum($totalCourseMinDist)/count($totalCourseMinDist);
                
                    if ((microtime(true) - $time_start) > 25 && ($tries/$i) >=1){
                         $noGo = '<div style="font-size:20px;"><b>Warning: </b>Your Course maybe very difficult to generate, based on your settings. 
                         Please re-configure your points. We recommend that you set your minimum distance to no more than '.round(min($totalCourseMinDist)).' meters 
                         and your max distance to less than '.round(max($totalCourseMaxDist)).' meters, to best maximize your chance of generating '.$numberofslips.' Slips from this course.</div>';
                          break;
                      }
                 
            }
            
        }
        if (empty($noGo))
        {
              
            //BUILD SOLUTIONS
            $s = 1;
            
            $solutions = null;
            
            $solutions = '<div class="clearfix">';
            
            
            for ($s = 1; $s <= $numberofslips; $s++)
            {
                $solutions .= '<div class="pull-left solblock">';
                $laneNumSol = $s;
                
                $solutions .= '<div class="laneNum">Lane ' . $laneNumSol . '</div>';
                
                for ($i = 1; $i <= $pointsPerLane; $i++)
                {
                    $pointWoutGR = $pointNumber[$s][$i][0];
                    
                    $solutions .= '<div class="lanePoints">' . $pointWoutGR .'<br /><font class="laneAnswer">Marker: '. $pointNumber[$s][$i][1] . '</font></div>';
                    
                    
                }
                $solutions .= '</div>';
            }
            
            $solutions .= '</div>';
            $html .= '<div><h2 style="width: 850px;">POINTS</h2></div>';
            $html .= '<div class="clearfix" class="pointsContainer">' . $inPoints . '</div>';
            $html .= '<div><h2 style="width: 850px;text-align: center;">LANE STRIPS</h2></div>';
            $html .= '<div class="lsContainers clearfix">' . $laneSlTables . '</div>';
            $html .= '<div><h2 style="width: 850px;text-align: center;">LANE SOLUTIONS</h2></div>';
            $html .= '<div class="lSolutions">' . $solutions . '</div>';
            $lanesPrintData    = urlencode(serialize($toExcel));
            $solutionPrintData = urlencode(serialize($toExcelSol));
            print self::buildMap($markerPoints, $title, $numPoints);
            $html .= '<div id="map_canvas"></div>';
            $html .= '<div class="printIcons">';
              $html .= '<div style="margin: 0 auto;width:200px;font-size:8px" class="clearfix">';
                $html .= '<div class="pull-left">';
                 $html .= '<a href="#" onclick="document.printSlips.submit(); return false;">';
                    $html .= '<img width="100px" src="'. NAVICOURSE_PLUGIN_URL.'images/pdf.png" alt="print" /></a>';
                    $html .= '<div>PRINT LANE STRIPS</div>';
                    $html .= '</div>';
                    $html .= '<div class="pull-left">';
                    $html .= '<a href="#" onclick="document.printSol.submit(); return false;">';
                    $html .= '<img width="100px" src="'. NAVICOURSE_PLUGIN_URL.'images/pdf.png" alt="print" /></a>';
                    $html .= '<div>PRINT SOLUTIONS</div>';
                $html .= '</div>';
              $html .= '</div>';
            $html .= '<form id="printSlips" name="printSlips" method="post" action="'.NAVICOURSE_PLUGIN_URL.'print.php">';
              $html .= '<input type="hidden" value="' . $lanesPrintData . '" name="t" />';
              $html .= '<input type="hidden" value="' . urlencode(serialize("course")).'" name="task" />';
            $html .= '</form>';
            $html .= '<form id="printSol" name="printSol" method="post" action="'.NAVICOURSE_PLUGIN_URL.'print.php">';
              $html .= '<input type="hidden" value="' . $solutionPrintData .'" name="sol" />';
              $html .= '<input type="hidden" value="' . $lanesPrintData . '" name="t" />';
              $html .= '<input type="hidden" value="' . urlencode(serialize("solutions")) . '" name="task" />';
            $html .= '</form>';
            $html .= '</div>';
            
            //ALL IS GOOD RETURN GENERATING COURSE
            return $html;
        }
        else
        { 
            //RETURNS NOGO ERROR
            return $noGo;
        }
        
    }
}