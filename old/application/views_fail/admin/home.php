<div id="content">
    <h2>Welcome to your Dashboard!</h2>
</div>
<script>
<?php if(isset($_SESSION['success_clear'])){?>
alert('shopping cart has been clear');
<?php unset($_SESSION['success_clear']); } ?>
</script>