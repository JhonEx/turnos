<?php 
    $fields = array();
    $fields[lang('name')] = form_input(array('id'=>'name', 'name'=>'name', 'class'=>'span3 focused', 'value'=>$name));
    $fields[lang('initialTime')] = form_input(array('id'=>'initialTime', 'name'=>'initialTime', 'class'=>'span3 focused', 'value'=>$initialTime));
	$fields[lang('endTime')] = form_input(array('id'=>'endTime', 'name'=>'endTime', 'class'=>'span3 focused', 'value'=>$endTime));
    $hidden = array('id' => $id);
    echo print_form('/turns/persist/', $fields, $hidden);