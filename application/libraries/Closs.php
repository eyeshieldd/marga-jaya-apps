<?php

/*
 * By : Praditya Kurniawan
 * website : http://masiyak.com
 * email : aku@masiyak.com
 *
 * - CIRCLE LABS -
 * http://circlelabs.id
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');
use OSS\OssClient;
use OSS\Core\OssException;

class Closs
{
	// variabel nama bucket
	var $bucket;

	// var akses key ID
	var $access_id;

	//var access key pass
	var $access_secret;

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @param    string $var
	 *
	 * @return    mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	public function __construct($parameter = null)
    {
      // load config
      $this->load->config('oss_config');

    }

    // override bucket
    public function set_bucket(){

    }

    /*
    	Parameter : 
    		- filename -> nama file yang akan dibuat di object storage.  garis miring (/) akan menghasilkan folder
    		- source -> sumber file yang akan di upload ke object storage.  Tulis sampai file ekstensinya.
    */
    public function upload_file($filename = NULL, $source = NULL){
    	if(empty($filename) || empty($source))
    		return FALSE;

    	$ossClient = new OssClient(
    		$this->config->item('oss_access_id'), 
    		$this->config->item('oss_access_secret'), 
    		$this->config->item('oss_endpoint')
    	);

    	// try {
    	// 	$ossClient->uploadFile($this->config->item('oss_bucket'), $filename, $source);
    	// 	return
    	// } catch (Exception $e) {
    		
    	// }

    	return $ossClient->uploadFile($this->config->item('oss_bucket'), $filename, $source);
    }

    /*
        Parameter : 
            - filename -> nama file yang akan dihapus.  garis miring (/) akan menghasilkan folder
    */
    public function delete_file($filename = NULL){
        if(empty($filename) || empty($source))
            return FALSE;

        $ossClient = new OssClient(
            $this->config->item('oss_access_id'), 
            $this->config->item('oss_access_secret'), 
            $this->config->item('oss_endpoint')
        );

        return $ossClient->deleteObject($this->config->item('oss_bucket'), $filename);
    }

    /*
		parameter :
			- Object name : nama object yang akan diambil urlnya
			- timeout : masa berlaku url.  default 3600 detik (1 jam)
    */
    public function get_file_url($object_name, $timeout = 3600, $image_processing = null){
        // get opbject client
    	$ossClient = new OssClient(
    		$this->config->item('oss_access_id'), 
    		$this->config->item('oss_access_secret'), 
    		$this->config->item('oss_endpoint')
    	);

        // set options if available image processing parameter
        if(!empty($image_processing)){
            $options = array(OssClient::OSS_PROCESS => $image_processing);
        }

        if(!empty($image_processing)){
            return $ossClient->signUrl($this->config->item('oss_bucket'), $object_name, 3600, "GET", $options);
        } else {
            return $ossClient->signUrl($this->config->item('oss_bucket'), $object_name, 3600);
        }

        return $url;
    }

    public function get_file_url_img_process($object_name, $timeout = 3600){
        $ossClient = new OssClient(
            $this->config->item('oss_access_id'), 
            $this->config->item('oss_access_secret'), 
            $this->config->item('oss_endpoint')
        );
        $options = array(OssClient::OSS_PROCESS => "image/resize,m_lfit,h_100,w_100" );
        $url = $ossClient->signUrl($this->config->item('oss_bucket'), $object_name, 3600, "GET", $options);

        return $url;
    }

}
