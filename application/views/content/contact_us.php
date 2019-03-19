<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper banner">
                	<div class="banner">
                    	<img src="<?php echo base_url() ?>userdata/contact_us/<?php echo $detail['image'] ?>">
                        <h1><?php echo $detail['title'] ?></h1>
                    </div>
                	<div class="inputWrapper">
                        <h3>drop us a line</h3>
                        <div class="inputField">
                            <form method="post" id="formID2" action="<?php echo site_url('contact_us/send_email') ?>">
                            <input class="defTxtInput" name="name" placeholder="Name">
                            <input class="defTxtInput" name="phone" placeholder="Phone Number">
                            <input class="defTxtInput" name="email" placeholder="Email">
                            <textarea class="defTxtInput" name="message" placeholder="Message"></textarea>
                            <a href="javascript:void(0)" id="submit2" class="defBtn">SEND</a>
                        </div>
                        <br><br><br>
                        <p><strong>Address :</strong> <?php echo $detail['address'] ?></p>
                        <p><strong>Fax :</strong> <?php echo $detail['fax'] ?> <strong>| Email :</strong> <?php echo $detail['email'] ?></p>
                        <p><strong>Operating Hours :</strong> <?php echo $detail['operating_hours'] ?></p>
                        <p><strong>US Representative :</strong> <?php echo $detail['us_representative'] ?> <strong>| Phone :</strong> <?php echo $detail['phone'] ?> <strong>| Email :</strong> <?php echo $detail['email_representative'] ?></p>
                    </div>
                </div>
            </div>
        </section>
<script>
$("#submit2").click(function() {
        $("#formID2").submit();
    });
</script>

<?php if($this->session->flashdata('notif1')){?>
<script>
    alert('<?php echo $this->session->flashdata('notif1')?>');
</script>
<?php }?>