<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Product extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('product_model');
	}
	
	function index(){
		redirect('home');
	}
	
	//////////
	//brand//
	/////////
	function list_brand(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_brand","privilege_tb")){
			$this->data['page'] = 'product/list_brand';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function brand_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="brand_tb";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_brand","privilege_tb")){
				$delete = " | <a href=\"".site_url('product/delete_brand/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_brand","privilege_tb")){
				$json .= "'<a href=\"".site_url('product/edit_brand/'.$row['id'])."\">Edit</a>".$delete."'";
			 }else{
				 $json .= "'".$delete."'";
			 }
			
			$json .= ",'".esc($row['name'])."'";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_brand","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('product/active_brand/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('product/active_brand/'.$row['id'].'/'.$row['active'])."\">no</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'yes'";
				}else{
					$json .= ",'no'";
				}
			}
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
	
	function add_brand(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_brand","privilege_tb")){
			$this->data['page'] = 'product/add_brand';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_brand(){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->product_model->do_add_brand($name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_brand($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_brand","privilege_tb")){
			$this->data['brand'] = $this->product_model->show_brand_by_id($id);
			$this->data['page'] = 'product/edit_brand';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_brand($id){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->product_model->do_edit_brand($id,$name,$active);
		redirect('product/list_brand');
	}
	
	function delete_brand($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_brand","privilege_tb")){
			$this->product_model->delete_brand($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function active_brand($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_brand","privilege_tb")){
			if($active==0){
				$active = 1;	
			}else{
				$active = 0;	
			}
			
			$this->product_model->active_brand($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	/////////////
	//category//
	////////////
	function list_category(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_category","privilege_tb")){
			$this->data['page'] = 'product/list_category';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');	
		}
	}
	
	function category_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'brand_id,name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="category_tb";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_category","privilege_tb")){
				$delete = " | <a href=\"".site_url('product/delete_category/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_category","privilege_tb")){
				$json .= "'<a href=\"".site_url('product/edit_category/'.$row['id'])."\">Edit</a>".$delete."'";
			 }else{
				$json .= "'".$delete."'";
			 }
			
			$json .= ",'".find('name',esc($row['brand_id']),'brand_tb')."'";
			$json .= ",'".esc($row['name'])."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_category","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('product/active_category/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('product/active_category/'.$row['id'].'/'.$row['active'])."\">no</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'yes'";
				}else{
					$json .= ",'no'";
				}
			}
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function add_category(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_category","privilege_tb")){
			$this->data['brand'] = $this->product_model->show_brand();
			$this->data['page'] = 'product/add_category';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_category(){
		$brand_id = $this->input->post('brand_id');
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->product_model->do_add_category($brand_id,$name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_category($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_category","privilege_tb")){
			$this->data['brand'] = $this->product_model->show_brand();
			$this->data['category'] = $this->product_model->show_category_by_id($id);
			$this->data['page'] = 'product/edit_category';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_category($id){
		$brand_id = $this->input->post('brand_id');
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->product_model->do_edit_category($id,$brand_id,$name,$active);
		redirect('product/list_category');
	}
	
	function delete_category($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_category","privilege_tb")){
			$this->product_model->delete_category($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function active_category($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_category","privilege_tb")){
			if($active==0){
				$active = 1;	
			}else{
				$active = 0;	
			}
			
			$this->product_model->active_category($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');
		}
	}
	///////////
	//product//
	//////////
	function list_product(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_product","privilege_tb")){
		$this->data['page'] = 'product/list_product';
		$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function product_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "where type = 0";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="product_tb";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_product","privilege_tb")){
				$delete = " | <a href=\"".site_url('product/delete_product/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_product","privilege_tb")){
				$json .= "'<a href=\"".site_url('product/edit_product/'.$row['id'])."\">Edit</a>".$delete."'";
			 }else{
				 $json .= "'".$delete."'";
			 }
			if($row['category_id']!=0){
				$json .= ",'".find('name',esc($row['category_id']),'category_tb')."'";
			}else{
				$json .= ",'-'";
			}
			$json .= ",'".esc($row['name'])."'";
			$json .= ",'".esc($row['number'])."'";
			$json .= ",'".money(esc($row['price']))."'";
			$json .= ",'$ ".currency(esc($row['price_2']))."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_product","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('product/active/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('product/active/'.$row['id'].'/'.$row['active'])."\">no</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'yes'";
				}else{
					$json .= ",'no'";
				}

			}
			$json .= ",'".esc($row['description'])."'";
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function accessories_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "where type = 1";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="product_tb";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_product","privilege_tb")){
				$delete = " | <a href=\"".site_url('product/delete_product/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_product","privilege_tb")){
				$json .= "'<a href=\"".site_url('product/edit_product/'.$row['id'])."\">Edit</a>".$delete."'";
			 }else{
				 $json .= "'".$delete."'";
			 }
			
			$json .= ",'".esc($row['name'])."'";
			$json .= ",'".esc($row['number'])."'";
			$json .= ",'".money(esc($row['price']))."'";
			$json .= ",'".currency(esc($row['price_2']))."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_product","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('product/active/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('product/active/'.$row['id'].'/'.$row['active'])."\">no</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'yes'";
				}else{
					$json .= ",'no'";
				}
			}
			$json .= ",'".esc($row['description'])."'";
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function add_product(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_product","privilege_tb")){
			$this->data['category'] = $this->product_model->show_category();
			$this->data['page'] = 'product/add_product';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}	
	
	function do_add_product(){
		$category_id = $this->input->post('category_id');
		$name = $this->input->post('name');
		$number = $this->input->post('number');
		$description = $this->input->post('description');
		$price = $this->input->post('price');
		$price_2 = $this->input->post('price_2');
		
		$currency = $this->product_model->show_currency();
		$kurs = $currency['idr'];
		
		if($price==0 && $price_2 != 0){
			$price = $price_2 * $kurs;	
		}
		
		$active = $this->input->post('active');
		$type = $this->input->post('type');
		
		$this->product_model->do_add_product($category_id,$name,$number,$description,$price,$price_2,$active,$type);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function edit_product($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_product","privilege_tb")){
			$this->data['category'] = $this->product_model->show_category();
			$this->data['product'] = $this->product_model->show_product_by_id($id);
			$this->data['page'] = 'product/edit_product';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_product($id){
		$category_id = $this->input->post('category_id');
		$name = $this->input->post('name');
		$number = $this->input->post('number');
		$description = $this->input->post('description');
		
		$price = $this->input->post('price');
		$price_2 = $this->input->post('price_2');
		
		$currency = $this->product_model->show_currency();
		$kurs = $currency['idr'];
		
		if($price==0 && $price_2 != 0){
			$price = $price_2 * $kurs;	
		}
		
		$active = $this->input->post('active');
		$type = $this->input->post('type');
		
		$this->product_model->do_edit_product($id,$category_id,$name,$number,$description,$price,$price_2,$active,$type);
		
		redirect('product/list_product');
	}
	
	function active($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/edit_product","privilege_tb")){
			if($active == 1){
				$active = 0;	
			}else{
				$active = 1;	
			}
			$this->product_model->active($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function delete_product($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/delete_product","privilege_tb")){
			$this->product_model->delete_product($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
}?>