<?php
  session_start();
  unset($_SESSION['user']); 
  session_destroy(); 
?>
<script type="text/javascript">
    alert('Selamat, Anda berhasil logout.');
    location.href = "login.php"; 
</script>