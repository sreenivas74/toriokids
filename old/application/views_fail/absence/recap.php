<h2>Salary Periode ( <?php echo date("d F Y",strtotime($periode_from))?> - <?php echo date("d F Y",strtotime($periode_to))?>)</h2>

<form name="salary_employee_by_periode" method="post" action="<?php echo site_url('absence/update_salary_by_periode/')?>" enctype="multipart/form-data">
<input type="submit" value="Continue" onclick="return confirm('Are you sure?');" style="padding:4px;" /><br /><br />
<h2>active day:<?php echo $active_day ?></h2>
<table class="form" style="width:100%; color:#000">
	<thead>
    	<th>USERID</th>
        <th>Target</th>
        <th>Absent</th>
        <th>off</th>
    	<!--<th>Gaji Pokok</th>
        <th>Uang Makan</th>
        <th>Uang Sewa Motor</th>-->
        <th>Lembur</th>
        <!--<th>Lembur Weekend</th>
        <th>Bonus Massa</th>-->
        <th>Telat</th>
        <th>Potongan Telat</th>
        <!--<th>Potongan PPH21</th>-->
        <th>Kelebihan Pembayaran</th>
        <th>Kekurangan Pembayaran</th>
        <th>Potongan Tidak Hadir Meeting</th>
        <!--<th>Insurance</th>-->
        <th>Tambah Utang</th>
        <th>Bayar Utang</th>
        
    </thead>
    <tbody>
    <?php $n = 1 ;?>
    	<?php if($list)foreach($list as $list){?>
        		
                <?php  
				$bonus_massa = date('Y') - date('Y',strtotime(find_2('join_date','userid',$list['user_id'],'employee_tb')));
				$bonus_massa_cost=0;
				if($bonus_massa>=2){
					$bonus_massa_cost =  find_2('meal','userid',$list['user_id'],'employee_salary_tb')*$bonus_massa*2;
				}?>
                
                <tr> 
                	<td><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb');hidden_input($n,'user_id', $list['user_id']);?></td>
                    
                    <?php hidden_input($n,'target', $list['target']); ?>
                    <?php currency($total_salary = calculate_salary(find_2('salary','userid',$list['user_id'],'employee_salary_tb'),$list['target'],find_2('department_id','userid',$list['user_id'],'employee_tb'),$list['working_day'],$list['overtime'],find_2('overtime_1','userid',$list['user_id'],'employee_salary_tb'),find_2('meal','userid',$list['user_id'],'employee_salary_tb'),find_2('vehicle','userid',$list['user_id'],'employee_salary_tb'),find_2('bonus_rice','userid',$list['user_id'],'employee_salary_tb'), find_2('bonus_performance','userid',$list['user_id'],'employee_salary_tb'),find_2('bonus_plus','userid',$list['user_id'],'employee_salary_tb'),$bonus_massa_cost, find_2('sim_a','userid',$list['user_id'],'employee_salary_tb'),find_2('sim_a','userid',$list['user_id'],'employee_salary_tb'),find_2('bonus_skill','userid',$list['user_id'],'employee_salary_tb'),$list['under_payment'],find_2('pph21','userid',$list['user_id'],'employee_salary_tb'),$list['late'],find_2('late_cost','userid',$list['user_id'],'employee_salary_tb'),$list['meeting_absence'],1,$list['over_payment'],find_2('insurance','userid',$list['user_id'],'employee_salary_tb'),$list['debt'],$list['paid'])) ?>
                    <td align="center">
					<?php if($list['target']==1){?>
                    	<img src="<?php echo base_url()?>images/active.png" width="10" height="10" />
                    <?php }else{?>
                    	<img src="<?php echo base_url()?>images/delete.png" width="10" height="10" />
                    <?php }?>
                    </td>
                    <td align="center"><?php echo $list['working_day']?></td>
                    <td align="center"><?php echo $list['absent']?></td>
                    
						<?php 
						if($list['target']==1){
							//echo currency(find_2('salary','userid',$list['user_id'],'employee_salary_tb'));
						}else{
							//echo currency(find_2('salary','userid',$list['user_id'],'employee_salary_tb')/2);
						}
						hidden_input($n,'salary', $total_salary); ?>
                   	
                    <?php $meal = $list['working_day']*find_2('meal','userid',$list['user_id'],'employee_salary_tb');
					//echo currency($meal);
					hidden_input($n,'meal', $meal);  ?>
                    <?php $vehicle = find_2('vehicle','userid',$list['user_id'],'employee_salary_tb');
						//echo currency($vehicle);
					hidden_input($n,'vehicle', $vehicle);  ?>
                    <?php $bonus_rice = find_2('bonus_rice','userid',$list['user_id'],'employee_salary_tb');hidden_input($n,'bonus_rice', $bonus_rice);  ?>
                    <td align="center">
						<?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==1) { $overtime = $list['overtime']; echo currency($overtime); } else echo $overtime = 0;hidden_input($n,'overtime_1', $overtime); ?>
                     </td>
                    <?php /*?><td align="center"><?php echo "undefined ";hidden_input($n,'overtime_2', 0);  ?></td><?php */?>
                    <?php $bonus_performance = find_2('bonus_performance','userid',$list['user_id'],'employee_salary_tb');hidden_input($n,'bonus_performance', $bonus_performance);  ?>
                    <?php $bonus_plus = find_2('bonus_plus','userid',$list['user_id'],'employee_salary_tb'); hidden_input($n,'bonus_plus', $bonus_performance); ?>
                    <?php hidden_input($n,'bonus_massa', $bonus_massa_cost);?>
                    
                    <?php $sim_a = find_2('sim_a','userid',$list['user_id'],'employee_salary_tb');hidden_input($n,'sim_a', $sim_a); ?>
                    <?php  $sim_c = find_2('sim_c','userid',$list['user_id'],'employee_salary_tb') ;hidden_input($n,'sim_c', $sim_c);?>
                    <?php  $bonus_skill = find_2('bonus_skill','userid',$list['user_id'],'employee_salary_tb') ;hidden_input($n,'bonus_skill', $bonus_skill);?>
                    <?php  $list['working_day'];hidden_input($n,'working_day', $list['working_day']);?>
                    <?php  $list['absent'];hidden_input($n,'absent', $list['absent']);?>
                    <?php  $list['late'];hidden_input($n,'late', $list['late']);?>
                    <?php  hidden_input($n,'cicilan', 0);?>
                    <td align="center"><?php echo $list['late']?></td>
                    <td align="center">
                    	<?php  echo currency($late_cost = $list['late']*10000);hidden_input($n,'late_cost', $late_cost);?>
                    </td>
                    
						<?php $pph21 = find_2('pph21','userid',$list['user_id'],'employee_salary_tb');hidden_input($n,'pph21', $pph21);?>
                    <td align="center"><?php echo currency($list['over_payment']);hidden_input($n,'over_payment', $list['over_payment']);?></td>
                    <td align="center"><?php echo currency($list['under_payment']);hidden_input($n,'under_payment', $list['under_payment']);?></td>
                    <td align="center">
						<?php $meeting_cost = $list['meeting_absence'];
						echo currency($meeting_cost);
						hidden_input($n,'meeting_cost', $meeting_cost); ?></td>
                    
						<?php $insurance = find_2('insurance','userid',$list['user_id'],'employee_salary_tb');
						//echo currency($insurance);
						hidden_input($n,'insurance', $insurance);?>
                   	
                    <td align="center"><?php echo currency($list['debt']);?></td>
                    <td align="center"><?php echo currency($list['paid']);?></td>
                    <?php hidden_input($n,'debt', $list['debt']);
					hidden_input($n,'paid', $list['paid']);?>
                </tr>
                
        <?php $n++;
				}?>
                <input type="hidden" id="active_day" name="active_day" value="<?php  echo $active_day ?>"/></td>
                <input type="hidden" id="qty" name="qty" value="<?php echo $n ?>" />
                <input type="hidden" id="periode_from" name="periode_from" value="<?php echo $periode_from ?>" />
                <input type="hidden" id="periode_to" name="periode_to" value="<?php echo $periode_to ?>" />
    </tbody>
</table>

</form>