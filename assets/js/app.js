window.$ = require('jquery');
window.dt = require('datatables.net')(window, $);

require('bootstrap');
require('datatables.net-bs4')(window, $);
require('datatables.net-buttons-bs4')(window, $);
require('datatables.net-buttons/js/buttons.colVis.js')(window, $);
require('datatables.net-fixedheader-bs4')(window, $);
require('datatables.net-keytable-bs4')(window, $);
require('datatables.net-responsive-bs4')(window, $);
require('datatables.net-scroller-bs4')(window, $);

require('datatables.net-dt/css/jquery.dataTables.min.css');
require("bootstrap/scss/bootstrap.scss");
//require( 'datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
require('datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css');
require('datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css');
require('datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css');
require('datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
require('datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css');
require('./../css/app.css');

$(document).ready(function () {
    $('#contacs').DataTable({
        'paging': true,
        "serverSide": true,
        "ajax": function ajax(data, callback, settings) {

            data.search =

            $.get("/api/rows", {
                length:data.length,
                start:data.start,
                search:data.search.value.length > 0 ? data.search.value : null,
                order:data.order.length > 0 ? ["firstName","lastName","phoneNumbers"][data.order[0].column] : null,
                dir:data.order.length > 0 ? data.order[0].dir : null,
            }, function (res) {
                var json = {};
                json.recordsTotal = res.data.total;
                json.recordsFiltered = res.data.total;
                json.data = [];
                res.data.entities.forEach(function (row) {

                    json.data.push([
                        row.attributes.firstName,
                        row.attributes.lastName,
                        row.attributes.phoneNumbers.join(", "),
                    ]);

                });
                callback(json);
            });

        }
    });
});