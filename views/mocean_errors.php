<style type="text/css">
    div#moceanadvwidget b {
        color: red;
    }
    div#moceanadvwidget td.first {
        width: 170px;
    }
    #errors{
        overflow-y: scroll;
        height: 500px;
        border:1px solid #F0F0F0;
    }
    #moceanadvwidget #errors th{
        background-color: #F4F4F4;
        color:#333;
    }
    #moceanadvwidget #errors td{
        text-align: left;
        border:none;
    }

</style>

<div class="wrap">
    <div id="moceanadvwidget">
        <h2>Mocean Advertisement Stats</h2>
        <?php if ($_GET['reset'] == 'true') { ?>
            <div id="setting-error-settings_updated" class="updated settings-error"> <p><strong>Errors were cleared.</strong></p></div>
        <? } ?>
        <form name="moceanadvwidget_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=mocean_errors&reset=true">
            <table>
                <tr>
                    <td><h3><?php  _e('Mocean Advertisement Errors', 'moceanadvwidget'); ?></h3></td>
                </tr>
                <tr>
                    <td>
                        <div id="errors"/>
                        <table style="width:750px">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Zone</th>
                                    <th>Error</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row) { ?>
                                    <tr>
                                        <td style="width:150px;"><?php echo $row->time ?></td>
                                        <td style="width:150px;"><?php echo  $options[$row->adv_id]['title'] ?></td>
                                        <td style="width:150px;"><?php echo  $row->error ?></td>
                                        <td style="width:150px;"><?php echo  $row->ip ?></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Reset" /></td>
                </tr>
            </table>
        </form>
    </div>
</div>