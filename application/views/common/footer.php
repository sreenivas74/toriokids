
        <footer>
            <div class="upperNav">
                <ul>
                    <?php if($secondary)foreach ($secondary as $list) { ?>
                    <li><a <?php if($list['link']){ ?> href="<?php echo $list['link'] ?>" <?php } ?>><?php echo $list['name'] ?></a></li>
                    <?php } ?>
                </ul>
               <!--  <div class="bankLink">
                    <p>Secure Payments via</p>
                    <img src="<?php echo base_url() ?>templates/images/bankicon.png">
                </div> -->
            </div>
            <div class="bottomNav">
                <ul>
                    <?php if($footer)foreach ($footer as $list) { ?>
                    <li><a <?php if($list['link']){ ?> href="<?php echo $list['link'] ?>"<?php } ?>><?php echo $list['name'] ?></a></li>
                    <?php } ?>
                </ul>
                <p>Copyright 2016 &copy; Torio Kids. All rights reserved.</p>
            </div>
        </footer>