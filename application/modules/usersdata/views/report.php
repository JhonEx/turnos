<?php 
    $fields = array();
    $fields[lang('init_date')] = form_input(array('name'=>'init_date', 'id'=>'init_date', 'class'=>'span10'));
    $fields[lang('end_date')] = form_input(array('name'=>'end_date', 'id'=>'end_date', 'class'=>'span10'));
    $hidden = array('user' => $user);
    echo print_form_columns('/usersdata/getReport/', $fields, $hidden);
    
    $html = "<br/>";
    $html .= "<table id='report' style='display:none'>";
    $html .= "  <thead>";
    $html .= "      <tr>";
    $html .= "          <td>" . lang("date") . "</td>";
    $html .= "          <td>" . lang("turn") . "</td>";
    $html .= "          <td>" . lang("hours") . "</td>";
    $html .= "          <td>" . lang("extra") . "</td>";
    $html .= "          <td>" . lang("holiday") . "</td>";
    $html .= "      </tr>";
    $html .= "  </thead>";
    $html .= "  <tbody>";
    $html .= "  </tbody>";
    $html .= "</table>";
    
    echo $html;
    
