<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Survey</title>
</head>

<style>
	table thead th{
		text-align:left;
	}
	
	table tr td{
		vertical-align:top;
	}
	
	.normal{
		font-weight:normal;
	}
	
	.warning{
		color:#F00;
	}
	
	.odd{
		background-color:#CCC;	
	}
</style>

<body>
<?php if(find_4_string('status','survey_number',esc($survey_number),'id',esc($id),'survey_result_tb')==0){?>
<form name="survey_form" id="suvey_form" method="post" action="<?php echo site_url('survey/send_quiz/')?>">
<table border="0" width="100%">
	<thead>
    	<th><img src="<?php echo base_url()?>images/gsi_logo.jpg" /></th>
        <th>
        PT Golden Solution Indonesia<br />
        <span class="normal">
        Kyai Caringin no 1. Jakarta Pusat. 10150<br />
        Tel. (021) 3453373(hunting)  Fax. (021) 3450145<br />
        www.gsindonesia.com
        </span>
        </th>
    </thead>
	<tbody>
    	<?php if(isset($_SESSION['quiz_notif'])){?>
    	<tr>
        	<td colspan="2"><?php echo $_SESSION['quiz_notif']?></td>
        </tr>
        <?php }?>
    	<tr>
        	<td colspan="2">
            	<table border="0" width="100%">
                	<input type="hidden" name="survey_result_id" value="<?php echo $id;?>" />
                	<tr>
                    	<td width="15%">Company</td>
                        <td><textarea name="company" cols="20" rows="1"></textarea><span class="warning">*</span></td>
                    </tr>
                    <tr>
                    	<td>Location</td>
                        <td><textarea name="location" cols="20" rows="1"></textarea><span class="warning">*</span></td>
                    </tr>
                    <tr>
                    	<td>PIC/Penanggung Jawab</td>
                        <td><textarea name="pic" cols="20" rows="1"></textarea><span class="warning">*</span></td>
                    </tr>
                    <tr>
                    	<td>Phone</td>
                        <td><textarea name="phone" cols="20" rows="1"></textarea></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2"><i>*Untuk penilaian dimulai dari angka terendah ( 1 ) sampai dengan angka tertinggi ( 5 )</i></td>
        </tr>
        <tr>
        	<td colspan="2">
            	<table border="0" style="width:70%">
                	<?php if($department_list)foreach($department_list as $list){?>
                        <tr>
                            <td colspan="7"><b><?php echo find('name',$list['department_id'],'department_tb');?></b>
                            <hr size="1" />
                            </td>
                        </tr>
                       	<?php $no =1; if($question_list)foreach($question_list as $list2){
								if($list2['department_id']==$list['department_id']){?>
                                <tr <?php if($no%2==1)echo "class='odd'";?>>
                                	<input type="hidden" name="question_id[]" value="<?php echo $list2['id']?>" />
                                    <input type="hidden" name="department_id<?php echo $list2['id']?>" value="<?php echo $list2['department_id']?>"/>
                                	<td align="right" width="5%"><?php echo $no;?>.</td>
                                    <td width="50%"><?php echo nl2br($list2['question'])?></td>
                                    <?php if($list2['type']==1){?>
                                        <td><input type="radio" name="answer<?php echo $list2['id']?>" value="1" checked="checked" />1</td>
                                        <td><input type="radio" name="answer<?php echo $list2['id']?>" value="2" />2</td>
                                        <td><input type="radio" name="answer<?php echo $list2['id']?>" value="3" />3</td>
                                        <td><input type="radio" name="answer<?php echo $list2['id']?>" value="4" />4</td>
                                        <td><input type="radio" name="answer<?php echo $list2['id']?>" value="5" />5</td>
                                    <?php }else{?>
                                    	<td colspan="5"><input type="text" name="answer<?php echo $list2['id']?>" style="width:400px;" /></td>
                                    <?php }?>
                                </tr>
                        <?php $no++;}
						}?>
                        <tr>
                        	<td colspan="7" style="background-color:#333"></td>
                        </tr>
                    <?php }?>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">Kritik &amp; Saran<br />
            <textarea name="description" cols="50" rows="2"></textarea>
            </td>
        </tr>
        <tr>
        	<td colspan="2"><input type="submit" value="send" /></td>
        </tr>
    </tbody>
</table>
</form>
<?php }else{?>
	<h2>
    	<span class="warning">
        	Your survey has been send.
            <br />
    		We appreciate the time you have spent on providing the feedback.
    		<br />
    		This will definitely help us improve our services
    	</span>
    </h2>
<?php }?>
</body>
</html>