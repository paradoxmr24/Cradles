<?php 
function printType($a) {
  if($a == 'O') 
    return 'Objective';
  if($a == 'S')
    return 'Subjective';
}
function getFormattedDate($date) {
    $date = $date[8] . $date[9] . '/' . $date[5] . $date[6] . '/' . $date[0] . $date[1] . $date[2] . $date[3];
    return $date;
}
function getFormattedTime($time, $extended = false) {
    $time_h = $time[0] . $time[1];
    $m = 'AM';
    if($time_h > 12) {
    $m = 'PM';
    $time_h -= 12;
    }
    if($extended) {
        $time = $time_h . ':' . $time[3] . $time[4] . ':' . $time[6] . $time[7] . ' ' . $m;
    } else {
        $time = $time_h . ':' . $time[3] . $time[4] . ' ' . $m;
    }
    return $time;
}
function formButton($method,$action,$name,$value,$color,$button) { ?>
    <form method="<?php echo $method; ?>" action="<?php echo $action; ?>">
        <input name="<?php echo $name; ?>" style="display:none;!important" value="<?php echo $value ?>">
        <button class="btn <?php echo $color; ?>" type="submit"><?php echo $button; ?></button>
    </form>

<?php } 
?>