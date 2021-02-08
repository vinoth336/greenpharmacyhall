var Filter = {

    init: function() {
        this.listionFilter();
    },

    listionFilter: function() {
        $('.input_filter').on('change', function() {
            Filter.fetchDatas();
        });
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
