<script type="text/javascript">
    $(document).ready(function() {
        var list = $('#list').dataTable( {
            "aoColumns":[{"bVisible": false},null ,null ,null,null],
            "sAjaxSource": "<?php echo site_url('/schedules/getListUser'); ?>",
        });
    });
</script>
