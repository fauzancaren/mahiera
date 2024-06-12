<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Pengiriman - Persiapan</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Pengiriman</li>
               <li class="breadcrumb-item active" onclick="menuselect('pengiriman-persiapan','menu-pengiriman')" style="cursor:pointer">List Persiapan</li>
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
                     <span class="fw-bold"><i class="fas fa-truck" aria-hidden="true"></i>&nbsp;List Persiapan</span>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status">
                              <option value="" selected>Semua Status</option>
                              <?php
                              $this->db->where("MsCustomerTypeIsActive", "1");
                              $query = $this->db->get('TblMsCustomerType')->result();
                              foreach ($query as $key) {
                                 echo '<option value="' . $key->MsCustomerTypeId . '">' . $key->MsCustomerTypeName . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status_1" name="tb_status_1">
                              <option value="" selected>Semua Status</option>
                              <option value="1">Aktif</option>
                              <option value="0">Tidak Aktif</option>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-1 align-items-center">
                        <label for="tb_row" class="col-sm-3 col-form-label">Tampilkan</label>
                        <div class="col-3">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_row" name="tb_row">
                              <option value="10" selected>10</option>
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                           </select>
                        </div>
                        <label class="col-3 col-form-label ps-0">baris</label>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">Pencarian</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_search">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="table-responsive" id="tb_data_respon">
                  <table id="tb_data" class="table table-hover align-middle" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                     <thead class="thead-dark">
                        <tr>
                           <th>No</th>
                           <th>Kategori</th>
                           <th>Kode</th>
                           <th>Nama</th>
                           <th>Deskripsi</th>
                           <th>Status</th>
                           <th><i class="fas fa-cog"></i></th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>

   <script>
      $(document).ready(function() {});
   </script>
</body>

</html>