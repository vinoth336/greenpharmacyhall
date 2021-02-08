var Filter = {

    init: function() {
        //this.listionFilter();
    },

    listionFilter: function() {
        window.location.href = "/search?" + $(".input_filter").find("input, select").serialize();
    },

    fetchDatas: function() {
        window.location.href = "/search?" + $(".mobile_sidebar").find("input, select").serialize();
    },
    resetFilter: function() {
        window.location.href = "/search";
    }
};

$(document).ready(function() {
    Filter.init();
});
