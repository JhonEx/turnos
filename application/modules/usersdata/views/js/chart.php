<script type="text/javascript">
        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages':['corechart']});
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
                        var dataChart = [];
                        for (i in data){
                            var obj = data[i];
                            var aData = [obj.name, obj.hours];
                            dataChart[dataChart.length] = aData;
                        }
                    
                    
                        drawChart(dataChart);
                    },
                    dataType: 'json'
                });
            }
        });
        
        $( "#init_date, #end_date" ).datepicker({
            changeMonth: true
        });
        
        function drawChart(dataChart) {
            
            
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Vigilantes');
            data.addColumn('number', 'Horas');
            data.addRows(dataChart);
    
            // Set chart options
            var options = {'title':'Reporte de horas laboradas',
                           'width':700,
                           'height':300};
    
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
        }
    });
</script>