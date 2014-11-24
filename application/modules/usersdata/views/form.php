<?php 
    $opLanguages = array();
    $opLanguages[""] = lang("default_select");
    foreach ($languages as $aLanguage){
        $opLanguages[$aLanguage] = lang($aLanguage);
    }

    $fields = array();
    $fields[lang('name')] = form_input(array('name'=>'name', 'class'=>'span10', 'value'=>$name));
    $fields[lang('last_name')] = form_input(array('name'=>'lastName', 'class'=>'span10', 'value'=>$last_name));
    $fields[lang('email')] = form_input(array('name'=>'email', 'class'=>'span10', 'value'=>$email));
    $fields[lang('password')] = form_password(array('name'=>'password', 'class'=>'span10'));
    $fields[lang('identification')] = form_input(array('name'=>'identification', 'class'=>'span10', 'value'=>$identification));
    $fields[lang('telephone')] = form_input(array('name'=>'telephone', 'class'=>'span10', 'value'=>$telephone));
    $fields[lang('language')] = form_dropdown("language", $opLanguages, $language, "class='span10'");
    $fields[""] = "";
    $hidden = array('id' => $id, 'profile' => AuthConstants::ID_PROFILE_USER);
    echo print_form_columns('/usersdata/persist/', $fields, $hidden);