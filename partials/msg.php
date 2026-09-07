<?php
    if (isset($_SESSION['error_msg']) ) {
        echo "<p class='animate__animated animate__flash alert alert-warning'> ". $_SESSION['error_msg'] ." </p>";
         unset($_SESSION['error_msg']);
     }
  ?>

  <?php
    if (isset($_SESSION['msg']) ) {
        echo "<p class='animate__animated animate__flash alert alert-info'> ". $_SESSION['msg'] ." </p>";
         unset($_SESSION['msg']);
     }
  ?>
