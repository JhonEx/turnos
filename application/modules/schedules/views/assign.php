<div id="calendar"></div>

<div id="dialog-form" title="<?=lang("create_turn")?>">
    <?php 
    $opTurns = array();
    $opTurns[""] = lang("default_select");
    
    foreach ($turns as $aTurn){
        $opTurns[$aTurn->getId()] = $aTurn->getName();
    }
    
    $fields = array();
    $fields[lang('turn')] = form_dropdown("turn", $opTurns, '', "class='span4' id='turn'");
    $hidden = array('id' => '', 'user' => $user, 'date' => '');
    echo print_form('/schedules/persist/', $fields, $hidden);
    ?>
</div>

