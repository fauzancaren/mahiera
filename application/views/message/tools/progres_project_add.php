<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Progres</h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Project</label>
                    <div class="col-sm-9">
                        <input type="hidden" class="form-control form-control-sm" id="PlainProjectProgresRef" value="<?= $_plainProject->PlainProjectId ?>">
                        <strong><?= $_plainProject->PlainProjectTitle ?></strong>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Progres</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="PlainProjectProgresTitle" placeholder="masukan point progres.." required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Deskripsi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="PlainProjectProgresDesk" placeholder="masukan keterangan progres..">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Mulai / Selesai</label>
                    <div class="col-sm-9">
                        <input type="text" id="AbsenDate" name="AbsenDate" class="form-control form-control-sm" value="">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Persentase keseluruhan</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control form-control-sm" id="PlainProjectPersentase" value="<?= $_plainProject->PlainProjectPersentase ?>">
                    </div>
                    <h4 class="col-1">%</h4>
                </div>


                <div class=" modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var StartDateContent = moment();
    var EndDateContent = moment();
    $('#AbsenDate').daterangepicker({
        startDate: StartDateContent,
        endDate: EndDateContent,
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            "format": 'DD/MM/YYYY HH:mm:ss',
        }
    }, Date_content);
    Date_content(StartDateContent, EndDateContent);

    function Date_content(start, end) {
        $('#tb_date').val(start.format('DD/MM/YYYY HH:mm:ss') + ' - ' + end.format('DD/MM/YYYY HH:mm:ss'));
        StartDateContent = start;
        EndDateContent = end;
    }
    $('#btn-submit').click(function() {
        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_tools/PlainProjectProgresAdd") ?>",
            data: {
                title: $("#PlainProjectProgresTitle").val(),
                deskripsi: $("#PlainProjectProgresDesk").val(),
                start: StartDateContent.format('YYYY-MM-DD HH:mm:ss'),
                end: EndDateContent.format('YYYY-MM-DD HH:mm:ss'),
                persen: $("#PlainProjectPersentase").val(),
                ref: <?= $_plainProject->PlainProjectId ?>
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
                    }
                });
            }
        })

    })
</script>