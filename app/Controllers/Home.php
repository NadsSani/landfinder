<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\Message;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\landlisttableModel;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

//==============================================

	public function checkingversion(){
		$request = \Config\Services::request();
		  $key = $request->getHeader('key');
		  $mykey = $key->getValue('Key');
		  if( $mykey == license)
		  {
			$versioncode = intval($request->getVar('versioncode'));
			if ($versioncode < 2 ){
			  $resultarray['status'] = false;
			  return $this->response->setJson($resultarray);
			}
			else{
			  $resultarray['status'] = true;
			  return $this->response->setJson($resultarray);
			}
		  }
	  }
	  //===============================================================
  public function googlelogin(){
		$request = \Config\Services::request();
		//$message = new \CodeIgniter\HTTP\Message();
		require_once APPPATH.'../../vendor/autoload.php';
		$key = $request->getHeader('key');
		$mykey = $key->getValue('Key');
		if( $mykey == license)
		{
		  $db = \Config\Database::connect();
		  $used = $request->getJson(true);
		  $idtoken = $request->getVar('idtoken');
		  
		 $CLIENT_ID = "234663695432-c2iv4h6hhop9d3rc6ei42cpvlksfi7np.apps.googleusercontent.com";
		  // Get $id_token via HTTPS POST.
		  
		  $client = new \Google_Client(['client_id' => $CLIENT_ID]); 
		   // Specify the CLIENT_ID of the app that accesses the backend
		  $payload = $client->verifyIdToken($idtoken);
		  if ($payload) {
			$userid = $payload['sub'];
			$emailid = $payload['email'];
			$sql = "SELECT * FROM highconfuser WHERE userid = '$userid' and emailid = '$emailid'";
			$resulted = $db->query($sql);
			if (sizeof($resulted->getResult()) > 0){
			  foreach($resulted->getResult() as $row){
			  $resultarray = array('datavaluedlogin'=>$row);
			  $resultarray['status'] = true;
			  $resultarray['userid'] = $userid;
			  $resultarray['emailid'] = $emailid;
			  $resultarray['username'] = $row->username;
			  return $this->response->setJson($resultarray);  
			}
	  
			}
			else{
			  $resultarray = array('datavaluedlogin'=>null);
			  $resultarray['status'] = false;
			  $resultarray['userid'] = $userid;
			  $resultarray['emailid'] = $emailid;
			  $resultarray['username'] = null;
			  return $this->response->setJson($resultarray);  
	  
			}
			// If request specified a G Suite domain:
			//$domain = $payload['hd'];
		  } else {
			
			$resultarray = array('datavaluedlogin'=>null);
			$resultarray['status'] = false;
			$resultarray['username'] = null;
			$resultarray['emailid'] = null;
			$resultarray['userid'] = null;  
			return $this->response->setJson($resultarray);  
	  
	  
		  }
		  
		
		}
	  }
//=========================================================================
  public function getlandlists(){
      $pager = \Config\Services::pager();
     $db = \Config\Database::connect();
      
         $response =  \Config\Services::response(); 
         $request = \Config\Services::request();
          $key = $request->getHeader('key');
          $mykey = $key->getValue('Key');
    if($mykey == license){
     
       
      $pagenumber = $request->getVar('pagenumber');
      $id = $request->getVar('id');
      $placename = $request->getVar('placename');
      $village = $request->getVar('village');
      $hbtaluk = $request->getVar('hbtaluk');
      $propertiesland=$request->getVar('propertiesland');
      $otherspec=$request->getVar('otherspec');
      $landtype=$request->getVar('landtype');
      $price = $request->getVar('price');
      $sql = "SELECT * FROM landlisttable";
      $query = $db->query($sql);
    if (sizeof($query->getResult()) > 0){
     $sizearray = ceil(sizeof($query->getResult())/5);
      $addedarray = array(); 
      
      $model = new landlisttableModel();
     $users = $model->paginate(5,'landlisttable',$pagenumber);
       
    
    
      
        
        $resultarray['datavalues'] = $users;
        $resultarray['status'] = true;
        $resultarray['totalpages'] = $sizearray;
        $resultarray['total'] = sizeof($query->getResult());
        $resultarray['perpage'] = 5;
        if($pagenumber+1 <= $sizearray){
        $resultarray['nextpage']= $pagenumber+1;
      }else{
      $resultarray['nextpage']= null;
      }
      if($pagenumber-1 > 0 ){
       $resultarray['previouspage'] = $pagenumber-1;
      }else{
        $resultarray['previouspage'] = null;
      }
       return $this->response->setJSON($resultarray);
    }else{
      $resultarray = array('datavalues'=>null);
      $resultarray['status'] = false;
      // return $this->response->setJSON($resultarray);
    
    }

  }

    }

  //--------------------------------------------------------------------
public function getland(){

  $db = \Config\Database::connect();
  $response =  \Config\Services::response();
  $request = \Config\Services::request();
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  $addedarray = array();  
if($mykey == license){ 
  $userid = $request->getVar('id');

   


  $sql = "SELECT * FROM landlisttable WHERE id = '$userid'";
  $resulted = $db->query($sql);
  if (sizeof($resulted->getResult()) > 0){
    
    foreach($resulted->getResult() as $row){
          
      array_push($addedarray,$row);


    }

    $resultarray = array('datavalues'=>$addedarray);
    $resultarray['status'] = true;
    return $this->response->setJSON($resultarray);


  }else{

    $resultarray = array('datavalues'=>null);
    $resultarray['status'] = false;
    return $this->response->setJSON($resultarray);


  }

}

}

//===========================================================================

public function addlandlist(){
    
 $request = \Config\Services::request();
$response =  \Config\Services::response();
$db = \Config\Database::connect();
$key = $request->getHeader('key');
$mykey = $key->getValue('Key');
if( $mykey == license)
{ 
 $username = $request->getVar('username');
   $resultarray = array('datavalues'=>null);
     $resultarray['status'] = true;
     return $this->response->setJson($resultarray);

    

 }

 }


//============================================================================
public function signup(){

 $request = \Config\Services::request();
$response =  \Config\Services::response();
$db = \Config\Database::connect();
$key = $request->getHeader('key');
$mykey = $key->getValue('Key');
if( $mykey == license)
{
 $username = $request->getVar('username');
   $resultarray = array('datavalues'=>null);
     $resultarray['status'] = true;
     return $this->response->setJson($resultarray);



 }

 }

//===============================================================================
public function login(){

 $request = \Config\Services::request();
$response =  \Config\Services::response();
$db = \Config\Database::connect();
$key = $request->getHeader('key');
$mykey = $key->getValue('Key');
if( $mykey == license)
{
 $username = $request->getVar('username');
   $resultarray = array('datavalues'=>null);
     $resultarray['status'] = true;
     return $this->response->setJson($resultarray);



 }

 }
//================================================================================
public function otp(){

 $request = \Config\Services::request();
$response =  \Config\Services::response();
$db = \Config\Database::connect();
$key = $request->getHeader('key');
$mykey = $key->getValue('Key');
if( $mykey == license)
{
 $username = $request->getVar('username');
   $resultarray = array('datavalues'=>null);
     $resultarray['status'] = true;
     return $this->response->setJson($resultarray);



 }

 }
//=================================================================================
}
