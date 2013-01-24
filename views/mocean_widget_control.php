<div>
    <label for="widget_moceanadvwidget-title-<?php echo $number; ?>">
        Advertisement Id: <span style="color:red;">(for tracking)</span></label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][title]" id="widget_moceanadvwidget-title-<?php echo $number; ?>" value="<?php echo $title; ?>" />
    <br />
    <label for="widget_moceanadvwidget-zone-<?php echo $number; ?>">
        Zone Id: <span style="color:red;">(required)</span></label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][zone]" id="widget_moceanadvwidget-zone-<?php echo $number; ?>" value="<?php echo $zone; ?>" />
    <br />
    <label for="widget_moceanadvwidget-type-<?php echo $number; ?>">
        Type:  </label><br />
    <select name="widget-widget_moceanadvwidget[<?php echo $number; ?>][type]" id="widget_moceanadvwidget-type-<?php echo $number; ?>"  >
        <option <?php echo $type == 3 ? 'selected' : '' ?> value="3">Text + Image</option>
        <option <?php echo $type == 2 ? 'selected' : '' ?> value="2">Image</option>
        <option <?php echo $type == 1 ? 'selected' : '' ?> value="1">Text</option>
    </select>
    <br />
    <label for="widget_moceanadvwidget-test-<?php echo $number; ?>">
        Test:
    </label>
    <br />
    <select name="widget-widget_moceanadvwidget[<?php echo $number; ?>][test]" id="widget_moceanadvwidget-test-<?php echo $number; ?>" >
        <option <?php echo $test == 0 ? 'selected' : '' ?> value="0">No</option>
        <option <?php echo $test == 1 ? 'selected' : '' ?> value="1">Yes</option>
    </select>
    <br />
    <br/>
    <label for="widget_moceanadvwidget-keywords-<?php echo $number; ?>">
        Keywords: <span style="color:red;">Ex: music,games (no space)</span></label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][keywords]" id="widget_moceanadvwidget-keywords-<?php echo $number; ?>" value="<?php echo $keywords; ?>" />
    <br />
    <label for="widget_moceanadvwidget-campaigns-<?php echo $number; ?>">
        Campaigns: <span style="color:red;">Ex:  123456,58795 (no space)</span></label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][campaigns]" id="widget_moceanadvwidget-campaigns-<?php echo $number; ?>" value="<?php echo $campaings; ?>" />
    <br />

    <label for="widget_moceanadvwidget-min_size_x-<?php echo $number; ?>">
        Minimum Width (px):  </label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][min_size_x]" id="widget_moceanadvwidget-min_size_x-<?php echo $number; ?>" value="<?php echo $min_size_x; ?>" />
    <br />
    <label for="widget_moceanadvwidget-size_x-<?php echo $number; ?>">
        Maximum Width (px):  </label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][size_x]" id="widget_moceanadvwidget-size_x-<?php echo $number; ?>" value="<?php echo $size_x; ?>" />
    <br />
    <label for="widget_moceanadvwidget-min_size_y-<?php echo $number; ?>">
        Minimum Height (px):  </label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][min_size_y]" id="widget_moceanadvwidget-min_size_y-<?php echo $number; ?>" value="<?php echo $min_size_y; ?>" />
    <br />
    <label for="widget_moceanadvwidget-size_y-<?php echo $number; ?>">
        Maximum Height (px):  </label><br />
    <input type="text" name="widget-widget_moceanadvwidget[<?php echo $number; ?>][size_y]" id="widget_moceanadvwidget-size_y-<?php echo $number; ?>" value="<?php echo $size_y; ?>" />
    <br />
    <input type="hidden" name="widget-moceanadvwidget-submit-<?php echo $number; ?>" id="moceanadvwidget-submit-<?php echo $number; ?>" value="true" />
</div>