<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Address extends CI_Controller{
	/**
	 *
	 * Dashboard
	 * @author Pankaj
	 */
	public function index(){
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('navbar');
		$this->load->view('footer');
		//$this->load->view('general');
	}
    /**
     * Dashboard for restaurant
     * @author Pankaj
     */
	public function restaurant(){
		$this->load->view('restaurant');
	}
	/**
	 * Dashboard for menu
	 * @author Pankaj
	 */
	public function menu(){
		$this->load->view('menu');
	}
	/**
	 *
	 * get all city name on load.
	 * @author Pankaj
	 */
	public function citylist(){
		$this->load->model('general/city_model','city');
		$result = $this->city->getAllCities();
		$data = array();
		$data['cities'] = $result;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/city',$data);
		$this->load->view('footer');
	}
	/**
	 * Show the page for adding new city
	 * @author Pankaj
	 */
	public function newcity(){
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/newcity');
		$this->load->view('footer');
	}
	/**
	 * Saving the city name entered by user
	 * @param city name
	 * @method post
	 * @return name of city as list
	 * @author Pankaj
	 */
	public function savecity(){
		
		$this->load->model('general/city_model','city');
		
		$this->load->helpers(array('form_helper', 'url_helper'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('city', 'city', 'required');
		$status = 1;
		$data = array();
		
		$param['name'] = $this->input->post('city'); 
		$param['status'] = $status;
		if ($this->form_validation->run() == FALSE)
		{
			$errors['city'] = strip_tags(form_error("city"));
			$data['status'] = 0;
			$data['message'] = $errors;
		    echo json_encode($data);
		    
		} else {
			$data = $this->city->addCity($param);
			echo json_encode($data);
		}
	}
// 	public function form_error($city){
// 		if($city == ''){
// 		$this->form_validation->set_message('username_check', 'The {field} field can not be blank');
//                         return FALSE;
//                 }
//                 else
//                 {
//                         return TRUE;
//                 }
// 	}
	/**
	 * get the city name by id
	 * @param  $id
	 * @access public
	 * @return city name and id
	 * @author Pankaj
	 */
	public function editcity($id){
		$this->load->model('general/city_model','city');
		$data = array();
		$data['edtcity'] =  $this->city->getCityById($id);
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/editcity',$data);
		$this->load->view('footer');
		
	}
	/**
	 * to updtae city name
	 * @param city name, id
	 * @access public
	 * @return the list of updated city name
	 * @author Pankaj
	 */
	public function updatecity(){
		$params['id'] = $this->input->post('cityid');
		$params['name'] = $this->input->post('updatecityname');
		
		$this->load->helpers(array('form_helper', 'url_helper'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('updatecityname', 'city', 'required');
		
		$this->load->model('general/city_model','city');
		
		if ($this->form_validation->run() == FALSE)
		{
			$errors['city'] = "The city field is required.";
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
		
		} else {
		
		echo json_encode($this->city->updateCity($params));
		//$this->citylist();
		}
		
	}
	/**
	 * get all zone name on load.
	 * @author Pankaj
	 */
	public function zonelist(){
		$this->load->model('general/zone_model','zone');
		$result = $this->zone->getAllZones();
		$data = array();
		$data['zones'] = $result;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/zone',$data);
		$this->load->view('footer');
	}
	/**
	 * 
	 * show the page for adding new zone
	 * @author Pankaj
	 */
	public function newzone(){
		$this->load->model('general/city_model','city');
		$drop = $this->city->getAllCities();
		$data = array();
		$data['citydrop'] = $drop;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/newzone',$data);
		$this->load->view('footer');
	}
	/**
	 * saving the zone name
	 * @param city id and zone name
	 * @return void
	 * @access public
	 * @author Pankaj
	 */
	public function savezone(){
		$this->load->model('general/zone_model','zone');
	
		$status = 1;
		$data = array();
		
		
		$this->load->helpers(array('form_helper', 'url_helper'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('zonename', 'zone', 'required');
		$this->form_validation->set_rules('cityid','city','required');
		
		
		$params['city_id'] = $this->input->post('cityid');
		$params['name'] = $this->input->post('zonename');
		$params['status'] = $status;
		
		if ($this->form_validation->run() == FALSE)
		{
			if($params['city_id'] == "" && $params['name'] == ""){
				$errors['city'] = "Please select city.";
				$errors['zone'] = "The zone field is required.";
			}
			if($params['city_id'] == "")
				$errors['city'] = "Please select city.";
			elseif($params['name'] == "")
				$errors['zone'] = "The zone field is required.";
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
		
		}else
			echo json_encode($this->zone->addZone($params));
		
	}
	/**
	 * get the zone name by id
	 * @param  $id
	 * @access public
	 * @return zone name and id
	 * @author Pankaj
	 */
	public function editzone($id){
		$this->load->model('general/zone_model','zone');
		$this->load->model('general/city_model','city');
		$data = array();
		$data['edtzone'] =  $this->zone->getZoneById($id);
		$data['cityname'] = $this->city->getAllCities();
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/editzone',$data);
		$this->load->view('footer');
	
	}
	/**
	 * to updtae zone name
	 * @param zone name, id and city_id
	 * @access public
	 * @return the list of updated zone name
	 * @author Pankaj
	 */
	public function updatezone(){
		$params['id'] = $this->input->post('zoneid');
		$params['city_id'] = $this->input->post('cityid');
		$params['name'] = $this->input->post('updatezonename');
		$this->load->model('general/zone_model','zone');
		
		$data = array();
		
		
		$this->load->helpers(array('form_helper', 'url_helper'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('updatezonename', 'zone', 'required');
		$this->form_validation->set_rules('cityid','city','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			if($params['city_id'] == "" && $params['name'] == ""){
				$errors['city'] = "Please select city.";
				$errors['zone'] = "The zone field is required.";
			}
			if($params['city_id'] == "")
				$errors['city'] = "Please select city.";
			elseif($params['name'] == "")
			$errors['zone'] = "The zone field is required.";
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
		
		}else
			echo json_encode($this->zone->updateZone($params));
		
		//$this->zone->updateZone($params);
		//$this->zonelist();
	
	}
	/**
	 * get all locality name on load.
	 * @author Pankaj
	 */
	public function localitylist(){
		$this->load->model('general/locality_model','locality');
		$result = $this->locality->getAllLocalities();
		$data = array();
		$data['localities'] = $result;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/locality',$data);
		$this->load->view('footer');

	}
	/**
	 * 
	 * adding new locality.
	 * @author Pankaj
	 */
	public function newlocality(){
		$this->load->model('general/zone_model','zone');
		$result = $this->zone->getAllZones();
		$data = array();
		$data['zonedrop'] = $result;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/newlocality',$data);
		$this->load->view('footer');
	}
	/**
	 * saving the locality name
	 * @param zone id and locality name
	 * @return void
	 * @access public
	 * @author Pankaj
	 */
	public function savelocality(){
		$this->load->model('general/locality_model','locality');
		
		$status = 1;
		
		$data = array();
		
		
		$params['zone_id'] = $this->input->post('zoneid');
		$params['name'] = $this->input->post('locality');
		$params['status'] = $status;
		$params['latitude'] = $this->input->post('latitude');
		$params['longitude'] = $this->input->post('longitude');
		
		$this->load->helpers(array('form_helper', 'url_helper'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('locality', 'locality', 'required');
		$this->form_validation->set_rules('latitude', 'latitude', 'required');
		$this->form_validation->set_rules('longitude', 'longitude', 'required');
		$this->form_validation->set_rules('zoneid','zone','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			if($params['zone_id'] == "" && $params['name'] == "" && $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
			$errors['locality'] = strip_tags(form_error("locality"));
			$errors['latitude'] = strip_tags(form_error("latitude"));
			$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if( $params['name'] == "" && $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['locality'] = strip_tags(form_error("locality"));
				$errors['latitude'] = strip_tags(form_error("latitude"));
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if($params['zone_id'] == ""  && $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['latitude'] = strip_tags(form_error("latitude"));
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if($params['zone_id'] == "" && $params['name'] == "" && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("locality"));
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if($params['zone_id'] == "" && $params['name'] == "" && $params['latitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("locality"));
				$errors['latitude'] = strip_tags(form_error("latitude"));
			}
			if($params['zone_id'] == "" && $params['name'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("locality"));
			}
			if($params['zone_id'] == ""  && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if($params['zone_id'] == "" && $params['latitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['latitude'] = strip_tags(form_error("latitude"));
			}
			if( $params['name'] == "" && $params['latitude'] == ""){
				$errors['locality'] = strip_tags(form_error("locality"));
				$errors['latitude'] = strip_tags(form_error("latitude"));
			}
			if( $params['name'] == "" && $params['longitude'] == "" ){
				$errors['locality'] = strip_tags(form_error("locality"));
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if( $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['latitude'] = strip_tags(form_error("latitude"));
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			if($params['zone_id'] == ""){
				$errors['zone'] = "Please select zone";
			}
			if( $params['name'] == "" ){
				$errors['locality'] = strip_tags(form_error("locality"));
			}
			if( $params['latitude'] == "" ){
				$errors['latitude'] = strip_tags(form_error("latitude"));
			}
			if( $params['longitude'] == "" ){
				$errors['longitude'] = strip_tags(form_error("longitude"));
			}
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
		
		} else {
			echo json_encode($this->locality->addLocality($params));
		}
		
		//$this->localitylist();
	}
	/**
	 * get the locality name by id
	 * @param  $id
	 * @access public
	 * @return locality name,latitude,longitude and id
	 * @author Pankaj
	 */
	public function editlocality($id){
		$this->load->model('general/locality_model','locality');
		$this->load->model('general/zone_model','zone');
		$data = array();
		$data['edtlocality'] =  $this->locality->getLocalityById($id);
		$data['zonename'] = $this->zone->getAllZones();
		
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/editlocality',$data);
		$this->load->view('footer');
	
	}
	/**
	 * to updtae locality name
	 * @param locality name, latitude, longitude, id and zone_id
	 * @access public
	 * @return the list of updated locality name
	 * @author Pankaj
	 */
	public function updatelocality(){
		$params['id'] = $this->input->post('localityid');
		$params['zone_id'] = $this->input->post('zoneid');
		$params['name'] = $this->input->post('updatelocalityname');
		$params['latitude'] = $this->input->post('updatelatitude');
		$params['longitude'] = $this->input->post('updatelongitude');
		
		
		$this->load->model('general/locality_model','locality');
		$this->load->helpers(array('form_helper', 'url_helper'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('updatelocalityname', 'locality', 'required');
		$this->form_validation->set_rules('updatelatitude', 'latitude', 'required');
		$this->form_validation->set_rules('updatelongitude', 'longitude', 'required');
		$this->form_validation->set_rules('zoneid','zone','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			if($params['zone_id'] == "" && $params['name'] == "" && $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if( $params['name'] == "" && $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if($params['zone_id'] == ""  && $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if($params['zone_id'] == "" && $params['name'] == "" && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if($params['zone_id'] == "" && $params['name'] == "" && $params['latitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
			}
			if($params['zone_id'] == "" && $params['name'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
			}
			if($params['zone_id'] == ""  && $params['longitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if($params['zone_id'] == "" && $params['latitude'] == "" ){
				$errors['zone'] = "Please select zone";
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
			}
			if( $params['name'] == "" && $params['latitude'] == ""){
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
			}
			if( $params['name'] == "" && $params['longitude'] == "" ){
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if( $params['latitude'] == "" && $params['longitude'] == "" ){
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			if($params['zone_id'] == ""){
				$errors['zone'] = "Please select zone";
			}
			if( $params['name'] == "" ){
				$errors['locality'] = strip_tags(form_error("updatelocalityname"));
			}
			if( $params['latitude'] == "" ){
				$errors['latitude'] = strip_tags(form_error("updatelatitude"));
			}
			if( $params['longitude'] == "" ){
				$errors['longitude'] = strip_tags(form_error("updatelongitude"));
			}
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
		
		} else {
		
		echo json_encode($this->locality->updateLocality($params));
		}
	}
	
	/**
	 *
	 * get all categories name on load.
	 * @author Pankaj
	 */
	public function categorylist(){
		$this->load->model('general/category_model','category');
		$result = $this->category->getAllCategories();
		$data = array();
		$data['categories'] = $result;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/category',$data);
		$this->load->view('footer');
	}
	/**
	 * Show the page for adding new category
	 * @author Pankaj
	 */
	public function newcategory(){
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/newcategory');
		$this->load->view('footer');
	}
	/**
	 * Saving the category name entered by user
	 * @param category name
	 * @method post
	 * @return name of category as list
	 * @author Pankaj
	 */
	public function savecategory(){
	
		$this->load->model('general/category_model','category');
	
		$this->load->helpers(array('form_helper', 'url_helper'));
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');
		$status = 1;
		$data = array();
	
		$param['name'] = $this->input->post('category');
		$param['status'] = $status;
		if ($this->form_validation->run() == FALSE)
		{
			$errors['category'] = strip_tags(form_error("category"));
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
	
		} else {
			$data = $this->category->addCategory($param);
			echo json_encode($data);
		}
	}
	/**
	 * get the category name by id
	 * @param  $id
	 * @access public
	 * @return category name and id
	 * @author Pankaj
	 */
	public function editcategory($id){
		$this->load->model('general/category_model','category');
		$data = array();
		$data['edtcategory'] =  $this->category->getCategoryById($id);
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/editcategory',$data);
		$this->load->view('footer');
	
	}
	/**
	 * to updtae category name
	 * @param category name, id
	 * @access public
	 * @return the list of updated category name
	 * @author Pankaj
	 */
	public function updatecategory(){
		$params['id'] = $this->input->post('categoryid');
		$params['name'] = $this->input->post('updatecategoryname');
	
		$this->load->helpers(array('form_helper', 'url_helper'));
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('updatecategoryname', 'category', 'required');
	
		$this->load->model('general/category_model','category');
	
		if ($this->form_validation->run() == FALSE)
		{
			$errors['category'] = "The category field is required.";
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
	
		} else {
	
			echo json_encode($this->category->updateCategory($params));
			//$this->citylist();
		}
	
	}
	
	/**
	 * get all menu item name on load.
	 * @author Pankaj
	 */
	public function menuitemlist(){
		$this->load->model('general/menu_item_model','menuitem');
		$result = $this->menuitem->getAllMenuItems();
		$data = array();
		$data['menuitems'] = $result;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/menuitem',$data);
		$this->load->view('footer');
	}
	/**
	 *
	 * show the page for adding new menu item
	 * @author Pankaj
	 */
	public function newmenuitem(){
		$this->load->model('general/category_model','category');
		$drop = $this->category->getAllCategories();
		$data = array();
		$data['categorydrop'] = $drop;
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/newmenuitem',$data);
		$this->load->view('footer');
	}
	/**
	 * saving the menu item name
	 * @param category id and menu item name
	 * @return void
	 * @access public
	 * @author Pankaj
	 */
	public function savemenuitem(){
		$this->load->model('general/menu_item_model','menuitem');
	
		$status = 1;
		$data = array();
	
	
		$this->load->helpers(array('form_helper', 'url_helper'));
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('menuitemname', 'menu item', 'required');
		$this->form_validation->set_rules('category-name','category','required');
		$this->form_validation->set_rules('price','price','required');
	
		$params['catid'] = $this->input->post('category-name');
		$params['name'] = $this->input->post('menuitemname');
		$params['price'] = $this->input->post('price');
		$params['due'] = $this->input->post('due');
		$params['status'] = $status;
	
		if ($this->form_validation->run() == FALSE)
		{
			if($params['catid'] == "" && $params['name'] == "" && $params['price'] == ""){
				$errors['category'] = "Please select category.";
				$errors['menuitem'] = "The menu item field is required.";
				$errors['price'] = "Please enter the price for the menu item";
			}
			if($params['catid'] == "" && $params['name'] == ""){
				$errors['category'] = "Please select category.";
				$errors['menuitem'] = "The menu item field is required.";
			}
			if($params['catid'] == "" && $params['price'] == ""){
				$errors['category'] = "Please select category.";
				$errors['price'] = "Please enter the price for the menu item";
			}
			if( $params['name'] == "" && $params['price'] == ""){
				$errors['menuitem'] = "The menu item field is required.";
				$errors['price'] = "Please enter the price for the menu item";
			}
			if($params['catid'] == "")
				$errors['category'] = "Please select category.";
			if($params['name'] == "")
				$errors['menuitem'] = "The menu item field is required.";
			elseif($params['price'] == "")
				$errors['price'] = "Please enter the price for the menu item";
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
	
		}else
			echo json_encode($this->menuitem->addMenuItem($params));
	
	}
	/**
	 * get the menu item name by id
	 * @param  $id
	 * @access public
	 * @return menu item name and id
	 * @author Pankaj
	 */
	public function editmenuitem($id){
		$this->load->model('general/menu_item_model','menuitem');
		$this->load->model('general/category_model','category');
		$data = array();
		$data['edtmenuitem'] =  $this->menuitem->getMenuItemById($id);
		$data['categoryname'] = $this->category->getAllCategories();
		$this->load->view('header');
		$this->load->view('leftnav');
		$this->load->view('general/editmenuitem',$data);
		$this->load->view('footer');
	
	}
	/**
	 * to updtae menu item name
	 * @param menu item name, id and categoryid
	 * @access public
	 * @return the list of updated menu item name
	 * @author Pankaj
	 */
	public function updatemenuitem(){
		$params['id'] = $this->input->post('menuitemid');
		$params['catid'] = $this->input->post('updatecategoryid');
		$params['name'] = $this->input->post('updatemenuitemname');
		$params['price'] = $this->input->post('updatemenuitemprice');
		$params['due'] = $this->input->post('updatemenuitemdue');
		$this->load->model('general/menu_item_model','menuitem');
		$data = array();
	
	
		$this->load->helpers(array('form_helper', 'url_helper'));
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('updatemenuitemname', 'menu item', 'required');
		$this->form_validation->set_rules('updatecategoryid','category','required');
		$this->form_validation->set_rules('updatemenuitemprice','price','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			if($params['catid'] == "" && $params['name'] == ""){
				$errors['category'] = "Please select category.";
				$errors['menuitem'] = "The menu item field is required.";
			}
			if($params['catid'] == "")
				$errors['category'] = "Please select category.";
			elseif($params['name'] == "")
			$errors['menuitem'] = "The menu item field is required.";
			$data['status'] = 0;
			$data['message'] = $errors;
			echo json_encode($data);
	
		}else
			echo json_encode($this->menuitem->updateMenuItem($params));
	
		//$this->zone->updateZone($params);
		//$this->zonelist();
	
	}
}

?>