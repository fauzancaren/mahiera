<div class="modal modal-lg fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Asset Property</h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                <!-- <div class="row mb-3">
                    <label for="colFormLabelSmGrai" class="col-sm-3 col-form-label col-form-label-sm">Asset Divisi</label>

                    <div class="col-sm-9">
                        <select class="form-select form-select-sm" id="assetDivisiId" aria-label=".form-select-sm example">
                            <?php
                            $query = $this->db->get('TblAssetDivisi');
                            foreach ($query->result() as $row) {
                                echo "<option value='$row->assetDivisiId' " . ($_assetListing->assetDivisiIdRef == $row->assetDivisiId ? "selected" : "") . ">$row->assetDivisiCode - $row->assetDivisiName</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmDevice" class="col-sm-3 col-form-label col-form-label-sm">Device</label>

                    <div class="col-sm-9">
                        <select class="form-select form-select-sm" id="AssetId" aria-label=".form-select-sm example">
                            <?php
                            $query = $this->db->get('TblAsset');
                            foreach ($query->result() as $row) {
                                echo "<option value='$row->AssetId' " . ($_assetListing->AssetTypeRef == $row->AssetId ? "selected" : "") . ">$row->AssetName</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelMerk" class="col-sm-3 col-form-label col-form-label-sm">Merk Device</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="AssetDetailMerk" value="<?= $_assetListing->AssetDetailMerk ?>" placeholder="Masukan Merk Device">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmType" class="col-sm-3 col-form-label col-form-label-sm">Type</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" name="AssetDetailType" id="AssetDetailType" value="<?= $_assetListing->AssetDetailType ?>"></input>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmUser" class="col-sm-3 col-form-label col-form-label-sm">User</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="AssetDetailUser" value="<?= $_assetListing->AssetDetailUser ?>" placeholder="Masukan Merk Device">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmGrai" class="col-sm-3 col-form-label col-form-label-sm">Grai</label>

                    <div class="col-sm-9">
                        <select class="form-select form-select-sm" id="MsWorkplaceId" aria-label=".form-select-sm example">
                            <?php
                            $query = $this->db->get('TblMsWorkplace');
                            foreach ($query->result() as $row) {
                                echo "<option value='$row->MsWorkplaceId' " . ($_assetListing->MsWorkplaceIdRef == $row->MsWorkplaceId ? "selected" : "") . ">$row->MsWorkplaceCode</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmStatus" class="col-sm-3 col-form-label col-form-label-sm">Status</label>

                    <div class="col-sm-9">
                        <select class="form-select form-select-sm" id="AssetDetailStatus" aria-label=".form-select-sm example">
                            <option value="0">NonActive</option>
                            <option value="1">Active</option>
                            <option value="2">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSmDeskripsi" class="col-sm-3 col-form-label col-form-label-sm">Deskripsi</label>
                    <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="AssetDetailDeskripsi" placeholder="Masukan Deskripsi Device..."><?= $_assetListing->AssetDetailDeskripsi ?></textarea>
                    </div>
                </div>


                <div class=" modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-submit').click(function() {
        if ($("#AssetDetailMerk").val() == "") {
            Swal.fire(
                'Kesalahan Proses data!',
                'Masukan Merk Device terlebih dahulu...!',
                'error'
            );
            return false;
        }
        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_tools/assetEdit") ?>",
            data: {
                divisiAsset: $("#assetDivisiId").val(),
                device: $("#AssetId").val(),
                merkDevice: $("#AssetDetailMerk").val(),
                user: $("#AssetDetailUser").val(),
                grai: $("#MsWorkplaceId").val(),
                status: $("#AssetDetailStatus").val(),
                type: $("#AssetDetailType").val(),
                deskripsi: $("#AssetDetailDeskripsi").val(),
                id: <?= $_assetListing->AssetDetailId ?>
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