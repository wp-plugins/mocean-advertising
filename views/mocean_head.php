
<?php foreach ($urls as $url) { ?>
    <script type="text/javascript" src="<?= $url ?>"></script>
<?php } ?>
<script type="text/javascript">

    var keys = <?= json_encode($keys) ?>;

    var ajaxurl ='<?php echo admin_url('admin-ajax.php') ?>';

</script>

