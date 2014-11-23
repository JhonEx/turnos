<script type="text/javascript">
    $(document).ready(function() {
        
        $("#form").validate({
            rules: {
                init_date: "required",
                end_date: "required",
            },
            messages: {
                init_date:"<?php echo lang('required'); ?>",
                end_date:"<?php echo lang('required'); ?>",
            },
            submitHandler: function(form) {
                $('#form').ajaxSubmit({success: function(data){
                        var html = "";
                        
                        for (i in data){
                            var obj = data[i];
                            
                            html += "<tr>";    
                            html += "   <td>" + obj.schedule.date + "</td>";    
                            html += "   <td>" + obj.schedule.turn.name + "</td>";    
                            html += "   <td>" + obj.hours + "</td>";    
                            html += "   <td>" + obj.extra + "</td>";    
                            html += "   <td>" + obj .holiday + "</td>";    
                            html += "</tr>";    
                            
                        }
                        
                        $("#report").show();;
                        $("#report tbody").html(html);
                    },
                    dataType: 'json'
                });
            }
        });
        
        $( "#init_date, #end_date" ).datepicker({
            changeMonth: true
        });
    });
</script>