<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Edit Project</h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Judul Project</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="PlainProjectTitle" value="<?= $_plainProject->PlainProjectTitle ?>" placeholder="Masukan nama project">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSmDivisi" class="col-sm-3 col-form-label col-form-label-sm">Divisi</label>

                    <div class="col-sm-9">
                        <select class="form-select form-select-sm" id="MsEmpPositionId" aria-label=".form-select-sm example">
                            <?php
                            $query = $this->db->get('TblMsEmployeePosition');
                            foreach ($query->result() as $row) {
                                echo "<option value='$row->MsEmpPositionId' " . ($_plainProject->MsEmpPositionId == $row->MsEmpPositionId ? "selected" : "") . ">$row->MsEmpPositionName</option>";
                            }
                            ?>
                        </select>
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
    var StartDateEdit = moment('<?= $_plainProject->PlainProjectStartDate ?>');
    var EndDateEdit = moment('<?= $_plainProject->PlainProjectEndDate ?>');
    $('#AbsenDate').daterangepicker({
        startDate: StartDateEdit,
        endDate: EndDateEdit,
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            "format": 'DD/MM/YYYY HH:mm:ss',
        }
    }, Date_content);
    Date_content(StartDateEdit, EndDateEdit);

    function Date_content(start, end) {
        $('#tb_date').val(start.format('DD/MM/YYYY HH:mm:ss') + ' - ' + end.format('DD/MM/YYYY HH:mm:ss'));
        StartDateEdit = start;
        EndDateEdit = end;
    }
    $('#btn-submit').click(function() {

        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_tools/plainProjectEdit") ?>",
            data: {
                title: $("#PlainProjectTitle").val(),
                divisi: $("#MsEmpPositionId").val(),
                start: StartDateEdit.format('YYYY-MM-DD HH:mm:ss'),
                end: EndDateEdit.format('YYYY-MM-DD HH:mm:ss'),
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
                    }
                });
            }
        })

    })
</script>