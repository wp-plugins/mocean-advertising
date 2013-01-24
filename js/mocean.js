function trackClick(sender, event) {
        jQuery.post(ajaxurl, {action: 'trackClick', adv_id: sender.dataset.id}, function(a) {
            window.location = sender.href;
        });

        event.preventDefault();
        return false;
    }


    function trackError(id, data) {
        if (data == null) {
            var error = 'Invalid Mocean Settings';
        } else {
            var error = data.error;
        }

        jQuery.post(ajaxurl, {action: 'trackError', adv_id: id, error: error});
    }

    function loadAdvertisement(id, data) {
        data = data[0];
        if (data == null || data.error != null) {
            return trackError(id, data);
        }

        var content = '';

        if (data.text != null) {
            content = '<a href="' + data.url + '" data-id="' + id + '">' + data.text + '</a>';
        } else if (data.img != null) {
            content = '<a href="' + data.url + '" data-id="' + id + '"><img src="' + data.img + '" alt=""/></a>';
        }

        jQuery('#adv' + id).html(content);

        jQuery('a', '#adv' + id).click(function(event) {
            return trackClick(this, event);
        });
    }

    jQuery(document).ready(function($) {
        for (var i = 0; i < keys.length; i++) {
            var key = keys[i];
            loadAdvertisement(key, eval('adv'+key));
        }
    });