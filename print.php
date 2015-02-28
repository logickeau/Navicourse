<?php
/*
Author: Jean N Pijeau
Author URI: http://logickeau.com
Description: This file generates the pdf navigation course slips for use of grading purposes.
License: GPLv2 or later
Text Domain: navicourse
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


ini_set("memory_limit", "120M");
set_time_limit(60);
$task = unserialize(urldecode($_POST["task"]));
$slips = unserialize(urldecode($_POST["t"]));
$numSlips = count($slips);
$numLanes = count($slips[1]);
require ('tools/fpdf16/ean13.php');
$pdf = new PDF_EAN13();
$pdf->AddPage();
if ($task == "course") {
    for ($i = 1; $i <= $numSlips; $i++) {
        if ($i % 2) {
            //1st Card of page;
            //Master Rectangle
            $pdf->SetXY(10, 20);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(190, 115, '', 1);
            //points
            $pdf->SetFont('Arial', '', 9);
            for ($j = 1; $j <= $numLanes; $j++) {
                $pdf->SetXY($j * 21, 21);
                $pdf->SetDrawColor(50, 60, 100);
                $pdf->Cell(21, 5, $slips[$i][$j], 1);
            }
            $pdf->SetFont('Arial', 'B', 14);
            //Name
            $pdf->SetXY(17, 30);
            $pdf->Cell(96, 10, 'Land Navigation TA-S9 Score Card');
            //name and stuff
            $pdf->SetFont('Arial', '', 11);
            //Name
            $pdf->SetXY(15, 40);
            $pdf->Cell(96, 10, 'NAME: ______________________________________');
            //Regiment
            $pdf->SetXY(15, 48);
            $pdf->Cell(96, 10, 'REGIMENT: ___________ COMPANY: ____________');
            //Regiment
            $pdf->SetXY(15, 56);
            $pdf->Cell(96, 10, 'PLATOON: __________________________________ ');
            //Start Time
            $pdf->SetXY(15, 64);
            $pdf->Cell(96, 10, 'START TIME: ________________________________');
            //END TIME
            $pdf->SetXY(15, 72);
            $pdf->Cell(96, 10, 'FINISH TIME: ________________________________');
            //COURSE
            $pdf->SetXY(15, 80);
            $pdf->Cell(96, 10, 'COURSE (DAY/NIGHT): _______________________');
            //LANE #
            $pdf->SetXY(15, 88);
            $pdf->Cell(96, 10, 'LANE #: _______ DATE: _______________________');
            //#
            $pdf->SetXY(36, 87);
            $pdf->Cell(10, 10, $i);
            //LANE #
            $pdf->SetXY(15, 100);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(97, 30, '', 1);
            $pdf->SetXY(17, 100);
            $pdf->Cell(90, 10, 'TOTAL OF POINTS: _______________________');
            $pdf->SetXY(17, 108);
            $pdf->Cell(90, 10, 'PENALTY POINT: _________________________');
            $pdf->SetXY(17, 116);
            $pdf->Cell(90, 10, 'FINAL SCORE: ___________________________');
            // grading boxes Left
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetXY(120, 32);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 30);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 40);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 38);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(120, 54);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 52);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 62);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 60);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(120, 76);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 74);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 84);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 82);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(120, 98);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 96);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 106);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 104);
            $pdf->Cell(35, 8, 'STAMP');
            // grading boxes Right
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetXY(160, 32);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 30);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 40);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 38);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(160, 54);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 52);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 62);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 60);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(160, 76);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 74);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 84);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 82);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(160, 98);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 96);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 106);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 104);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(120, 122);
            $pdf->Cell(180, 8, "GRADER: _____________________ RANK: ____");
            $pdf->SetXY(160, 96);
        } else {
            //2nd Card of page;
            //Master Rectangle
            $pdf->SetXY(10, 160);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(190, 115, '', 1);
            //points
            $pdf->SetFont('Arial', '', 9);
            for ($j = 1; $j <= $numLanes; $j++) {
                $pdf->SetXY($j * 21, 161);
                $pdf->SetDrawColor(50, 60, 100);
                $pdf->Cell(21, 5, $slips[$i][$j], 1);
            }
            $pdf->SetFont('Arial', 'B', 14);
            //Name
            $pdf->SetXY(17, 170);
            $pdf->Cell(96, 10, 'Land Navigation TA13 Score Card');
            //name and stuff
            $pdf->SetFont('Arial', '', 11);
            //Name
            $pdf->SetXY(15, 180);
            $pdf->Cell(96, 10, 'NAME: ______________________________________');
            //Regiment
            $pdf->SetXY(15, 188);
            $pdf->Cell(96, 10, 'REGIMENT: ___________ COMPANY: ____________');
            //Regiment
            $pdf->SetXY(15, 196);
            $pdf->Cell(96, 10, 'PLATOON: __________________________________ ');
            //Start Time
            $pdf->SetXY(15, 204);
            $pdf->Cell(96, 10, 'START TIME: ________________________________');
            //END TIME
            $pdf->SetXY(15, 212);
            $pdf->Cell(96, 10, 'FINISH TIME: ________________________________');
            //COURSE
            $pdf->SetXY(15, 220);
            $pdf->Cell(96, 10, 'COURSE (DAY/NIGHT): _______________________');
            //LANE #
            $pdf->SetXY(15, 228);
            $pdf->Cell(96, 10, 'LANE #: _______ DATE: _______________________');
            //#
            $pdf->SetXY(36, 227);
            $pdf->Cell(10, 10, $i);
            //LANE #
            $pdf->SetXY(15, 240);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(97, 30, '', 1);
            $pdf->SetXY(17, 240);
            $pdf->Cell(90, 10, 'TOTAL OF POINTS: _______________________');
            $pdf->SetXY(17, 248);
            $pdf->Cell(90, 10, 'PENALTY POINT: _________________________');
            $pdf->SetXY(17, 256);
            $pdf->Cell(90, 10, 'FINAL SCORE: ___________________________');
            // grading boxes Left
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetXY(120, 172);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 170);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 180);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 178);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(120, 194);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 192);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 202);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 200);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(120, 216);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 214);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 224);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 222);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(120, 238);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(120, 236);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(120, 246);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(120, 244);
            $pdf->Cell(35, 8, 'STAMP');
            // grading boxes Right
            $pdf->SetFont('Arial', '', 5);
            $pdf->SetXY(160, 172);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 170);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 180);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 178);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(160, 194);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 192);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 202);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 200);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(160, 216);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 214);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 224);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 222);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetXY(160, 238);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(35, 8, '', 1, '', 'C');
            $pdf->SetXY(160, 236);
            $pdf->Cell(35, 8, 'LETTER/NUMBER', '', '', 'C');
            $pdf->SetXY(160, 246);
            $pdf->Cell(35, 10, '', 1);
            $pdf->SetXY(160, 244);
            $pdf->Cell(35, 8, 'STAMP');
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(120, 262);
            $pdf->Cell(180, 8, "GRADER: _____________________ RANK: ____");
            $pdf->SetXY(160, 96);
        }
        if ($i % 2 == 0 && $i < $numSlips) {
            $pdf->AddPage();
        }
    }
} elseif ($task == "solutions") {
    $pointSol = unserialize(urldecode($_POST["sol"]));
    $vert = 1;
    for ($s = 1; $s <= $numSlips; $s++) {
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(5, $vert * 15);
        $pdf->SetDrawColor(50, 60, 100);
        $pdf->SetFillColor(238, 233, 233);
        $pdf->Cell(15, 5, $s, 1, '', 'C', true);
        //points
        for ($j = 1; $j <= $numLanes; $j++) {
            $pointWoutGR = $pointSol[$s][$j][0];
            $pdf->SetXY($j * 23, $vert * 15);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->MultiCell(23, 5, $pointWoutGR . "\nPT:" . $pointSol[$s][$j][1], 1, 'C', false);
        }
        $vert++;
        if ($s % 17 == 0 && $i < $numSlips) {
            $pdf->AddPage();
            $vert = 1;
        }
    }
}
//$pdf->EAN13(80,40,'123456789012');
$pdf->Output('' . ($task == "course") ? "course.pdf" : "course_solutions.pdf" . '','D');