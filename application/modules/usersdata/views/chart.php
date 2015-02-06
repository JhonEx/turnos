<?php 
    $fields = array();
    $fields[lang('init_date')] = form_input(array('name'=>'init_date', 'id'=>'init_date', 'class'=>'span10'));
    $fields[lang('end_date')] = form_input(array('name'=>'end_date', 'id'=>'end_date', 'class'=>'span10'));
    echo print_form_columns('/usersdata/getChart/', $fields);
    
    echo "<div style='margin: 0 auto; width:700px' id='chart_div'></div>";
    
