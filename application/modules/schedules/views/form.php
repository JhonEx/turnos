<?php 
    $opTurns = array();
    $opTurns[""] = lang("default_select");
    
    foreach ($turns as $aTurn){
        $opTurns[$aTurn->getId()] = $aTurn->getName();
    }
    
    $fields = array();
    $fields[lang('turn')] = form_dropdown("turn", $opTurns, $turn, "class='span4'");
    $fields[lang('date')] = form_input(array('id'=>'date', 'name'=>'date', 'class'=>'span3 focused', 'value'=>$date));
    $hidden = array('id' => $id, 'user' => $user);
    echo print_form('/schedules/persist/', $fields, $hidden);


