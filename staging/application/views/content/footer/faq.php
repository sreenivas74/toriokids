<div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a> FAQs</a>
</div>
<div class="faqContent">
    <h2>Frequently Asked Questions</h2>
</div>
<div class="container">
    <div class="faqCon">
        <div class="faqQuestion">
        	<?php if($faq_cat)foreach($faq_cat as $fc){?>
            <h3><?php echo $fc['name']?></h3>
            <ul>
            	<?php if($faq)foreach($faq as $faq1){ if($fc['id']==$faq1['faq_category_id']){?>
                <li>
                    <div class="faqsQuestion"><a href="javascript:void(0)">+ <?php echo $faq1['question']?></a></div>
                    <div class="faqsAnswer"><?php echo $faq1['answer']?></div>
                </li>
                <?php }}?>
            </ul>
            <?php }?>
        </div>
    </div>
</div>