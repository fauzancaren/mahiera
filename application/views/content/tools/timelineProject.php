<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .customform:hover {
         border: 0.8px solid slategray;
         border-radius: 1em;
      }

      .select2-results__group:hover {
         cursor: pointer;
         background: #fff2df;
      }

      .list-sub-project {
         display: flex;
         max-width: 200px;
      }

      .list-sub-project>span {
         margin-left: 0.25rem !important;
      }

      .list-sub-project::before {
         font-family: "Font Awesome 5 Free";
         font-weight: 900;
         font-size: 0.5rem;
         content: "\f111";
         left: 20px;
         margin: 0px 5px;
         display: inline-block;
         transform: rotate(90deg);
      }


      .project-list {
         padding: 0.25rem;
         box-shadow: 0 .2rem .25rem rgba(0, 0, 0, .075) !important;
      }

      .project-list:hover {
         cursor: pointer;
         box-shadow: 0 .2rem .25rem rgba(0, 0, 0, .25) !important;
         opacity: 1;
         transition: all .5s;
      }

      .action-project {
         background-color: rgba(0, 0, 0, .1);
         display: none;
      }

      .action-project:hover {
         border: none;
         background-color: rgba(0, 0, 0, .20);
      }

      .sub-btn:hover {
         color: whitesmoke;
         transition: all .5s;
         transform: scale(1, 1.2);
      }

      /* .project-list:hover>.action-project {
         right: 5px;
         opacity: 1;
         transition: all .3s;
         box-shadow: 3px 2px 5px #6f6f6f;
      } */

      .project-sub-list {
         height: 1.25rem;
         box-shadow: 0 .2rem .25rem rgba(0, 0, 0, .075) !important;
      }

      .project-sub-list:hover {
         cursor: pointer;
         box-shadow: 0 .2rem .25rem rgba(0, 0, 0, .25) !important;
         opacity: 1;
         transition: all .5s;
      }

      .day-week {
         background: #f1f1ff !important;
      }

      .day-holiday {
         background: #fff7fa !important;
      }

      .icon-header {
         font-size: 0.9rem;
         cursor: pointer;
      }

      .item-header {
         cursor: pointer;
      }

      .tooltip-inner {
         max-width: 300px !important;
      }

      /*Setting the width of column 3.*/
   </style>
</head>

