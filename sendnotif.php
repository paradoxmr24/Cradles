<?php 
$role = 'Teacher';
require 'includes/validate.php';
require_once 'includes/connection.php';
$title = 'Send Notification';
$js = 'sendnotif.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="row p-3">
<div class="col-lg-6 col-md-6 col-12">
<section class="p-3 mx-auto m-3 rounded shadow card border-bottom-primary">
<form action="functions/sendnotif.php" method="post">
    <div class="form-group">
        <label>From</label>
        <input class="form-control" type="text" name="Sender" maxlength="15">
    </div>
    <div class="form-group">
        <label>To:</label>
        <select class="custom-select" name="Reciever" onchange="show(this)">
            <option value="All" selected>All</option>
            <option value="CS">Class & Section</option>
        </select>
    </div>
    <div class="form-group d-none row" id="cs">
        <div class="col">
            Class
            <input type="number" name="Class" class="form-control" maxlength="2" oninput="checkLimit(this, 2)">
        </div>
        <div class="col">
            Section
            <input type="text" name="Section" class="form-control" maxlength="1">
        </div>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" id="message" rows="3" name="Message" maxlength="150"></textarea>
    </div>
    <button class="btn btn-primary form-control" id="submit" onclick="click()">Submit</button>
</form>
</section>
</div> <div class="col-lg-6 col-md-6 col-12">
<section class="p-3 mx-auto m-3 rounded shadow card border-bottom-primary">
    Send Notifications to students in one Click<br><br>
    <ul>
        <li>Select all to send a notification to all students in your college.</li>
        <li>Select class & section to send notification to a particular class and section.</li>
        <li>Notifications will be deleted automatically after 1 day</li>
    </ul>
</section>
</div>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
