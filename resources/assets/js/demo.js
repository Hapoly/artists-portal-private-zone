type = ['','info','success','warning','danger'];


demo = {
    initPickColor: function(){
        $('.pick-class-label').click(function(){
            var new_class = $(this).attr('new-class');
            var old_class = $('#display-buttons').attr('data-class');
            var display_div = $('#display-buttons');
            if(display_div.length) {
            var display_buttons = display_div.find('.btn');
            display_buttons.removeClass(old_class);
            display_buttons.addClass(new_class);
            display_div.attr('data-class', new_class);
            }
        });
    },

    initFormExtendedDatetimepickers: function(){
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
         });
    },

    initDashboardPageCharts: function(){

        /* ----------==========     Daily Requests Chart    ==========---------- */

        dailyRequestsChart = {
            labels: ['شنبه', 'یکشنبه', 'دوشنبه', 'سهشنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'],
            series: [
                [2, 5, 3, 8, 2, 11, 9]
            ]
        };

        optionsDailyRequestsChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 15, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var dailyRequestsChart = new Chartist.Line('#dailyRequestsChart', dailyRequestsChart, optionsDailyRequestsChart);

        md.startAnimationForLineChart(dailyRequestsChart);


        /* ----------==========     monthly Signs Chart    ==========---------- */

        var monthlySignsChart = {
          labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
          series: [
            [5, 18, 12, 25, 4, 32, 54, 12, 42, 12, 35, 13]

          ]
        };
        var optionsMonthlySignsChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: 75,
            chartPadding: { top: 0, right: 0, bottom: 0, left: 5}
        };
        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];
        var monthlySignsChart = Chartist.Bar('#monthlySignsChart', monthlySignsChart, optionsMonthlySignsChart, responsiveOptions);

        md.startAnimationForBarChart(monthlySignsChart);

        /* ----------==========     monthly Units Chart    ==========---------- */

        var monthlyUnitsChart = {
            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            series: [
                [5, 18, 12, 25, 4, 32, 54, 12, 42, 12, 35, 13]

            ]
        };
        var optionsMonthlyUnitsChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: 75,
            chartPadding: { top: 0, right: 0, bottom: 0, left: 5}
        };
        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function (value) {
                        return value[0];
                    }
                }
            }]
        ];
        var monthlyUnitsChart = Chartist.Bar('#monthlyUnitsChart', monthlyUnitsChart, optionsMonthlyUnitsChart, responsiveOptions);

        md.startAnimationForBarChart(monthlyUnitsChart);

        /* ----------==========     monthly Employee Chart    ==========---------- */

        monthlyEmployeeChart = {
            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            series: [
                [890, 920, 1100, 1152, 1160, 1180, 1196, 1215, 1230, 1245, 1256, 1265]

            ]
        };

        optionsMonthlyEmployeeChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 1600, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var monthlyEmployeeChart = new Chartist.Line('#monthlyEmployeeChart', monthlyEmployeeChart, optionsMonthlyEmployeeChart);

        md.startAnimationForLineChart(monthlyEmployeeChart);
    },

    initGoogleMaps: function(){
        var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
        var mapOptions = {
          zoom: 13,
          center: myLatlng,
          scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
          styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            title:"Hello World!"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
    },

	showNotification: function(from, align){
    	color = Math.floor((Math.random() * 4) + 1);

    	$.notify({
        	icon: "notifications",
        	message: "Welcome to <b>Material Dashboard</b> - a beautiful freebie for every web developer."

        },{
            type: type[color],
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
	}



}
