<?php 
date_default_timezone_set("Asia/Calcutta");
function checkTime($exam) {
if($exam['E_Date'] == date('Y') . '-' . date('m') . '-' . date('d')) {
    if (time() >= strtotime($exam['E_Time']) && time() <= (strtotime($exam['E_Time']) + toSec($exam['Duration'])) ) {
        $data['status'] = 's';
        $data['endTime'] = strtotime($exam['E_Time']) + toSec($exam['Duration']);
    } else if(time() > (strtotime($exam['E_Time']) + toSec($exam['Duration']))) {
        $data['status'] = 'e';
    } 
    else {
        $data['status'] = 'ns';
        $data['time'] = getFormattedTime($exam['E_Time']);
        $data['date'] = getFormattedDate($exam['E_Date']);
    }
} elseif($exam['E_Date'] > date('Y') . '-' . date('m') . '-' . date('d')) {
    $data['status'] = 'ns';
    $data['time'] = getFormattedTime($exam['E_Time']);
    $data['date'] = getFormattedDate($exam['E_Date']);
} else {
    $data['status'] = 'e';
}
return $data;
}

function toSec($a) {
    return $a*60;
}
?>