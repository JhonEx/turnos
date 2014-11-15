<script type="text/javascript">
    $(document).ready(function() {
        $('#initialTime, #endTime').datetimepicker({
            datepicker:false,
            format:'H:i',
            step:5
        });

        $("#form").validate({
            rules: {
                initialTime: 'required',
				endTime: 'required',
				name: 'required',
            },
            messages: {
                initialTime:'<?=lang('required')?>',
				endTime:'<?=lang('required')?>',
				name:'<?=lang('required')?>',
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