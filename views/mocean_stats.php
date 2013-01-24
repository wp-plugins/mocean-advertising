<style type="text/css">
    div#moceanadvwidget b {
        color: red;
    }
    div#moceanadvwidget td.first {
        width: 170px;
    }
</style>

<div class="wrap">
    <div id="moceanadvwidget">
        <h2>Mocean Advertisement Stats</h2>
        <?php if ($_GET['reset'] == 'true') { ?>
            <div id="setting-error-settings_updated" class="updated settings-error"> <p><strong>Stats were cleared.</strong></p></div>
        <?php } ?>
        <form name="moceanadvwidget_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=mocean_stats&reset=true">
            <table>
                <tr>
                    <td><h3><? _e('Mocean Advertisement Click Rates', 'moceanadvwidget'); ?></h3></td>
                </tr>
                <tr>
                    <td>
                        <table style="width:620px;" id="stats">
                            <thead/>
                            <tr>
                                <td>Advertisement</td>
                                <th scope="col">Last 1 Day</th>
                                <th scope="col">Last 7 Days</th>
                                <th scope="col">Last 30 Days</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats as $row) { ?>
                                    <tr>
                                        <th scrope="row"><?= $row->name ?></th>
                                        <td><?php echo $row->l1count ?></td>
                                        <td><?php echo $row->l7count ?></td>
                                        <td><?php echo $row->l30count ?></td>
                                        <td><?php echo $row->count ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                $('#stats').visualize({type: 'bar', width: '620px'});
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Reset" /></td>
                </tr>
            </table>
        </form>
    </div>
</div>
