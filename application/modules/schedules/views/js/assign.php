<script type="text/javascript">
$(document).ready(function() {
    var schedules = {};
    var currentDate = "";
    
    <?php foreach ($schedules as $aSchedule): ?>
        var id = <?=$aSchedule->getId()?>;
        var date = '<?=$aSchedule->getDate()->format("Y-m-d")?>';
        var turn = '<?=$aSchedule->getTurn()->getName()?>';
        schedules[id] = {id: id, date: date, turn: turn };
    <?php endforeach; ?>
    
    
    //Los dias de la semana abreviados, esto para armar el calendario
    var dayNames = new Array();
    <?php foreach($weekdays as $aWeekday): ?>
    dayNames.push("<?= substr(lang($aWeekday), 0, 3) ?>");
    <?php endforeach; ?>
    
    //Los meses con su traduccion, esto para armar el calendario
    var monthNames  = new Array();
    <?php foreach($months as $aMonths): ?>
    monthNames.push("<?= lang($aMonths) ?>");
    <?php endforeach; ?>
        
    //Inicializacion del plugin del calendario
    $('#calendar').fullCalendar({
        theme: false,
        header: {
            left: 'prev',
            center: 'title',
            right: 'next',
        },
        aspectRatio: 4,
        editable: true,
        dayNames: dayNames,
        monthNames : monthNames
    });
    
    updateTurns();
    
    function updateTurns()
    {
        $(".fc-day-content .turn").remove();
        
        for (i in schedules){
            var schedule = schedules[i];
            
            var html = "<div class='turn' turn='" + schedule.id + "'>";
            html += schedule.turn;
            html += "<a href='#' class='delete' turn='" + schedule.id + "'></a>";
            html += "</div>";
            
            $("#calendar #" + schedule.date + " .fc-day-content").append(html);
        }
    }
    // Contruir html de cada turno para cada dia
    
    // Borrar un turno
    $(document).on('click', '.delete', function(){
        var obj = $(this);
        
        $.post("<?php echo site_url('/schedules/delete'); ?>",
            {'id':obj.attr("turn"), '<?=$csrf?>': $('input[name=<?=$csrf?>]').val()},
            function(data){
                delete schedules[obj.attr("turn")];
                
                updateTurns();
            },
            'json'
        );
    })
    
    // Dialogo para crear turno
    $("#dialog-form").dialog({
        autoOpen: false
    });
    
    $("#form").validate({
        rules: {
            turn: 'required',
        },
        messages: {
            turn:'<?=lang('required')?>',
        },
        submitHandler: function(form) {
            $('#form').ajaxSubmit({success: function(data){
                    if (data.message != ""){
                        $('#alert').addClass("success");
                        $("#message").html(data.message);
                        $("#alert").show();
                        
                        var id = data.id;
                        var date = currentDate;
                        var turn = $("#turn option[value='" + $("#turn").val() + "']").text();
                        schedules[id] = {id: id, date: date, turn: turn };
                        
                        updateTurns();
                        
                    }
                    
                    if (data.error != ""){
                        $('#alert').addClass("alert");
                        $("#message").html(data.error);
                        $("#alert").show();
                    }      
                },
                dataType: 'json'
            });
        }
    });
    
    $(document).on('click', '.fc-widget-content', function(e){
        if( $(e.target).hasClass('delete') ) {
           return;
        }
        
        currentDate = $(this).attr("id");
        $("#form input[name='date']").val($(this).attr("id"));
        $("#dialog-form").dialog('open');
    });
    
    updateControls();
    
    // Cuando se cambia de mes se actualizan los servicios del calendario y actualizan los controle (Der, Izq)
    $(".fc-button-prev,  .fc-button-next").click(function(){
        updateControls();
        updateTurns();
    });
    
    // Actualiza los controles del calendario (Izq, Der)
    function updateControls(){
        var dateStart = new Date();
        dateStart.setDate(1);

        var dateEnd = new Date();
        dateEnd.setDate(dateEnd.getDate() + 90);
        
        dateStringStart = formatDate(dateStart);
        dateStringEnd = formatDate(dateEnd);
        
        if ($("td#"+dateStringStart).length > 0){
            $(".fc-button-prev").hide();
        }else{
            $(".fc-button-prev").show();
        }
        
        if ($("td#"+dateStringEnd).length > 0){
            $(".fc-button-next").hide();
        }else{
            $(".fc-button-next").show();
        }
    }
    
    // Formatea una fecha yyyy-mm-dd
    function formatDate(date){
        var year        = date.getFullYear();
        var month       = ((date.getUTCMonth() + 1) < 10) ? "0"+(parseInt(date.getUTCMonth() + 1)) : parseInt(date.getUTCMonth() + 1);
        var day         = (date.getUTCDate() < 10) ? "0"+date.getUTCDate()  : date.getUTCDate();
        var dateString  = year+"-"+month+"-"+day;
        return dateString;
    }
});
    
</script>