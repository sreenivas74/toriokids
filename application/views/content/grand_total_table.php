<?php $discount=0;
?>  


                                <table>
                                	<tr>
                                    	<td>SUBTOTAL</td>
                                        <td>Rp <?php echo number_format($total_harga_diskon['totalsemua']);?>,-</td>
                                    </tr>
                                    <?php if ($voucher_list) foreach($voucher_list as $list5){?>
                                    <tr>
                                    	<td>Discount</td>
                                        <td>Rp <?php $discount+=$list5['total']; echo number_format($list5['total']) ?>,-</td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($get_discount_stamps){?>
                                        <tr>
                                            <td>Total Price</td>
                                            <td>Rp <?php echo money2($total_price);?></td>
                                        </tr>
                                        <tr>
                                            <td>Discount Coupon</td>                    
                                            <?php $discount=$get_discount_stamps['total']?>
                                            <td>Rp <?php echo money2($discount) ?> </td>
                                        </tr>
                                  <?php } ?>

                                    <tr>
                                    	<td>TOTAL</td>
                                        <td>Rp <?php echo number_format($total_price-$discount);?>,-</td>
                                    </tr>
                                </table>
