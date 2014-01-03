(function($){
jQuery(document).ready( function($) {
    /**
     * Update fast for the first 2.5 minutes
     */
    wp.heartbeat.interval('fast');

    /**
     * Enqueue the first set of data to receive updates
     */
    var nr_data = {
        'sample': 'data'
    };
    wp.heartbeat.enqueue(
        'udssl_nr',
        nr_data,
        true
    );

    /**
     * Prevent Ajax Update on Customizer Page
     */
    if(typeof wp.customize != 'undefined'){
        return true;
    }

    $(document).on( 'heartbeat-tick.udssl_nr', function(event, data){
        if(data.hasOwnProperty('udssl_nr')){
            nr_app.refresh(data.udssl_nr);
            $('#udssl_nr_time').html(data.udssl_nr_time);

            /**
             * Enqueue again to continue receiving updates
             */
            var nr_data = {
                'sample': 'data'
            };
            wp.heartbeat.enqueue(
                'udssl_nr',
                nr_data,
                true
            );
        }
    });

});
}(jQuery));

/**
 * Refresh monitor according to Heartbeat
 */
nr_app.refresh = function(data){
    jQuery('#udssl_nr_body').html('');
    _.each(data, function(visitor){
        nr_app.Visitors.add(new nr_app.Visitor({
            index: visitor.index,
            title: visitor.title,
            time: visitor.time,
            elapsed: visitor.elapsed,
            ip: visitor.ip,
            user_agent: visitor.user_agent,
            link: visitor.url
        }));
    });
};
