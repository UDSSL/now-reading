/**
 * UDSSL Now Reading Backbone App
 */
var nr_app = nr_app || {};

/**
 * Visitor Model
 */
nr_app.Visitor = Backbone.Model.extend({
    defaults: {
        index: '0',
        title: 'Home',
        time: '2013-11-05 12:00:00',
        elapsed: '1 min ago',
        ip: '127.0.0.1',
        user_agent: 'Mozilla Firefox',
        link: ''
    }
});

/**
 * Visitor View
 */
nr_app.VisitorView = Backbone.View.extend({

    tagName: 'tr',

    template: _.template( jQuery('#visitor-template').html() ),

    initialize: function() {
        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'destroy', this.remove);
    },

    render: function() {
        this.$el.html( this.template( this.model.toJSON() ) );
        return this;
    }
});

/**
 * Visitors Collection
 */
var Visitors = Backbone.Collection.extend({
    model: nr_app.Visitor,
});

/**
 * Visitor Monitor View
 */
nr_app.MonitorView = Backbone.View.extend({
    el: '#udssl_nr_body',

    events: {
    },

    initialize: function() {
        this.listenTo(nr_app.Visitors, 'add', this.addOne);
        this.listenTo(nr_app.Visitors, 'reset', this.addAll);
    },

    addOne: function( visitor ) {
        var view = new nr_app.VisitorView({ model: visitor });
        jQuery('#udssl_nr_body').append( view.render().el );
    },

    addAll: function() {
        jQuery('#udssl_nr_body').html('');
        nr_app.Visitors.each(this.addOne, this);
    }
});

/**
 * Initialize UDSSL Now Reading App
 */
nr_app.Visitors = new Visitors();
nr_app.Monitor = new nr_app.MonitorView();
