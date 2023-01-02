(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define('/charts/flot', ['jquery', 'Site'], factory);
  } else if (typeof exports !== "undefined") {
    factory(require('jquery'), require('Site'));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.chartsFlot = mod.exports;
  }
})(this, function (_jquery, _Site) {
  'use strict';

  var _jquery2 = babelHelpers.interopRequireDefault(_jquery);

  (0, _jquery2.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  });


  // Example Flot Full-Bg Line
  // -------------------------
  (function () {
    var b = [[1262304000000, 0], [1264982400000, 500], [1267401600000, 700], [1270080000000, 1300], [1272672000000, 2600], [1275350400000, 1300], [1277942400000, 1700], [1280620800000, 1300], [1283299200000, 1500], [1285891200000, 2000], [1288569600000, 1500], [1291161600000, 1200]];
    var a = [{
      label: "Fish values",
      data: b
    }];

    _jquery2.default.plot("#exampleFlotFullBg", a, {
      xaxis: {
        min: new Date(2009, 12, 1).getTime(),
        max: new Date(2010, 11, 2).getTime(),
        mode: "time",
        tickSize: [1, "month"],
        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        tickLength: 0,
        // tickColor: "#edeff2",
        color: "#474e54",
        font: {
          size: 14,
          weight: 300
          // family: "OpenSans Light"
        }
      },
      yaxis: {
        tickColor: "#edeff2",
        color: "#474e54",
        font: {
          size: 14,
          weight: "300"
          // family: "OpenSans Light"
        }
      },
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          // fill: true,
          // fillColor: "#ff0000",
          lineWidth: 1.5
        },
        points: {
          show: true,
          fill: true,
          fillColor: Config.colors("primary", 600),
          radius: 3,
          lineWidth: 1
        }
      },
      colors: [Config.colors("primary", 400)],
      grid: {
        // show: true,
        hoverable: true,
        clickable: true,
        // color: "green",
        // tickColor: "red",
        backgroundColor: {
          colors: ["#fcfdfe", "#fcfdfe"]
        },
        borderWidth: 0
        // borderColor: "#ff0000"
      },
      legend: {
        show: false
      }
    });
  })();

});
