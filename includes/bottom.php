</div>
      <!-- End of Main Content -->
      <!-- To add Credits in future
        <a class="card nav-link text-right" href="http://www.ledzapid.com">
          <span>-Powered By Ledzapid</span></a -->

    </div>
    <!-- End of Content Wrapper -->
    
  </div>
  <!-- End of Page Wrapper -->
  
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you want to logout</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript ---- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="libs/jquery/jquery-3.5.1.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
<?php if(isset($bjs)) { ?>
  <script src="js/<?php echo $bjs ?>"></script>
<?php } ?>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.js"></script>



</body>

</html>