<?php

class TranslateController extends Controller
{
    public function edit($params)
    {
        extract($params);

        if($this->member != NULL)
        {
            $memberManager = new MemberManager();
            $this->member->set_locale($lang);
            $memberManager->edit($this->member);
            $_SESSION['member'] = serialize($this->member);
        }
    }
}