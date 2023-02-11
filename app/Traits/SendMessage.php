<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;



trait SendMessage {
    use MessagesType;

    

    public function send_greetings_message()
    {
       
        $text = <<<MSG
        Welcome to Ask HSE Chatbot. Please send your Email & ID for verification.
        MSG;
        $this->makeUserLogin();
        $this->send_post_curl($this->make_text_message($text));
        $this->continue_session_step();

    }

  
   
   

   

    

    public function send_text_message($text,$to="")
    {
        if($to =="")
        {
            $to = $this->userphone;
        }
        $this->send_post_curl($this->make_text_message($to,$text));
        return response("",200);

    }

    public function send_media_message($type,$file_url,$caption=null)
    {
        switch ($type) {
            case 'video':
                $this->send_post_curl($this->make_video_message($this->userphone,$file_url,$caption));
                break;
            case 'image':
                $this->send_post_curl($this->make_image_message($this->userphone,$file_url,$caption));
                break;
            case 'document':
                $this->send_post_curl($this->make_document_message($this->userphone,$file_url,$caption));
                break;
            default:
                $this->send_text_message("An Error Occured with the media file! support will be notified");
                die;
                break;
        }

        return true;

    }



    public function send_post_curl($post_data)
    {
        $token = env("WB_TOKEN");
        $url = env("WB_MESSAGE_URL");

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Bearer {$token}"
        ),
        ));

        $response = curl_exec($curl);
        echo $response;

        // curl_close($curl);

    }
}