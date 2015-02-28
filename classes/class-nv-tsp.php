<?php
/**
 * @package     Navicourse
 * @uses NV_Mgrs, NV_Tsp
 * @description This class is a calculator for the common "Travelling salesman" maths problem.
 *              It takes any number of coordinates and brute force calculates the shortest distance to travel to all those points.
 *              It doesn't do anything clever like forcing a starting / ending point, however this could easily be implemented..
 * @author      Orginal Author : Ross Scrivener  |  Edited by: Jean N. Pijeau <nick.pijeau@gmail.com>
 */
class NV_Tsp
{
    private $locations = array(); // all locations to visit
    private $longitudes = array();
    private $latitudes = array();
    private $shortest_route = array(); // holds the shortest route
    private $shortest_routes = array(); // any matching shortest routes
    private $shortest_distance = 0; // holds the shortest distance
    private $all_routes = array(); // array of all the possible combinations and there distances
    // add a location
    public function add($name, $longitude, $latitude)
    {
        $this->locations[$name] = array('longitude' => $longitude, 'latitude' => $latitude);
    }
    // the main function that des the calculations
    public function compute()
    {
        $locations = $this->locations;
        foreach ($locations as $location => $coords) {
            $this->longitudes[$location] = $coords['longitude'];
            $this->latitudes[$location] = $coords['latitude'];
        }
        $locations = array_keys($locations);
        $this->all_routes = $this->array_permutations($locations);
        foreach ($this->all_routes as $key => $perms) {
            $i = 0;
            $total = 0;
            foreach ($perms as $value) {
                if ($i < count($this->locations) - 1) {
                    $total += $this->distance($this->latitudes[$perms[$i]], $this->longitudes[$perms[$i]],
                        $this->latitudes[$perms[$i + 1]], $this->longitudes[$perms[$i + 1]]);
                }
                $i++;
            }
            $this->all_routes[$key]['distance'] = $total;
            if ($total < $this->shortest_distance || $this->shortest_distance == 0) {
                $this->shortest_distance = $total;
                $this->shortest_route = $perms;
                $this->shortest_routes = array();
            }
            if ($total == $this->shortest_distance) {
                $this->shortest_routes[] = $perms;
            }
        }
    }
    function distance($pt1, $pt2)
    {
        $pi = 3.141592653589793;
        $distmuth = array();
        $x1 = substr($pt1, 0, (strlen($pt1) / 2));
        $y1 = substr($pt1, -(strlen($pt1) / 2));
        $x2 = substr($pt2, 0, -(strlen($pt2) / 2));
        $y2 = substr($pt2, -(strlen($pt2) / 2));
        // // Note that Math.log() is the natural logarithm, not the common logarithm.
        if ($x1 != $x2) {
            $x1 = $x1 * pow(10, 4 - floor(log($x1) / log(10)));
            $x2 = $x2 * pow(10, 4 - floor(log($x2) / log(10)));
        }
        if ($y2 != $y1) {
            $y1 = $y1 * pow(10, 4 - floor(log($y1) / log(10)));
            $y2 = $y2 * pow(10, 4 - floor(log($y2) / log(10)));
        }
        $distance = sqrt((($x2 - $x1) * ($x2 - $x1)) + (($y2 - $y1) * ($y2 - $y1)));
        //document.getElementById('dist').innerHTML = "Distance = " + Math.round(distance) + " meters.<br>";
        $radx = $x2 - $x1;
        $rady = $y2 - $y1;
        $grid_azimuth = ((-atan2($rady, $radx) * 180.0 / $pi) + 450) % 360.0;
        // document.getElementById('gridAzimuth').innerHTML = "Grid Azimuth = " + Math.round(grid_azimuth) + " degrees.<br>";
        $distmuth['dist'] = $distance;
        $distmuth['azm'] = $grid_azimuth;
        return $distmuth;
    }
    function distanceNoAz($pt1, $pt2)
    {
        $pi = 3.141592653589793;
        $distmuth = array();
        $x1 = substr($pt1, 0, (strlen($pt1) / 2));
        $y1 = substr($pt1, -(strlen($pt1) / 2));
        $x2 = substr($pt2, 0, -(strlen($pt2) / 2));
        $y2 = substr($pt2, -(strlen($pt2) / 2));
        // // Note that Math.log() is the natural logarithm, not the common logarithm.
        if ($x1 != $x2) {
            $x1 = $x1 * pow(10, 4 - floor(log($x1) / log(10)));
            $x2 = $x2 * pow(10, 4 - floor(log($x2) / log(10)));
        }
        if ($y2 != $y1) {
            $y1 = $y1 * pow(10, 4 - floor(log($y1) / log(10)));
            $y2 = $y2 * pow(10, 4 - floor(log($y2) / log(10)));
        }
        $distance = sqrt((($x2 - $x1) * ($x2 - $x1)) + (($y2 - $y1) * ($y2 - $y1)));
        $radx = $x2 - $x1;
        $rady = $y2 - $y1;
        $grid_azimuth = ((-atan2($rady, $radx) * 180.0 / $pi) + 450) % 360.0;
        $distmuth['dist'] = $distance;
        $distmuth['azm'] = $grid_azimuth;
        return $distance;
    }
    // work out all the possible different permutations of an array of data
    private function array_permutations($items, $perms = array())
    {
        static $all_permutations;
        if (empty($items)) {
            $all_permutations[] = $perms;
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->array_permutations($newitems, $newperms);
            }
        }
        return $all_permutations;
    }
    // return an array of the shortest possible route
    public function shortest_route()
    {
        return $this->shortest_route;
    }
    // returns an array of any routes that are exactly the same distance as the shortest (ie the shortest backwards normally)
    public function matching_shortest_routes()
    {
        return $this->shortest_routes;
    }
    // the shortest possible distance to travel
    public function shortest_distance()
    {
        return $this->shortest_distance;
    }
    // returns an array of all the possible routes
    public function routes()
    {
        return $this->all_routes;
    }
}