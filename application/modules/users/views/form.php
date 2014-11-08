<?php 
    $opProfile = array();
    $opProfile[""] = lang("default_select");
    foreach ($profiles as $aProfile){
        if ($aProfile->getId() != AuthConstants::ID_PROFILE_USER){
            $opProfile[$aProfile->getId()] = $aProfile->getName();
        }
    }

    $opLang = array();
    $opLang[""] = lang("default_select");
    foreach ($languages as $aLanguage){
        $opLang[$aLanguage] = lang($aLanguage);
    }
    
    $fields = array();
    $fields[lang('language')] = form_dropdown("language", $opLang, $language, "class='span4'");
    $fields[lang('profile')] = form_dropdown("idProfile", $opProfile, $idProfile, "class='span4'");
    $fields[lang('name')] = form_input(array('name'=>'name', 'class'=>'span4', 'value'=>$name));
    $fields[lang('last_name')] = form_input(array('name'=>'lastName', 'class'=>'span4', 'value'=>$last_name));
    $fields[lang('email')] = form_input(array('name'=>'email', 'class'=>'span4', 'value'=>$email));
    $fields[lang('password')] = form_password(array('name'=>'password', 'class'=>'span4'));
    $hidden = array('id' => $id);
    echo print_form('/users/persist/', $fields, $hidden);