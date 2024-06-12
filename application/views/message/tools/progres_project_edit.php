<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Edit Progres</h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Judul Progres</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="PlainProjectProgresTitle" value="<?= $_plainProjectProgres->PlainProjectProgresTitle ?>" placeholder="Masukan nama project">
                        <input type="hidden" class="form-control form-control-sm" id="PlainProjectProgresId" value="<?= $_plainProjectProgres->PlainProjectProgresId ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Deskripsi</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" placeholder="MAsukan Deskripsi Progres" id="PlainProjectProgresDesk"><?= $_plainProjectProgres->PlainProjectProgresDesk ?></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Mulai / Selesai</label>
                    <div class="col-sm-9">
                        <input type="text" id="AbsenDate" name="AbsenDate" class="form-control form-control-sm" value="">
                    </div>
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
    var StartDateProject = moment('<?= $_plainProject->PlainProjectStartDate ?>');
    var EndDateProject = moment('<?= $_plainProject->PlainProjectEndDate ?>');
    var StartDateAdd = moment('<?= $_plainProjectProgres->PlainProjectProgresStart ?>');
    var EndDateAdd = moment('<?= $_plainProjectProgres->PlainProjectProgresEnd ?>');
    $('#AbsenDate').daterangepicker({
        startDate: StartDateAdd,
        endDate: EndDateAdd,
        minDate: StartDateProject,
        maxDate: EndDateProject,
        locale: {
            "format": 'DD MMM YYYY',
        }
    }, Date_content_add);
    Date_content_add(StartDateAdd, EndDateAdd);

    function Date_content_add(start, end) {
        $('#AbsenDate').val(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        StartDateAdd = start;
        EndDateAdd = end;
    }

    $('#btn-submit').click(function() {
        if ($("#PlainProjectProgresTitle").val() == "") {
            Swal.fire(
                'Kesalahan Proses data!',
                'Masukan nama progres terlebih dahulu...!',
                'error'
            );
            return false;
        }
        if ($("#PlainProjectProgresDesk").val() == "") {
            Swal.fire(
                'Kesalahan Proses data!',
                'Masukan Keterangan progres dahulu...!',
                'error'
            );
            return false;
        }

        var id = $("#PlainProjectProgresId").val();
        var title = $("#PlainProjectProgresTitle").val();
        var deskripsi = $("#PlainProjectProgresDesk").val();
        var start = StartDateAdd.format('YYYY-MM-DD 00:00:00');
        var end = EndDateAdd.format('YYYY-MM-DD 23:59:59');
        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_tools/plainProjectProgresEdit") ?>",
            data: {
                id: id,
                title: title,
                deskripsi: deskripsi,
                start: start,
                end: end
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
                        modal_action.hide();
                        load_table();
                        Date_content(StartDateContent, EndDateContent);
                    }
                });
            }
        })

    })
</script>