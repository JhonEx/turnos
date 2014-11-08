<?php 
    $fields = array();
    $fields[lang('date')] = form_input(array('name'=>'date', 'id'=>'date', 'class'=>'span3 focused', 'value'=>$date));
    $hidden = array('id' => $id);
    echo print_form('/holidays/persist/', $fields, $hidden);