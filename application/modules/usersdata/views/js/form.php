<script type="text/javascript">
    $(document).ready(function() {
        
        $("#form").validate({
            rules: {
                idProfile: "required",
                name: "required",
                lastName: "required",
                email: {required: true, email: true},
                identification: {required: true},
                telephone: {required: true},
            },
            messages: {
                idCity:"<?php echo lang('required'); ?>",
                idProfile:"<?php echo lang('required'); ?>",    
                name:"<?php echo lang('required'); ?>",
                lastName:"<?php echo lang('required'); ?>",
                email:"<?php echo lang('error_email'); ?>",
                identification: {required: "<?php echo lang('required'); ?>"},
                telephone: {required: "<?php echo lang('required'); ?>"},
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