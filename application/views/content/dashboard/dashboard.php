<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .btn {
            outline: none;
            box-shadow: none;
            list-style: none;
            text-decoration: none;
        }

        .lightui2 {
            border-color: #bdbdbd;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
        }

        .lightui2b-shimmer {
            animation-duration: 1s;
            animation-fill-mode: forwards;
            animation-iteration-count: infinite;
            animation-name: placeHolderShimmer;
            animation-timing-function: linear;
            -webkit-animation-duration: 1s;
            -webkit-animation-fill-mode: forwards;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-name: placeHolderShimmer;
            -webkit-animation-timing-function: linear;
            background: #bdbdbd;
            background-image: linear-gradient(to right, #bdbdbd 0%, #999999 20%, #bdbdbd 40%, #bdbdbd 100%);
            background-repeat: no-repeat;
            background-size: 800px 104px;
            height: 104px;
            position: relative
        }

        .lightui2b-shimmer div {
            background: #ffffff;
            height: 6px;
            left: 0;
            position: absolute;
            right: 0
        }

        ._2iwo {
            height: 200px;
            padding: 12px
        }

        .__z8 {
            height: 150px;
            padding: 12px
        }

        div._2iwr {
            height: 40px;
            left: 40px;
            right: auto;
            top: 0;
            width: 8px;
        }

        div._2iws {
            height: 8px;
            left: 48px;
            top: 0
        }

        div._2iwt {
            left: 136px;
            top: 8px
        }

        div._2iwu {
            height: 12px;
            left: 48px;
            top: 14px
        }

        div._2iwv {
            left: 100px;
            top: 26px
        }

        div._2iww {
            height: 10px;
            left: 48px;
            top: 32px
        }

        div._2iwx {
            height: 20px;
            top: 40px
        }

        div._2iwy {
            left: 410px;
            top: 60px
        }

        div._2iwz {
            height: 13px;
            top: 66px
        }

        div._2iw- {
            left: 440px;
            top: 79px
        }

        div._2iw_ {
            height: 13px;
            top: 85px
        }

        div._2ix0 {
            left: 178px;
            top: 98px
        }

        @keyframes placeHolderShimmer {
            0% {
                background-position: -468px 0
            }

            100% {
                background-position: 468px 0
            }
        }

        @keyframes prideShimmer {
            from {
                background-position: top left
            }

            to {
                background-position: top right
            }
        }

        ._4-u5 {
            background-color: #ffffff
        }

        ._4-u7 {
            background-color: #ffffff
        }

        ._57d8 {
            background-color: #ffffff
        }

        ._4-u8 {
            background-color: #ffffff
        }
    </style>
</head>

<body>
    <!-- <section class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h2>Dashboard</h2>
            </div>
            <div class="col-md-6 align-self-end">
                <ol class="breadcrumb float-md-end">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </section> 
    <div class="row page-content" >
        <div class="col-lg-3 col-6 page-content-card">
            <div class="small-box bg-info">
                <div class="inner text-white">
                    <h3>150</h3>
                    <p>Sales Order</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-cart"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6 page-content-card">
            <div class="small-box bg-success">
                <div class="inner text-white">
                    <h3>1</h3>
                    <p>Belum Lunas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6 page-content-card">
            <div class="small-box bg-warning">
                <div class="inner text-white">
                    <h3>1</h3>
                    <p>Purchase Order</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clipboard"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6 page-content-card">
            <div class="small-box bg-danger">
                <div class="inner text-white">
                    <h3>1</h3>
                    <p>Pengiriman</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-car"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6 page-loader" style="display:none">
            <div class="small-box">
                <div class="lightui2">
                    <div class="lightui2b-shimmer">
                        <div class="_2iwr"></div>
                        <div class="_2iws"></div>
                        <div class="_2iwt"></div>
                        <div class="_2iwu"></div>
                        <div class="_2iwv"></div>
                        <div class="_2iww"></div>
                        <div class="_2iwx"></div>
                        <div class="_2iwy"></div>
                        <div class="_2iwz"></div>
                        <div class="_2iw-"></div>
                        <div class="_2iw_"></div>
                        <div class="_2ix0"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 page-loader" style="display:none">
            <div class="small-box">
                <div class="lightui2">
                    <div class="lightui2b-shimmer">
                        <div class="_2iwr"></div>
                        <div class="_2iws"></div>
                        <div class="_2iwt"></div>
                        <div class="_2iwu"></div>
                        <div class="_2iwv"></div>
                        <div class="_2iww"></div>
                        <div class="_2iwx"></div>
                        <div class="_2iwy"></div>
                        <div class="_2iwz"></div>
                        <div class="_2iw-"></div>
                        <div class="_2iw_"></div>
                        <div class="_2ix0"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 page-loader" style="display:none">
            <div class="small-box">
                <div class="lightui2">
                    <div class="lightui2b-shimmer">
                        <div class="_2iwr"></div>
                        <div class="_2iws"></div>
                        <div class="_2iwt"></div>
                        <div class="_2iwu"></div>
                        <div class="_2iwv"></div>
                        <div class="_2iww"></div>
                        <div class="_2iwx"></div>
                        <div class="_2iwy"></div>
                        <div class="_2iwz"></div>
                        <div class="_2iw-"></div>
                        <div class="_2iw_"></div>
                        <div class="_2ix0"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 page-loader" style="display:none">
            <div class="small-box">
                <div class="lightui2">
                    <div class="lightui2b-shimmer">
                        <div class="_2iwr"></div>
                        <div class="_2iws"></div>
                        <div class="_2iwt"></div>
                        <div class="_2iwu"></div>
                        <div class="_2iwv"></div>
                        <div class="_2iww"></div>
                        <div class="_2iwx"></div>
                        <div class="_2iwy"></div>
                        <div class="_2iwz"></div>
                        <div class="_2iw-"></div>
                        <div class="_2iw_"></div>
                        <div class="_2ix0"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 page-content-grafik mb-2" style="display:none">
            <div class="card">
                <div class="card-header">
                    <span class="float-start p-2">Grafik Penjualan - By Category</span>
                    <a onclick="next_year_category()" class="float-end text-muted p-2"><i class="fas fa-chevron-right"></i></a>
                    <span class="float-end p-2 year-chart-category">2021</span>
                    <a onclick="back_year_category()" class="float-end text-muted p-2"><i class="fas fa-chevron-left"></i></a>
                </div>
                <div class="card-body">
                    <div class="grafik-card" id="grafik-card">
                        <div class="grafik-card-body" id="grafik-penjualan"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 page-loader page-loader-grafik my-2" >
            <div class="small-box">
                <div class="lightui2">
                    <div class="lightui2b-shimmer">
                        <div class="_2iwr"></div>
                        <div class="_2iws"></div>
                        <div class="_2iwt"></div>
                        <div class="_2iwu"></div>
                        <div class="_2iwv"></div>
                        <div class="_2iww"></div>
                        <div class="_2iwx"></div>
                        <div class="_2iwy"></div>
                        <div class="_2iwz"></div>
                        <div class="_2iw-"></div>
                        <div class="_2iw_"></div>
                        <div class="_2ix0"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 page-content-grafik-1" style="display:none">
            <div class="card">
                <div class="card-header">
                    <span class="float-start p-2">Grafik Penjualan - By Vendor</span>
                    <a onclick="next_year_vendor()" class="float-end text-muted p-2"><i class="fas fa-chevron-right"></i></a>
                    <span class="float-end p-2 year-chart-vendor">2021</span>
                    <a onclick="back_year_vendor()" class="float-end text-muted p-2"><i class="fas fa-chevron-left"></i></a>
                </div>
                <div class="card-body">
                    <div class="grafik-card" id="grafik-card-1">
                        <div class="grafik-card-body" id="grafik-penjualan-1"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 page-loader page-loader-grafik-1 my-2" >
            <div class="small-box">
                <div class="lightui2">
                    <div class="lightui2b-shimmer">
                        <div class="_2iwr"></div>
                        <div class="_2iws"></div>
                        <div class="_2iwt"></div>
                        <div class="_2iwu"></div>
                        <div class="_2iwv"></div>
                        <div class="_2iww"></div>
                        <div class="_2iwx"></div>
                        <div class="_2iwy"></div>
                        <div class="_2iwz"></div>
                        <div class="_2iw-"></div>
                        <div class="_2iw_"></div>
                        <div class="_2ix0"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            $(".page-loader").hide();
            $(".page-content").show();

            $(".year-chart-category").text(new Date().getFullYear());
            $(".year-chart-vendor").text(new Date().getFullYear());

            function next_year_category(){
                var oldyear = $(".year-chart-category").text();
                $(".year-chart-category").text(parseInt(oldyear) + 1);
                drawChartCategory(true);
            }
            function back_year_category(){
                var oldyear = $(".year-chart-category").text();
                $(".year-chart-category").text(parseInt(oldyear) - 1);
                drawChartCategory(true);
            }

            function next_year_vendor(){
                var oldyear = $(".year-chart-vendor").text();
                $(".year-chart-vendor").text(parseInt(oldyear) + 1);
                drawChartVendor(true);
            }
            function back_year_vendor(){
                var oldyear = $(".year-chart-vendor").text();
                $(".year-chart-vendor").text(parseInt(oldyear) - 1);
                drawChartVendor(true);
            }




            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChartCategory(false));
            google.charts.setOnLoadCallback(drawChartVendor(false));

            var data = null;
            async function getdataTableCategory() {
                let result;

                var oldyear = $(".year-chart-category").text();
                try {
                    result = await $.ajax({
                        url: "<?php echo base_url("client/get_dashboard_category/") . $this->session->userdata('MsWorkplaceId') . "/" ?>" + parseInt(oldyear),
                        beforeSend: function (jqXHR, settings) {
                            xhrPool.push(jqXHR);
                        },
                    });

                    return result;
                } catch (error) {
                    return "false";
                }
            }
            async function drawChartCategory(newdata) {
                
                $(".page-loader-grafik").show();
                $(".page-content-grafik").hide();

                if (data==null || newdata==true ){
                    data = await getdataTableCategory();
                }
                if(data=="false") return;

                $(".page-content-grafik").show();
                $(".page-loader-grafik").hide();

                var data_table = new google.visualization.arrayToDataTable(data);
                var options = {
                    isStacked: 'relative',
                    width: '100%',
                    height: 350,
                    pointSize: 5,
                    lineWidth: 2,
                    chartArea:{left:"7%",width:"93%"},
                    legend: { position: 'top', maxLines: 7, textStyle: { fontSize: 12,}},
                };

                var chart = new google.visualization.LineChart(document.getElementById('grafik-penjualan'));
                chart.draw(data_table, options);

                
                var columns = [];
                var series = {};
                for (var i = 0; i < data_table.getNumberOfColumns(); i++) {
                    columns.push(i);
                    if (i > 0) {
                        series[i - 1] = {};
                    }
                }
                google.visualization.events.addListener(chart, 'select', function () {
                    var sel = chart.getSelection();
                    // if selection length is 0, we deselected an element
                    if (sel.length > 0) {
                        // if row is undefined, we clicked on the legend
                        if (sel[0].row === null) {
                            var col = sel[0].column;
                            if (columns[col] == col) {
                                // hide the data series
                                columns[col] = {
                                    label: data_table.getColumnLabel(col),
                                    type: data_table.getColumnType(col),
                                    calc: function () {
                                        return null;
                                    }
                                };

                                // grey out the legend entry
                                series[col - 1].color = '#CCCCCC';
                            } else {
                                // show the data series
                                columns[col] = col;
                                series[col - 1].color = null;
                            }
                            options['series'] = series;
                            var view = new google.visualization.DataView(data_table);
                            view.setColumns(columns);
                            chart.draw(view, options);
                        }
                    }
                });

                function resizeChart () {
                    chart.draw(data_table, options);
                }
                if (document.addEventListener) {
                    window.addEventListener('resize', resizeChart);
                }
                else if (document.attachEvent) {
                    window.attachEvent('onresize', resizeChart);
                }
                else {
                    window.resize = resizeChart;
                }
            };

            var datavendor = null;
            async function getdataTableVendor() {
                let result;

                var oldyear = $(".year-chart-vendor").text();
                try {
                    result = await $.ajax({
                        url: "<?php echo base_url("client/get_dashboard_vendor/") . $this->session->userdata('MsWorkplaceId') . "/" ?>" + parseInt(oldyear),
                        beforeSend: function (jqXHR, settings) {
                            xhrPool.push(jqXHR);
                        },
                    });

                    return result;
                } catch (error) {
                    return "false";
                }
            }
            async function drawChartVendor(newdata) {
                
                $(".page-loader-grafik-1").show();
                $(".page-content-grafik-1").hide();
                if (datavendor==null || newdata==true ){
                    datavendor = await getdataTableVendor();
                }
                if(datavendor=="false") return;

                $(".page-content-grafik-1").show();
                $(".page-loader-grafik-1").hide();

                var data_table = new google.visualization.arrayToDataTable(datavendor);
                var options = {
                    isStacked: 'relative',
                    width: '100%',
                    height: 350,
                    pointSize: 5,
                    lineWidth: 2,
                    chartArea:{left:"7%",width:"93%"},
                    legend: { position: 'top', maxLines: 7, textStyle: { fontSize: 12,}},
                };

                var chart = new google.visualization.LineChart(document.getElementById('grafik-penjualan-1'));
                chart.draw(data_table, options);

                
                var columns = [];
                var series = {};
                for (var i = 0; i < data_table.getNumberOfColumns(); i++) {
                    columns.push(i);
                    if (i > 0) {
                        series[i - 1] = {};
                    }
                }
                google.visualization.events.addListener(chart, 'select', function () {
                    var sel = chart.getSelection();
                    // if selection length is 0, we deselected an element
                    if (sel.length > 0) {
                        // if row is undefined, we clicked on the legend
                        if (sel[0].row === null) {
                            var col = sel[0].column;
                            if (columns[col] == col) {
                                // hide the data series
                                columns[col] = {
                                    label: data_table.getColumnLabel(col),
                                    type: data_table.getColumnType(col),
                                    calc: function () {
                                        return null;
                                    }
                                };

                                // grey out the legend entry
                                series[col - 1].color = '#CCCCCC';
                            } else {
                                // show the data series
                                columns[col] = col;
                                series[col - 1].color = null;
                            }
                            options['series'] = series;
                            var view = new google.visualization.DataView(data_table);
                            view.setColumns(columns);
                            chart.draw(view, options);
                        }
                    }
                });

                function resizeChart () {
                    chart.draw(data_table, options);
                }
                if (document.addEventListener) {
                    window.addEventListener('resize', resizeChart);
                }
                else if (document.attachEvent) {
                    window.attachEvent('onresize', resizeChart);
                }
                else {
                    window.resize = resizeChart;
                }
            };
        </script>
    </div> -->
</body>

</html>