jQuery(document).ready(function($) {
    var last_id = $('.pledgeItem:first').data('id');
	last_id = last_id;
    setInterval(function() {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_pledges',
                last_id: last_id
            },
            success: function(response) {
                if (response !== 'no-more-pledges') {
                    var newEntries = $(response);
                    newEntries.each(function() {
                        console.log('New entry added:', $(this).data('id'));
                    });
                    $('.pledgeWall').prepend(newEntries);
                    last_id = $('.pledgeItem:first').data('id');
                } else {
                    console.log('No more pledges to load.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }, 5000); // 5000 milliseconds = 5 seconds
});
