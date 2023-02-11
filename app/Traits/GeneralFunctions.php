<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait GeneralFunctions
{



    public function go_to_next_step($value="")
    {
        $session = $this->user_session_data;
        $current_step_count = $session['current_step'];
        $current_step_count += 1;
        $this->user_session_data['current_step']=$current_step_count;
        $this->update_session($this->user_session_data);
        

    }

    public function go_to_previous_step($value="")
    {
        $session = $this->user_session_data;
        $current_step_count = $session['current_step'];
        $current_step_count -= 1;
        $this->user_session_data['current_step']=$current_step_count;
        $this->update_session($this->user_session_data);

    }

    public function ask_user($value="")
    {
     $message = $this->make_text_message($value);
     $this->send_post_curl($message);
     $this->go_to_next_step();
     die;

    }
    public function say_to_user($value="")
    {
     $message = $this->make_text_message($value);
     $this->send_post_curl($message);
     $this->go_to_next_step();

    }

    public function store_answer($value="")
    {
      
        $session = $this->user_session_data;
        $answered_question = $session['answered_questions'];
        $user_response = $this->user_message_original;
        $key = $value['store_as'];
        $this->user_session_data['answered_questions'][$key]=$user_response;
        $this->update_session($this->user_session_data);
        $this->go_to_next_step();
        $this->continue_session_step();

    }

    public function check_login_credentials($value="")
    {
        $users = Config::get("sample_logins");
        $session = $this->user_session_data;
        $answered_question = $session['answered_questions'];
        $email = $answered_question['email'];
        $login_id = $answered_question['login_id'];
        if(key_exists($email,$users))
        {
            $user_login_id = $users[$email];
            if($user_login_id == $login_id)
            {
                
                $this->log_last_operation("true");
                $this->go_to_next_step();
                $this->continue_session_step();

            }else{
                $this->log_last_operation("false");
                $this->go_to_next_step();
                $this->continue_session_step();
            }
        }else{
            $this->log_last_operation("false");
            $this->go_to_next_step();
            $this->continue_session_step();
        }
    }

    public function log_last_operation($value="")
    {
        $this->user_session_data['last_operation_status'] = $value;
        $this->update_session($this->user_session_data);
    }

     public function check_last_operation($value="")
    {
        $check_for = $value['check_for'];
        $last_operation =$this->user_session_data['last_operation_status'];
        if($check_for == $last_operation)
        {
            $follow_up_action = $value['follow_up']['action_type'];
            $follow_up_action_value = $value['follow_up']['value'];

            $this->$follow_up_action($follow_up_action_value);
            $this->continue_session_step();
        }else{
                $alternate_action = $value['else']['action_type'];
                $alternate_action_value = $value['else']['value'];
                $this->$alternate_action($alternate_action_value);
                $this->continue_session_step();
        }


    }

    public function restart_this_steps($value="")
    {
        
        $session = $this->user_session_data;
        $this->say_to_user($value);   
        $this->user_session_data['current_step']=0;
        $this->update_session($this->user_session_data);
        $this->continue_session_step();

    }
    // public function load_new_action_session($value="")
    // {


    // }
   
    public function send_interactive_menu($value="")
    {
        $menu_list = Config::get("interactive_menu.".$value);
        $menu_text = Config::get("interactive_menu_text.".$value);
       
        $menu_message = $this->make_menu_message($menu_list,$this->userphone,$menu_text);
        $this->send_post_curl($menu_message);
        die;

    }

    

}