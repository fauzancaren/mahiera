<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Detail Project</h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row my-3 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Planing Project</span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">

                                    <label for="colFormLabelSmTitle" class="col-sm-4 col-form-label col-form-label-sm">Judul Project</label>

                                    <div class="col-sm-8 customform">
                                        <input type="text" class="form-control-plaintext" id="PlainProjectTitle" value="<?= $_plainProject->PlainProjectTitle ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="colFormLabelSmTitle" class="col-sm-4 col-form-label col-form-label-sm">Dikerjakan Oleh Tim </label>

                                    <div class="col-sm-8">
                                        <select class="form-select form-select-sm" id="MsDivisiId" aria-label=".form-select-sm example">
                                            <?php
                                            $query = $this->db->get('TblMsDivisi');
                                            foreach ($query->result() as $row) {
                                                echo "<option value='$row->MsDivisiId' " . ($_plainProject->MsDivisiId == $row->MsDivisiId ? "selected" : "") . ">$row->MsDivisiName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row my-3 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Estimasi Project</span>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Projek dimulai</label>

                                    <div class="col-sm-8">
                                        <small id="startExtendView"><?= date('d F Y - H:i:s.a', strtotime($_plainProject->PlainProjectStartDate)) ?></small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Projek Selesai</label>

                                    <div class="col-sm-8">
                                        <small id="endExtendView"><?= date('d F Y H:i:s.a', strtotime($_plainProject->PlainProjectEndDate)) ?></small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="colFormLabelSmTitle" class="col-sm-4 col-form-label col-form-label-sm">Batas Waktu Project</label>

                                    <div class="col-8 demoText" id="demo">

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Status</label>
                                    <div class="col-sm-8">
                                        <?php
                                        if ($_plainProject->PlainProjectStatus === "proses") {
                                            echo '<span class="badge bg-primary">Progres</span>';
                                        } else if ($_plainProject->PlainProjectStatus == "finish") {
                                            echo '<span class="badge bg-success">Selesai</span>';
                                        } else if ($_plainProject->PlainProjectStatus == "extend") {
                                            echo '<span class="badge bg-danger">Project Diperpanjang</span>';
                                        } else {
                                            echo '<span class="badge bg-warning">Persiapan</span>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="colFormLabelSmTitle" class="col-sm-4 col-form-label col-form-label-sm">Persentase Project</label>
                                    <div class="col-2 customform">
                                        <?php
                                        // if ($_plainProject->PlainProjectPersentase === null) {
                                        //     echo '<input type="number" name="PlainProjectPersentase" class="form-control-plaintext" value="0">';
                                        // } else {
                                        //     echo '<input type="number" name="PlainProjectPersentase" class="form-control-plaintext" value="' . $_plainProject->PlainProjectPersentase . '">';
                                        // }
                                        ?>
                                        <input type="number" id="PlainProjectPersentase" name="PlainProjectPersentase" class="form-control-plaintext" value="<?= $_plainProject->PlainProjectPersentase == null ? 0 : $_plainProject->PlainProjectPersentase; ?>">
                                    </div>
                                    <strong class="col-1">%</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4 mt-3 gap-2">
                                <?php
                                if ($_plainProject->PlainProjectStatus === "finish") {
                                    echo '<button type="button" class="btn btn-info btn-sm" id="btn-cetak">Print</button>';
                                } else {
                                    echo '<button type="button" style="margin-right: 2px;" class="btn btn-primary btn-sm" onClick="btnExtend(' . $_plainProject->PlainProjectId . ')">Extend</button><button type="button" class="btn btn-success btn-sm" id="btn-finish">Finish</button>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-6" style="height: 500px; overflow: auto;">
                        <div class="row my-3 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Progresif</span>
                                <button class="btn btn-success btn-sm py-1 me-1 rounded-pill" onclick="add_progress()" type="button" style="position:absolute;top: 2rem;right: 0.90rem;font-size: 0.6rem;">
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                    <span class="fw-bold">
                                        &nbsp;Tambah
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <ul class="list-group" id="progress-list">
                                <!-- isi data progress -->
                            </ul>
                        </div>
                    </div>
                </div>

                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog-extend">
    <script>
        var countDownDate = new Date("<?= $_plainProject->PlainProjectEndDate; ?>").getTime();
        var x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate - now;
                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                // var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                // var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = `
                <div class="row">
                <div class="col-6">
                <span class="fw-bold">Project Expired</span>
                </div>
                </div>
                `
                } else {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = `<span class="badge bg-warning text-dark"> ` + days + ` hari, ` + hours + ` Jam Tersisa</span>`;

                }
            },
            1000);


        var StartDateView = moment('<?= $_plainProject->PlainProjectStartDate ?>');
        var EndDateView = moment('<?= $_plainProject->PlainProjectEndDate ?>');
        $('#AbsenDate').daterangepicker({
            startDate: StartDateView,
            endDate: EndDateView,
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                "format": 'DD/MM/YYYY HH:mm:ss',
            }
        });
        Date_content(StartDateView, EndDateView);

        function Date_content(start, end) {
            $('#AbsenDate').val(start.format('DD/MM/YYYY HH:mm:ss') + ' - ' + end.format('DD/MM/YYYY HH:mm:ss'));
            StartDateView = start;
            EndDateView = end;
        }

        btnExtend = function(id) {
            if (typeof window.ajaxRequestSingle !== "undefined") {
                window.ajaxRequestSingle.abort();
            }

            window.ajaxRequestSingle = $.ajax({
                method: "POST",
                url: "<?= site_url("message/message_tools/data_plain_project_extend/") ?>" + id,
                success: function(data) {
                    $("#dialog-extend").html(data);
                    $("#modal-action").modal("hide");
                    $("#modal-action-extend").modal("show");
                    $("#modal-action-extend").on("hidden.bs.modal", function() {
                        $("#modal-action").modal("show");
                    });
                }
            });
        };

        var req_status_add = 0;

        $("#btn-submit").click(async function() {
            if (!req_status_add) {
                $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');

                for (var i = 0; data_progresif.length > i; i++) {
                    if (data_progresif[i]["PlainProjectProgresTitle"] == "") {
                        Swal.fire({
                            icon: 'error',
                            text: 'Judul Progres tidak boleh kosong, harap lengkapi terlebih dahulu !',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 1500
                        });
                        $("#btn-submit").html("Simpan");
                        return false;
                    }
                    if (data_progresif[i]["PlainProjectProgresDesk"] == "") {
                        Swal.fire({
                            icon: 'error',
                            text: 'Deskripsi Progres tidak boleh kosong, harap lengkapi terlebih dahulu !',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 1500
                        });
                        $("#btn-submit").html("Simpan");
                        return false;
                    }
                }

                var detailProgresif = [];
                for (var i = 0; data_progresif.length > i; i++) {
                    var data = {
                        "PlainProjectProgresTitle": data_progresif[i]["PlainProjectProgresTitle"],
                        "PlainProjectProgresDesk": data_progresif[i]["PlainProjectProgresDesk"],
                        "PlainProjectProgresStart": data_progresif[i]["PlainProjectProgresStart"],
                        "PlainProjectProgresEnd": data_progresif[i]["PlainProjectProgresEnd"],
                        "PlainProjectProgresRef": <?= $_plainProject->PlainProjectId ?>,
                    };
                    detailProgresif.push(data);
                }

                var detailProject = {
                    "PlainProjectTitle": $("#PlainProjectTitle").val(),
                    "MsDivisiId": parseInt($("#MsDivisiId").val()),
                    "PlainProjectPersentase": $("#PlainProjectPersentase").val(),
                };

                $.ajax({
                    method: "POST",
                    url: "<?= site_url("function/client_data_tools/plainProjectDetailEdit/") . $_plainProject->PlainProjectId ?>",
                    data: {
                        "progresif": detailProgresif,
                        "project": detailProject,
                    },
                    before: function() {
                        req_status_add = 1;
                    },
                    success: function(data) {
                        req_status_add = 0;
                        $("#btn-submit").html("Simpan");
                        console.log(data);
                        Swal.fire({
                            icon: 'success',
                            text: 'Edit data berhasil',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 1500,
                        })
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            text: err,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 1500
                        });
                    }
                });

            }
            modal_action.hide();
            load_table();
        });

        // end validasi

        $('#btn-finish').click(function() {
            var req_status = 0;
            if (!req_status) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-secondary mx-1'
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "finish the project",
                    html: 'Yakin Project Sudah Final? ? ?',
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
                            url: "<?= site_url("function/Client_data_tools/plainProjectFinish/") ?>",
                            data: {
                                id: <?= $_plainProject->PlainProjectId ?>
                            },
                            before: function() {
                                req_status_add = 1;
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: 'success',
                                    text: 'the project has been completed',
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    timer: 1500,
                                });
                            }
                        });
                    }
                });
            }
        })

        // bagian progresif 
        var data_exist = <?= JSON_ENCODE($_plainProjectProgres) ?>;
        var data_progresif = []; // PlainProjectProgresTitle, PlainProjectProgresDesk, PlainProjectProgresStart, PlainProjectProgresEnd
        $.each(data_exist, function(key, val) {
            data_progresif.push({
                "PlainProjectProgresTitle": val["PlainProjectProgresTitle"],
                "PlainProjectProgresDesk": val["PlainProjectProgresDesk"],
                "PlainProjectProgresStart": val["PlainProjectProgresStart"],
                "PlainProjectProgresEnd": val["PlainProjectProgresEnd"],
                "PlainProjectProgresRef": <?= $_plainProject->PlainProjectId ?>,
            });
        });

        var data_ex = <?= json_encode($_plainProject) ?>;
        var data_project = [];
        $.each(data_ex, function(key, val) {
            data_project.push({
                "PlainProjectTitle": val["PlainProjectTitle"],
                "MsDivisiId": val["MsDivisiId"],
                "PlainProjectPersentase": val["PlainProjectPersentase"]
            });
        });

        function load_list_progress() {

            // load data input progress ke modal
            var html_list = "";
            $.each(data_progresif, function(key, val) {
                html_list += `<li class="list-group-item progres">
                            <div class="row mb-1">
                                <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Progress</label>
                                <div class="col-sm-9">
                                    <input type="text" name="PlainProjectProgresTitle" data-index="` + key + `" class="form-control form-control-sm" value="` + val["PlainProjectProgresTitle"] + `">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea type="text" id="PPD" name="PlainProjectProgresDesk" data-index="` + key + `" class="form-control form-control-sm" value="">` + val["PlainProjectProgresDesk"] + `</textarea>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Mulai / Selesai</label>
                                <div class="col-sm-9">
                                    <input type="text" name="PlainProjectProgresDate" data-index="` + key + `" data-start = "` + val["PlainProjectProgresStart"] + `" data-end ="` + val["PlainProjectProgresEnd"] + `" class="form-control form-control-sm" value="` + val["PlainProjectProgresStart"] + ` - ` + val["PlainProjectProgresEnd"] + `">
                                </div>
                            </div>
                            <div class="col-1 action-progres" style="display:none">
                                <div class="d-flex flex-column h-100 text-center" >
                                     <a onclick="sm_delete(` + key + `)" class="text-secondary pointer flex-fill" title="View Data"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                        </li>`;
            });
            if (html_list == "") {
                $("#progress-list").html(`<small class="list-group-item mb-1">Project belum ada progres !</small>`);
            } else {
                $("#progress-list").html(html_list);
            }

            $(".progres").each(function() {
                $(this).hover(
                    function() {
                        $(this).find(".action-progres").show("300");
                    },
                    function() {
                        $(this).find(".action-progres").hide();
                    }
                );
            });

            $('input[name^="PlainProjectProgresTitle"]').each(function() {
                $(this).change(function() {
                    data_progresif[$(this).data("index")]["PlainProjectProgresTitle"] = $(this).val();
                })
            });

            $('textarea#PPD').each(function() {
                $(this).change(function() {
                    data_progresif[$(this).data("index")]["PlainProjectProgresDesk"] = $(this).val();
                })
            });
            $('input[name^="PlainProjectProgresDate"]').each(function() {
                let obj = $(this).data();
                $(this).daterangepicker({
                    parentEl: "#modal-action .modal-body",
                    startDate: moment($(this).data("start")),
                    endDate: moment($(this).data("end")),
                    minDate: StartDateView,
                    maxDate: EndDateView,
                    timePicker: true,
                    timePicker24Hour: true,
                    drops: "auto",
                    opens: "left",
                    locale: {
                        "format": 'DD/MM/YYYY HH:mm:ss',
                    }
                }, function(start, end, label) {
                    $(this).val(start.format('DD/MM/YYYY HH:mm:ss') + ' - ' + end.format('DD/MM/YYYY HH:mm:ss'));
                    data_progresif[obj["index"]]["PlainProjectProgresStart"] = start.format('YYYY-MM-DD HH:mm:ss');
                    data_progresif[obj["index"]]["PlainProjectProgresEnd"] = end.format('YYYY-MM-DD HH:mm:ss');
                });
            })
        }
        load_list_progress();

        function sm_delete(index) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: "Hapus Progres!",
                html: "apakah anda yakin ingin menghapus Progres ini!",
                icon: "warning",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonText: "Lanjutkan",
                cancelButtonText: "Tidak",
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    data_progresif.splice(index, 1);
                    load_list_progress();
                }
            })
        }

        function add_progress() {
            data_progresif.push({
                "PlainProjectProgresTitle": "",
                "PlainProjectProgresDesk": "",
                "PlainProjectProgresStart": moment().format('YYYY-MM-DD HH:mm:ss'),
                "PlainProjectProgresEnd": moment().format('YYYY-MM-DD HH:mm:ss'),
                "PlainProjectProgresRef": <?= $_plainProject->PlainProjectId ?>,
            });
            load_list_progress();
        }
    </script>