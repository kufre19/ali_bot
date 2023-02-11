<?php

namespace App\Traits;


trait CreateActionsSession
{

    use HandleSession;


    public function makeUserLogin()
    {
        $session_data = [
            "step_name"=>"makeUserLogin",
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
            "steps" => [
                ["action_type"=>"ask_user","value"=>"Please send me your email"],
                ["action_type"=>"store_answer","value"=>["aked"=>"email","store_as"=>"email"]],
                ["action_type"=>"ask_user","value"=>"Please send me your login ID"],
                ["action_type"=>"store_answer","value"=>["aked"=>"login id","store_as"=>"login_id"]],
                ["action_type"=>"check_login_credentials","value"=>"Please send me your login ID"],
                ["action_type"=>"check_last_operation","value"=>["check_for"=>"true","follow_up"=>["action_type"=>"go_to_next_step","value"=>""],"else"=>["action_type"=>"restart_this_steps","value"=>"Please make sure the email and ID sent are correct!"]]],
                ["action_type"=>"send_interactive_menu","value"=>"main_menu"],
            ]
        ];

        return $this->update_session($session_data);

    }


    public function MainMenu()
    {
        $session_data = [
            "step_name"=>"MainMenu",
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
            "steps" => [
                ["action_type"=>"send_interactive_menu","value"=>""],
                ["action_type"=>"store_answer","value"=>["aked"=>"email","store_as"=>"email"]],
               
            ]
        ];
    }
}
