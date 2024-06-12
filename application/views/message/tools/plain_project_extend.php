<div class="modal fade " id="modal-action-extend" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Waktu Project</h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-4 col-form-label col-form-label-sm">Project Name</label>
                    <div class="col-sm-8">
                        <strong><?= $_plainProject->PlainProjectTitle ?></strong>
                    </div>
                </div>
                <!-- <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Projek Dimulai</label>
                    <div class="col-sm-8">
                        <small><?= date('d F Y H:i:s.a', strtotime($_plainProject->PlainProjectStartDate)) ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Projek Selesai</label>
                    <div class="col-sm-8">
                        <small><?= date('d F Y H:i:s.a', strtotime($_plainProject->PlainProjectEndDate)) ?></small>
                    </div>
                </div> -->

                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Mulai / Selesai</label>
                    <div class="col-sm-9">
                        <input type="text" id="AbsenDate" name="AbsenDate" class="form-control form-control-sm" value="">
                    </div>
                </div>

                <div class=" modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-submit-action">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var StartDateExtend = moment('<?= $_plainProject->PlainProjectStartDate ?>');
    var EndDateExtend = moment('<?= $_plainProject->PlainProjectEndDate ?>');
    $('#AbsenDate').daterangepicker({
        startDate: StartDateExtend,
        endDate: EndDateExtend,
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            "format": 'DD/MM/YYYY HH:mm:ss',
        }
    }, Date_content);
    Date_content(StartDateExtend, EndDateExtend);

    function Date_content(start, end) {
        $('#AbsenDate').val(start.format('DD/MM/YYYY HH:mm:ss') + ' - ' + end.format('DD/MM/YYYY HH:mm:ss'));
        StartDateExtend = start;
        EndDateExtend = end;
    }
    $('#btn-submit-action').click(function() {
        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_tools/plainProjectExtend") ?>",
            data: {
                start: StartDateExtend.format('YYYY-MM-DD HH:mm:ss'),
                end: EndDateExtend.format('YYYY-MM-DD HH:mm:ss'),
                id: <?= $_plainProject->PlainProjectId ?>
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    text: 'Simpan data berhasil',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 1500,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        load_data_table();
                        $("#modal-action-extend").modal("hide");
                        $('#startExtendView').html(StartDateExtend.format('D MMMM YYYY HH:mm:ss'));
                        $('#endExtendView').html(EndDateExtend.format('D MMMM YYYY HH:mm:ss'));


                    }
                });
            }
        })

    })
</script>