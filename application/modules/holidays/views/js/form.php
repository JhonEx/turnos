<script type="text/javascript">
    $(document).ready(function() {
        $( "#date" ).datepicker({
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            showButtonPanel: true
        });
        
        $("#form").validate({
            rules: {
                date: 'required',
            },
            messages: {
                date:'<?=lang('required')?>',
            },
            submitHandler: function(form) {
                $('#form').ajaxSubmit({success: function(data){
                        if (data.message != ""){
                            $('#alert').addClass("success");
                            $("#message").html(data.message);
                            $("#alert").show();
                        }
                        
                        if (data.error != ""){
                            $('#alert').addClass("alert");
                            $("#message").html(data.error);
                            $("#alert").show();
                        }      
                    },
                    dataType: 'json'
                    <?php echo ($id == "") ? ",'resetForm': true" : ''; ?>
                });
            }
        });
    });
</script>