<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {
private $data;
public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library(array('layout'));
		date_default_timezone_set('Asia/Jakarta');
	}
	// Facebook
    public function get_json_fb_feed($id){
        if($id){
            $app_token='115164246951342';
            $us_token='EAAORZA0oKr8IBAC3pxXa6bB8AMQLFt8ZBSNciVxYtrzt9bp4ZBP6SbTHKNuYqIuLY7YI25QtuoiigN39tPpBDEjESFZAMvT2lXC6QCDrv1EWUolqVlluswIYF6Tcfs9x1ZAog9ZBAuhUmFcsSbZB884rL56ZAxfgxziZBuh3U0NAGGusHxzXAH2vw2G3MTZBozlf9ZAVXs73TpZBvrr4dgUWUDCWl71SxxnxJO2gEznRp6Ef3gZDZD';

            $link = 'https://graph.facebook.com/v6.0/me';
        
            $nilai1="feed?fields=description%2Cpicture%2Clink%2Cshares%2Ccreated_time&limit=10&";
            $url= $link."/".$nilai1."access_token=".$us_token;

            $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);
                echo json_encode($response);
            }
	}
    public function get_json_fb_story($id){
        if($id){
            $app_token='115164246951342';
            $us_token='EAAORZA0oKr8IBAC3pxXa6bB8AMQLFt8ZBSNciVxYtrzt9bp4ZBP6SbTHKNuYqIuLY7YI25QtuoiigN39tPpBDEjESFZAMvT2lXC6QCDrv1EWUolqVlluswIYF6Tcfs9x1ZAog9ZBAuhUmFcsSbZB884rL56ZAxfgxziZBuh3U0NAGGusHxzXAH2vw2G3MTZBozlf9ZAVXs73TpZBvrr4dgUWUDCWl71SxxnxJO2gEznRp6Ef3gZDZD';

            $link = 'https://api.facebook.com/v6.0/me';
        
            $nilai1="feed?fields=description%2Cpicture%2Clink%2Cshares%2Ccreated_time&limit=10&";
            $url= $link."/".$nilai1."access_token=".$us_token;

            $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);
                echo json_encode($response);
            }
	}
	
	// Instagram
	public function get_json_ig_feed($id){
        if($id){
            $app_token='1066881707059210';
            $us_token='EAAPKUsEqqAoBAPnXWBGV7CgYRTk1bZAMO64zZBhk7kR1SZBvkTz2s2sdL3mm48Dx499RxeZBCstdJtOvlKrNrJXOcZAaTZCfzJNao3qpr5rGyZB0ttUfZAv2OUW28fZAscbVCOLnoXUs5DfPUUCjlDZB9OWX9en1p2pER01CH1ZANuopmi6zH6W333LkXTcyzsabCgZD';

            $link = 'https://graph.facebook.com/v9.0/';
        
            $nilai1="me?";
            $url= $link."/".$nilai1."&access_token=".$us_token;

            $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);
                echo json_encode($response);
            }
	}
	// Instagram
    public function get_json_ig_story($id){
        if($id){
            $app_token='1066881707059210';
            $us_token='EAAPKUsEqqAoBAEhMrKOeA9w86fsOdFtOHiUryL7eOUch8HepAMn220dClfbtotCQ3ZBcxVy6cpZAGhiPwQilbRbnEisMMwFrCpC96NpoYX26Sdl6VqvbF8AyZBOsIAmFZAUxNcA9U9awBKDCuBnIrnafHdZAA1Jgr245kxlht5wP6QgLgXJxhxwbt28JGugkAgEIZCkKtnJJTOeZAliZBoEvOtotxpZCDM4qjZB747CcJmXgZDZD';

            $link = 'https://api.instagram.com/v6.0/me';
        
            $nilai1="feed?fields=description%2Cpicture%2Clink%2Cshares%2Ccreated_time&limit=10&";
            $url= $link."/".$nilai1."access_token=".$us_token;

            $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);
                echo json_encode($response);
            }
    }
}