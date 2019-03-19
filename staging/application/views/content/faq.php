<section>
        	<div class="contentWrapper">
                <div class="mainWrapper nobanner">
                	<div class="faqWrapper">
                    	<h2>FAQs</h2>

                        <?php if($faq_cat)foreach ($faq_cat as $list) { ?>
                        <h3 class="faqCategory"><?php echo $list['name'] ?></h3>
                        <?php if($faq)foreach ($faq as $a) { ?>
                        <?php if($list['id']==$a['faq_category_id']){ ?>
                    	<div class="faqPanel">
                            <p class="faqQuestion"><?php echo $a['question'] ?></p>
                            <p class="faqAnswer"><?php echo $a['answer'] ?></p>
                        </div>
                        <?php } } } ?>

                      
                    </div>
                </div>
            </div>
        </section>