<body>
   <section class=" content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2 class="header-timeline"> Timeline Project - List </h2>
         </div>

         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item"> Tools </li>
               <li class="breadcrumb-item active" onclick="menuselect('pengiriman-list','menu-pengiriman')" style="cursor:pointer"> Timeline Project </li>
            </ol>
         </div>
      </div>
   </section>
   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange card-progress">
            <div class="card-header">
               <div class="row align-items-center">
                  <div class="col">
                     <span class="fw-bold">
                        <i class="fas fa-briefcase" aria-hidden="true">
                        </i>&nbsp;List Project</span>
                  </div>
                  <div class="col-auto px-1">
                     <button id="btn-add-master" class="btn btn-success btn-sm mr-3 btn-hide">
                        <i class="fas fa-plus" aria-hidden="true">
                        </i>
                        <span class="fw-bold">
                           &nbsp;Tambah Project
                        </span>
                     </button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date" name="tb_date">
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Divisi</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_type" placeholder="Silahkan pilih divisi" autocomplete="off">
                        </div>
                     </div>

                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">Pencarian</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_search" placeholder="Silahkan cari nama project atau divisi..." autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div id="data-content" class="p-2">
                     <div class="table-basic">
                        <table cellspacing=" 0" id="table-basic" class="table table-sm table-borderless" style="width:280px">
                           <thead>
                              <tr class="month">
                                 <th id="col-divisi" style="text-align: center;vertical-align:middle;background: #f1f1f1;" rowspan="3">
                                    <div style="min-width:120px;">Divisi</div>
                                 </th>
                                 <th id="col-project" style="text-align: center;vertical-align:middle;background:  #f1f1f1;" rowspan="3" class="th-project">
                                    <div style="min-width:200px;">Project</div>
                                 </th>
                              </tr>
                              <tr class="week">
                              </tr>
                              <tr class="day">
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <span id="output"></span>
         </div>
      </div>
      <div id="dialog-box">
      </div>
      <script>
         var req_status = 0;
         var modal_action;

         $(document).ready(async function() {
            var ajax_req;
            async function fetchTest() {
               let response = await fetch('https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json');
               let responseText = await response.text();
               return JSON.parse(responseText);
            }
            let data_holiday = await fetchTest();

            function get_data_holiday(strDate) {
               let data = "";
               $.each(data_holiday, function(index, value) {
                  if (index == parseInt(strDate)) {
                     data = value;
                     return false
                  }
               });
               return data;
            }

            /**
             * 
             *  @combotree
             */
            var data_divisi = <?= JSON_ENCODE($this->db->get('TblMsDivisi')->result()) ?>;

            function insert_data(ref) {
               var arr_sub = [];
               data_divisi.forEach(element => {
                  if (element.MsDivisiRef == ref) {
                     var ins = insert_data(element.MsDivisiId);
                     if (ins.length > 0) {
                        arr_sub.push({
                           id: element.MsDivisiId,
                           title: element.MsDivisiName,
                           subs: ins
                        })
                     } else {
                        arr_sub.push({
                           id: element.MsDivisiId,
                           title: element.MsDivisiName
                        })
                     };
                  }
               });
               return arr_sub;
            }
            var arr = insert_data(0);

            var comboTree3 = $('#tb_type').comboTree({
               source: arr,
               isMultiple: true,
               cascadeSelect: true,
               collapse: false
            });
            comboTree3.onChange(function() {
               console.log(comboTree3._selectedItems);
            });
            comboTree3.setSelection([1]);

            /**
             * 
             *  @tanggal
             */
            moment.locale("id");
            var StartDateContent = moment().startOf('month');
            var EndDateContent = moment().endOf('month');

            $('#tb_date').daterangepicker({
               startDate: StartDateContent,
               endDate: EndDateContent,
               ranges: {
                  'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                  '1 Bulan yang lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                  '3 Bulan yang lalu': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
               },
               "minSpan": {
                  "days": 14
               },
               locale: {
                  "format": 'DD MMMM YYYY',
                  "customRangeLabel": "Pilih Tanggal Sendiri",
               }
            }, Date_content);

            function Date_content(start, end) {
               if (end.diff(start, 'days') < 9) {
                  Swal.fire(
                     'Kesalahan Proses data!',
                     'pilihan tanggal minimal 10 hari!',
                     'error'
                  )

                  $('#tb_date').data('daterangepicker').setStartDate(StartDateContent);
                  $('#tb_date').data('daterangepicker').setEndDate(EndDateContent);
               } else {
                  $('#tb_date').val(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY'));
                  StartDateContent = start;
                  EndDateContent = end;
                  console.log(StartDateContent, EndDateContent)
                  remove_table();
                  add_after_table(StartDateContent, EndDateContent);
               }
            }

            function getColor() {
               return "hsl(" + 360 * Math.random() + ',' +
                  (25 + 50 * Math.random()) + '%,' +
                  (85 + 10 * Math.random()) + '%)'

            }

            function add_after_table(start, end) {
               console.log("add after");
               var currDate = moment(start).subtract(1, 'days').startOf('day');
               var lastDate = moment(end).add(1, 'days').startOf('day');

               var last_month = "";
               var last_week = "";

               while (currDate.add(1, 'days').diff(lastDate) < 0) {
                  var month_now = currDate.format('MM') + "-" + currDate.format('YYYY');
                  var week_now = (currDate.isoWeek() - moment(currDate).startOf('month').isoWeek() + 1);
                  var day_now = currDate.format('D');

                  // set MONTH table
                  if ($('#table-basic thead .month .' + month_now).html()) {
                     var last_att_col = parseInt($('#table-basic thead').find(".month").find("." + month_now).attr('colspan')) + 1;
                     $('#table-basic thead').find(".month").find("." + month_now).attr('colspan', last_att_col);
                  } else {
                     markup = " <th class='" + month_now + "' colspan='1'><div class='header-month d-block'><span >" + currDate.format('MMMM-YYYY') + "</span></div></th>";
                     $('#table-basic thead').find(".month").append(markup);
                  }

                  // set week table
                  if ($('#table-basic thead .week .' + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).html()) {
                     var last_att_col = parseInt($('#table-basic thead').find(".week").find("." + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).attr('colspan')) + 1;
                     $('#table-basic thead').find(".week").find("." + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).attr('colspan', last_att_col);
                  } else {
                     markup = " <th class='" + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "' colspan='1'style='background: " + getColor() + ";'>W-" + week_now + "</th>";
                     $('#table-basic thead').find(".week").append(markup);
                     last_week = week_now;
                  }


                  // set day table 
                  let holiday = get_data_holiday(currDate.format('YYYYMMDD'));
                  let today = (currDate.format('YYYYMMDD') == moment().format('YYYYMMDD') ? true : false);
                  if (currDate.format('d') == 0) {
                     if (holiday != "") {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + " " + (today == true ? "text-primary" : "text-danger") + "' style='text-align:center;max-width:100px;min-width:100px;background: lavender;' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' title='" + holiday["deskripsi"] + "" + (today == true ? "<br><b>HARI INI</b>" : " ") + "'>" + day_now + "</th>";
                     } else {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + " " + (today == true ? "text-primary" : "text-danger") + "' style='text-align:center;max-width:100px;min-width:100px;background: lavender;' " + (today == true ? "data-bs-html='true' data-bs-toggle='tooltip' data-bs-placement='top' title='<b>HARI INI</b>'" : " ") + ">" + day_now + "</th>";
                     }
                  } else {
                     if (holiday != "") {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "  " + (today == true ? "text-primary" : "text-danger") + "' style='text-align:center;max-width:100px;min-width:100px;background:lavenderblush' data-bs-toggle='tooltip' data-bs-placement='top' title='" + holiday["deskripsi"] + "'>" + day_now + "</th>";
                     } else {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + " " + (today == true ? "text-primary" : "") + "' style='text-align:center;max-width:100px;min-width:100px;' " + (today == true ? "data-bs-html='true' data-bs-toggle='tooltip' data-bs-placement='top' title='<b>HARI INI</b>'" : " ") + ">" + day_now + "</th>";
                     }
                  }
                  $('#table-basic thead').find(".day").append(markup);

                  // set day cell
                  markup = " <td class='" + (day_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "' style='text-align:center;max-width:100px;min-width:100px;width:100px'></td>";
                  $('#table-basic tbody').find(".sub").append(markup);

               }
               $("[data-bs-toggle='tooltip']").tooltip();
               $(".table-basic").freezeTable({
                  'columnNum': 2,
               });
               load_table();
            };

            function add_before_table(start, end) {
               console.log("add before");
               var lastDate = moment(start).subtract(1, 'days').startOf('day');
               var currDate = moment(end).add(1, "days").startOf('day');

               var last_month = "";
               var last_week = "";
               var last_day = "";
               while (currDate.subtract(1, 'days').diff(lastDate) > 0) {
                  var month_now = currDate.format('MM') + "-" + currDate.format('YYYY');

                  var week_now = (currDate.isoWeek() - moment(currDate).startOf('month').isoWeek() + 1);
                  if (week_now < 0) week_now = currDate.isoWeek();

                  var day_now = currDate.format('D');

                  // set month table

                  if ($('#table-basic thead .month .' + month_now).html()) {
                     var last_att_col = parseInt($('#table-basic thead').find(".month").find("." + month_now).attr('colspan')) + 1;
                     $('#table-basic thead').find(".month").find("." + month_now).attr('colspan', last_att_col);
                  } else {
                     markup = " <th class='" + month_now + "' colspan='1'><div class='header-month d-block'><span >" + currDate.format('MMMM-YYYY') + "</span></div></th>";
                     // $('#table-basic thead').find(".month").insertAfter) _(markup);
                     $(markup).insertAfter($('#table-basic thead').find(".month").find(".th-project"));
                  }

                  if ($('#table-basic thead .week .' + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).html()) {
                     var last_att_col = parseInt($('#table-basic thead').find(".week").find("." + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).attr('colspan')) + 1;
                     $('#table-basic thead').find(".week").find("." + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).attr('colspan', last_att_col);
                  } else {
                     markup = " <th class='" + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "' colspan='1' style='background: " + getColor() + ";'>W-" + week_now + "</th>";
                     $('#table-basic thead').find(".week").prepend(markup);
                     last_week = week_now;
                  }
                  // set week table
                  // if (last_week != week_now) {
                  //    markup = " <th class='" + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "' colspan='1' style='text-align:center;background: aliceblue;'>W-" + week_now + "</th>";
                  //    $('#table-basic thead').find(".week").prepend(markup);
                  //    last_week = week_now;
                  // } else {
                  //    var last_att_col = parseInt($('#table-basic thead').find(".week").find("." + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).attr('colspan')) + 1;
                  //    $('#table-basic thead').find(".week").find("." + (week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY'))).attr('colspan', last_att_col);
                  // }

                  // set day table  
                  let holiday = get_data_holiday(currDate.format('YYYYMMDD'));
                  if (currDate.format('d') == 0) {
                     if (holiday != "") {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + " text-danger' style='text-align:center;max-width:100px;min-width:100px;background: lavender;' data-bs-toggle='tooltip' data-bs-placement='top' title='" + holiday["deskripsi"] + "'>" + day_now + "</th>";
                     } else {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + " text-danger' style='text-align:center;max-width:100px;min-width:100px;background: lavender;'>" + day_now + "</th>";
                     }
                  } else {
                     if (holiday != "") {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + " text-danger' style='text-align:center;max-width:100px;min-width:100px;background:lavenderblush' data-bs-toggle='tooltip' data-bs-placement='top' title='" + holiday["deskripsi"] + "'>" + day_now + "</th>";
                     } else {
                        markup = " <th class='" + (day_now + "-" + week_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "' style='text-align:center;max-width:100px;min-width:100px;'>" + day_now + "</th>";
                     }
                  }

                  $('#table-basic thead').find(".day").prepend(markup);
                  last_day = day_now;

                  // set day cell
                  markup = " <td class='" + (day_now + "-" + currDate.format('MM') + "-" + currDate.format('YYYY')) + "' style='text-align:center;max-width:100px;min-width:100px;width:100px'></td>";
                  $(markup).insertAfter($('#table-basic tbody').find(".sub").find(".th-project"));
               }

               $("[data-bs-toggle='tooltip']").tooltip();
               $(".table-basic").freezeTable({
                  'columnNum': 2,
               });
               load_table();
            };

            function remove_table() {
               $("#table-basic thead tr.month").each(function() {
                  $(this).find("th").each(function(index) {
                     if (index > 1) $(this).remove();
                  });
               });
               $("#table-basic thead tr.week").each(function() {
                  $(this).children("th").remove();
               });
               $("#table-basic thead tr.day").each(function() {
                  $(this).children("th").remove();
               });
               $("#table-basic tbody").each(function() {
                  $(this).remove();
               });
               $(".table-basic").freezeTable({
                  'columnNum': 2,
               });
            }


            load_table = function() {
               $("#table-basic tbody").each(function() {
                  $(this).remove();
               });
               $("#table-basic ").append('<tbody class="bg-light"></tbody>');
               if (ajax_req && ajax_req.readyState != 4) {
                  ajax_req.abort();
               }
               ajax_req = $.ajax({
                  type: "POST",
                  data: {
                     "startDate": StartDateContent.format('YYYY-MM-DD'),
                     "endDate": EndDateContent.format('YYYY-MM-DD'),
                     "divisi": comboTree3._selectedItems,
                     "search": $("#tb_search").val(),
                  },
                  url: "<?= site_url('function/client_data_tools/get_data_project') ?>",
                  success: function(data) {
                     data = JSON.parse(data);
                     var last_divisi = "";
                     var last_color = "";
                     for (var i = 0; i < data.length; i++) {
                        var badgeitem = "";
                        if (data[i]["subs"].length > 0) badgeitem = data[i]["subs"].length;
                        if (last_divisi != data[i]["divisi"]) {
                           var randomcolor = getColor();
                           var html = `<tr> 
                              <td>
                                 <span  class="badge p-2" style="color:black;background:${randomcolor}">${data[i]["divisi"]}</span>
                              </td>
                              <td style="vertical-align: middle;">  
                                 <span class="badge item-header text-truncate" style="color:black;background:${randomcolor};max-width:180px" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="${data[i]['title']}" data-class="sub-${data[i]["id"]}" data-open="false">
                                    <div class="d-inline-block icon-header"><i class="fas fa-arrow-circle-right"></i></div>  
                                    <span class="badge bg-primary">${badgeitem}</span>
                                    <span class="p-1  ">${data[i]["title"]}</span>
                                 </span> 
                              </td>`;
                           last_color = randomcolor;
                           last_divisi = data[i]["divisi"];
                        } else {
                           var html = `<tr > 
                              <td>
                                 <span class="badge p-2 " style="color:black;background:${last_color}"></span>
                              </td>
                              <td style="vertical-align: middle;"> 
                                 <span class="badge item-header text-truncate" style="color:black;background:${last_color};max-width:180px" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="${data[i]['title']}" data-class="sub-${data[i]["id"]}" data-open="false">
                                    <div class="d-inline-block icon-header"><i class="fas fa-arrow-circle-right"></i></div>  
                                    <span class="badge bg-primary">${badgeitem}</span>
                                    <span class="p-1 ">${data[i]["title"]}</span>
                                 </span> 
                              </td>`;
                        }


                        var currDate = moment(StartDateContent).subtract(1, 'days').startOf('day');
                        var lastDate = moment(EndDateContent).add(1, 'days').startOf('day');
                        var isCol = 0;

                        while (currDate.add(1, 'days').diff(lastDate) < 0) {
                           if (moment(data[i]["startdate"]).format("YYYYMMDD") <= moment(currDate).format("YYYYMMDD") &&
                              moment(data[i]["enddate"]).format("YYYYMMDD") >= moment(currDate).format("YYYYMMDD")) {
                              if (isCol == 0) {
                                 var html_title = `Tanggal Project<br>
                                                   <b>${moment(data[i]["startdate"]).format("DD MMM YYYY")} <i class='fas fa-arrow-right'></i> ${moment(data[i]["enddate"]).format("DD MMM YYYY")}</b><br>
                                                   Batas Waktu Project<br>
                                                   <b>${moment(data[i]["enddate"]).diff(moment(), 'days')} hari tersisa</b><br>
                                                   Persentase<br>
                                                   <b>${data[i]["persentase"]}%</b><br>
                                                   Status<br>
                                                   <b class='text-capitalize'>${data[i]["status"]}</b>
                                                   `;
                                 html += `<td class="project-${data[i]["id"]}">
                                             <div class="d-block w-100 px-2 rounded project-list" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${html_title}" 
                                             style="background:${last_color};border: 1px solid RGBA(0,0,0,0.05);border-bottom: 2px solid RGBA(0,0,0,0.25);">
                                                <span class="text-truncate fw-bold m-2" style="font-size:0.65rem">
                                                   <div class="btn-group action-project btn-group-sm rounded" role="group" aria-label="Button group with nested dropdown">
                                                      <button type="button" class="btn btn-light py-1 text-truncate sub-btn text-warning" onclick="show_click(` + data[i]["id"] + `)" style="font-size:0.60rem; background-color: transparent;"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                                                      <button type="button" class="btn btn-light  py-1 sub-btn text-danger" onclick="delete_click(` + data[i]["id"] + `)" style="font-size:0.60rem; background-color: transparent;"><i class="fas fa-times" aria-hidden="true"></i></button>
                                                   </div>
                                                   ${data[i]["title"]}
                                                </span> 
                                             </div>
                                          </td>`;
                              } else {
                                 html += `<td class="project-remove"></td>`;
                              }
                              isCol++;
                           } else {
                              let holiday = get_data_holiday(currDate.format('YYYYMMDD'));
                              var classDate = "";
                              if (currDate.format('d') == 0) {
                                 classDate = "day-week";
                              } else if (holiday != "") {
                                 classDate = "day-holiday";
                              }
                              html += `<td class="${classDate}"></td>`;
                           }
                        }

                        html += `</tr>`;
                        $('#table-basic tbody').append(html);
                        $(".project-remove").each(function() {
                           $(this).remove();
                        });
                        $(`.project-${data[i]["id"]}`).attr('colspan', isCol);

                        var subs_list = data[i]["subs"];
                        for (var j = 0; j < subs_list.length; j++) {
                           var subhtml = `<tr class="sub-${data[i]["id"]}" style="display:none"> 
                              <td> </td>
                              <td>
                                 <div class="list-sub-project">
                                    <span  class="badge px-2 text-truncate" style="color:black;background:${randomcolor}" data-bs-toggle="tooltip" data-bs-placement="top" title="${subs_list[j]['title']}">${subs_list[j]["title"]}</span>
                                 </div>
                              </td>`;
                           var currDate = moment(StartDateContent).subtract(1, 'days').startOf('day');
                           var lastDate = moment(EndDateContent).add(1, 'days').startOf('day');
                           var isCol = 0;
                           while (currDate.add(1, 'days').diff(lastDate) < 0) {
                              let holiday = get_data_holiday(currDate.format('YYYYMMDD'));
                              var classDate = "";
                              if (currDate.format('d') == 0) {
                                 classDate = "day-week";
                              } else if (holiday != "") {
                                 classDate = "day-holiday";
                              }

                              if (moment(subs_list[j]["startdate"]).format("YYYYMMDD") <= moment(currDate).format("YYYYMMDD") &&
                                 moment(subs_list[j]["enddate"]).format("YYYYMMDD") >= moment(currDate).format("YYYYMMDD")) {
                                 if (isCol == 0) {
                                    subhtml += `<td class=" project-${subs_list[j]["id"]}">
                                       <div class="d-block w-100 px-2 rounded project-sub-list" style="background:${last_color};border: 1px solid RGBA(0,0,0,0.05);">
                                          <span class="text-truncate fw-bold" style="font-size:0.65rem"> 
                                             <i class="fas fa-pencil-alt ps-1 action-project text-warning" aria-hidden="true" onclick="edit_sub_click(` + data[i]["id"] + `)"></i>
                                             <i class="fas fa-times  pe-1 action-project text-danger" aria-hidden="true" onclick="delete_sub_click(` + data[i]["id"] + `)"></i> 
                                             <i class="fas fa-circle px-2" style="font-size:0.35rem"></i>
                                             ${subs_list[j]["title"]}
                                          </span>
                                       </div>
                                    </td>`;
                                 } else {
                                    subhtml += `<td class="  project-remove"></td>`;
                                 }
                                 isCol++;
                              } else {
                                 subhtml += `<td class="${classDate}"></td>`;
                              }
                           }

                           subhtml += `</tr>`;
                           if (isCol > 0) {
                              $('#table-basic tbody').append(subhtml);
                              $(".project-remove").each(function() {
                                 $(this).remove();
                              });
                              $(`.project-${subs_list[j]["id"]}`).attr('colspan', isCol);
                           }

                        }

                        $(".table-basic").freezeTable({
                           'columnNum': 2,
                        });

                     }

                     $("[data-bs-toggle='tooltip']").tooltip();
                     $(".project-list").hover(function() {
                        $(this).find(".action-project").css("display", "none");
                     }).mouseover(function() {
                        $(this).find(".action-project").css("display", "inline-block");
                     });
                     $(".project-sub-list").hover(function() {
                        $(this).find(".action-project").css("display", "none");
                     }).mouseover(function() {
                        $(this).find(".action-project").css("display", "inline-block");
                     });

                     $(".item-header").each(function() {
                        $(this).click(function() {
                           let ElClass = $(this).data("class");
                           if ($(this).data("open")) {
                              $(this).data("open", false);
                              $("." + ElClass).hide("fast");
                              $(this).find("i").removeClass();
                              $(this).find("i").addClass("fas fa-arrow-circle-right");
                              //fas fa-arrow-circle-right
                           } else {
                              $(this).data("open", true);
                              $("." + ElClass).show("slow");
                              $(this).find("i").removeClass();
                              $(this).find("i").addClass("fas fa-arrow-circle-down");
                           }
                        })
                     });
                  }
               });

            }
            Date_content(StartDateContent, EndDateContent);

            var lastScrollLeft = 0;
            $('.table-basic').on('scroll', function() {
               var documentScrollLeft = this.scrollLeft;

               if (lastScrollLeft != documentScrollLeft) {
                  lastScrollLeft = documentScrollLeft;

                  // const rect = ($(".project-116")[0]).getBoundingClientRect();
                  // console.log((rect.left + window.scrollX), " - ", rect.top + window.scrollY); 
                  var maxwidth = parseInt(this.scrollWidth - $(this).width());
                  var elscrool = this;
                  $("#table-basic .header-month").each(function() {
                     const rect = this.getBoundingClientRect();
                     let intScrollLeft = ($("#col-divisi").width() + $("#col-project").width() + 79) - (rect.left + window.scrollX);
                     if (intScrollLeft >= 0 && intScrollLeft < $(this).parent().width() - $(this).children().width() - 20)
                        $(this).children().css("margin-left", intScrollLeft);
                  });
                  $(".project-list").each(function() {
                     const rect = this.getBoundingClientRect();
                     let intScrollLeft = ($("#col-divisi").width() + $("#col-project").width() + 79) - (rect.left + window.scrollX);
                     if (intScrollLeft >= 0 && intScrollLeft <= $(this).parent().width() - $(this).children().width() - 20)
                        $(this).children().css("cssText", "margin-left: " + intScrollLeft + "px !important;font-size:0.65rem");
                     if (intScrollLeft < 0) $(this).children().css("cssText", "margin-left: 0px !important;font-size:0.65rem");
                  });
                  $(".project-sub-list").each(function() {
                     const rect = this.getBoundingClientRect();
                     let intScrollLeft = ($("#col-divisi").width() + $("#col-project").width() + 79) - (rect.left + window.scrollX);
                     if (intScrollLeft >= 0 && intScrollLeft <= $(this).parent().width() - $(this).children().width() - 20)
                        $(this).children().css("cssText", "margin-left: " + intScrollLeft + "px !important;font-size:0.65rem");
                     if (intScrollLeft < 0) $(this).children().css("cssText", "margin-left: 0px !important;font-size:0.65rem");
                  });

                  if (maxwidth <= this.scrollLeft) {
                     var startDate = moment(EndDateContent).add(1, 'days');
                     EndDateContent = moment(EndDateContent).add(10, 'days');
                     add_after_table(startDate, EndDateContent);

                     $('#tb_date').data('daterangepicker').setStartDate(StartDateContent);
                     $('#tb_date').data('daterangepicker').setEndDate(EndDateContent);

                     console.log("add after from scroll");
                  } else if (this.scrollLeft == 0) {
                     console.log("add before from scroll");
                     var endDate = moment(StartDateContent).subtract(1, 'days');
                     // StartDateContent = moment(StartDateContent).subtract(1, 'M').startOf('month');
                     StartDateContent = moment(StartDateContent).subtract(10, 'days');
                     add_before_table(StartDateContent, endDate);

                     $('#tb_date').data('daterangepicker').setStartDate(StartDateContent);
                     $('#tb_date').data('daterangepicker').setEndDate(EndDateContent);
                  }
               }
            });


            $("#tbl_search").on("keyup", function() {
               var value = $(this).val().toLowerCase();
            });

            delete_click = function(id) {
               if (!req_status) {
                  const swalWithBootstrapButtons = Swal.mixin({
                     customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-secondary mx-1'
                     },
                     buttonsStyling: false
                  });
                  swalWithBootstrapButtons.fire({
                     title: "Hapus Project",
                     html: '<h4 style="color: red;">Project dan Progresnya akan dihapus</h4>, Anda yakin ingin melanjutkan ?',
                     icon: "warning",
                     allowOutsideClick: false,
                     allowEscapeKey: false,
                     showCancelButton: true,
                     confirmButtonText: "Lanjutkan",
                     cancelButtonText: "Tidak",
                     reverseButtons: false
                  }).then((result) => {
                     if (result.isConfirmed) {
                        $.ajax({
                           method: "POST",
                           url: "<?= base_url() ?>function/client_data_tools/plainProjectDelete",
                           data: {
                              id: id
                           },
                           before: function() {
                              req_status_add = 1;
                           },
                           success: function(data) {
                              Swal.fire({
                                 icon: 'success',
                                 text: 'Hapus data berhasil',
                                 showConfirmButton: false,
                                 allowOutsideClick: false,
                                 allowEscapeKey: false,
                                 timer: 1500,
                              });
                           }
                        });
                        load_table();
                        Date_content(StartDateContent, EndDateContent);
                     }

                  });
               }
            }
            delete_sub_click = function(id) {
               if (!req_status) {
                  const swalWithBootstrapButtons = Swal.mixin({
                     customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-secondary mx-1'
                     },
                     buttonsStyling: false
                  });
                  swalWithBootstrapButtons.fire({
                     title: "Hapus Progres",
                     html: 'Anda yakin ingin menghapus progres ini ?',
                     icon: "warning",
                     allowOutsideClick: false,
                     allowEscapeKey: false,
                     showCancelButton: true,
                     confirmButtonText: "Lanjutkan",
                     cancelButtonText: "Tidak",
                     reverseButtons: false
                  }).then((result) => {
                     if (result.isConfirmed) {
                        $.ajax({
                           method: "POST",
                           url: "<?= base_url() ?>function/client_data_tools/progresDelete",
                           data: {
                              id: id
                           },
                           before: function() {
                              req_status_add = 1;
                           },
                           success: function(data) {
                              Swal.fire({
                                 icon: 'success',
                                 text: 'Hapus data berhasil',
                                 showConfirmButton: false,
                                 allowOutsideClick: false,
                                 allowEscapeKey: false,
                                 timer: 1500,
                              });
                           }
                        });
                        load_table();
                        Date_content(StartDateContent, EndDateContent);
                     }

                  });
               }
            }

            $('#btn-add-master').click(function(e) {
               e.preventDefault();
               if (!req_status) {
                  $.ajax({
                     url: "<?php echo site_url('message/message_tools/data_plain_project_add') ?>",
                     beforeSend: function() {
                        req_status = 1;
                     },
                     success: function(response) {
                        $("#dialog-box").html(response);
                        modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                        modal_action.show();
                        req_status = 0;
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        req_status = 0;
                     }
                  });
               }

               load_data_table = function() {
                  modal_action.hide();
                  load_table();
                  Date_content(StartDateContent, EndDateContent);
               }
            });

            show_click = function(id) {
               if (!req_status) {
                  $.ajax({
                     url: "<?php echo site_url('message/message_tools/data_plain_project_show/') ?>" + id + "",
                     type: "POST",
                     data: {
                        id: id
                     },
                     beforeSend: function() {
                        req_status = 1;
                     },
                     success: function(response) {
                        $("#dialog-box").html(response);
                        modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                        modal_action.show();
                        req_status = 0;
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        req_status = 0;
                     }
                  });
               }
            }
            edit_sub_click = function(id) {
               if (!req_status) {
                  $.ajax({
                     url: "<?php echo site_url('message/message_tools/data_progres_project_edit/') ?>" + id + "",
                     type: "POST",
                     data: {
                        id: id
                     },
                     beforeSend: function() {
                        req_status = 1;
                     },
                     success: function(response) {
                        $("#dialog-box").html(response);
                        modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                        modal_action.show();
                        req_status = 0;
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        req_status = 0;
                     }
                  });
               }
            }
            load_table();
            Date_content(StartDateContent, EndDateContent);
            
			   $(window).trigger('resize');
            if ($(window).width() < 575) {
					$("#content").width("100%");
				} else {
					$("#content").width($(window).width() - $('#sidebar').width());
				}
         });

      </script>
</body>

</html>