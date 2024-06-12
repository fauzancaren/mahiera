<!DOCTYPE html>
<html lang="en">

<head>
	<title>&nbsp;Master Data - Dashboard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="<?= base_url("asset/image/mgs-erp/logo.ico") ?>">
	<meta name="author" content="Syahrul Fauzan">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="OBI-ERP">
	<meta name="theme-color" content="#42b549">
	<meta name="page-type" content="productdetailpage-desktop" data-rh="true">
	<meta name="title" content="Detail Transaksi" data-rh="true">
	<meta name="description" content="Menu Aplikasi OBI - ERP" data-rh="true">

	<meta name="twitter:card" content="product" data-rh="true">
	<meta name="twitter:site" content="@omahbata" data-rh="true">
	<meta name="twitter:creator" content="@omahbata" data-rh="true">
	<meta name="twitter:title" content="Aplikasi OBI-ERP" data-rh="true">
	<meta name="twitter:description" content="Menu Aplikasi OBI - ERP" data-rh="true">
	<meta name="twitter:image" href="<?= base_url("asset/image/mgs-erp/logo.png") ?>" data-rh="true">

	<link href="<?= base_url("asset/bootstrap-5.2/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/datepicker/daterangepicker.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/sweetalert/dist/sweetalert2.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/fontawesome5/css/all.min.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/croppie/croppie.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/datatable/datatables.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/mainmenu.css?version=1.5") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/sidebar.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/sales.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/dropzone/dropzone.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/contextmenu/jquery.contextMenu.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/signature/css/jquery.signature.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/signature/css/jquery-ui.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/date-bootstrap/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/fontgoogle/poppins.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/fontgoogle/roboto.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/combotree/comboTreePlugin.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/emoji/emojionearea.min.css") ?>" rel="stylesheet" type="text/css">
	 
	<script src="<?= base_url("asset/bootstrap-5.2/js/bootstrap.bundle.min.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery-3.6.0.min.js") ?>"></script>
	<script src="<?= base_url("asset/cleave/cleave.min.js") ?>"></script>
	<script src="<?= base_url("asset/cleave/cleave-phone.id.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery.validate.min.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery.moment.min.js") ?>"></script>
	<script src="<?= base_url("asset/sweetalert/dist/sweetalert2.all.min.js") ?>"></script>
	<script src="<?= base_url("asset/croppie/croppie.min.js") ?>"></script>
	<script src="<?= base_url("asset/datepicker/daterangepicker.js") ?>"></script>
	<script src="<?= base_url("asset/select2/js/select2.min.js") ?>"></script>
	<script src="<?= base_url("asset/datatable/datatables.min.js") ?>"></script>
	<script src="<?= base_url("asset/dropzone/dropzone.min.js") ?>"></script>
	<script src="<?= base_url("asset/copyreader.js") ?>"></script>
	<script src="<?= base_url("asset/zoom/panzoom.min.js") ?>"></script>
	<script src="<?= base_url("asset/contextmenu/jquery.contextMenu.js") ?>"></script>
	<script src="<?= base_url("asset/signature/js/jquery-ui.min.js") ?>"></script>
	<script src="<?= base_url("asset/signature/js/jquery.signature.js") ?>"></script>
	<script src="<?= base_url("asset/signature/js/jquery.ui.touch-punch.min.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery.redirect.js") ?>"></script>
	<script src="<?= base_url("asset/date-bootstrap/js/bootstrap-datepicker.min.js") ?>"></script>
	<script src="<?= base_url("asset/combotree/comboTreePlugin.js") ?>" type="text/javascript"></script>
	<script src="<?= base_url("asset/freezeTable.js") ?>" type="text/javascript"></script>
	<script src="<?= base_url("asset/emoji/emojionearea.min.js") ?>" type="text/javascript"></script> 
	<!-- GOOGLE JS MAPS, CHART  -->
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
	<script src="https://www.gstatic.com/charts/loader.js" type="text/javascript"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVbi4aS-dmQvDoLm97RZcGgeVlwVCcfk0&libraries=places&language=id&region=ID" async defer></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet" />
	<!-- AIzaSyCVbi4aS-dmQvDoLm97RZcGgeVlwVCcfk0
	AIzaSyAW3xZvltquY2OtGjDOqwTq_KaYSo2S77w -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>
	<!-- JS SOCKET IO -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.plugins.min.js"></script>

</head>

<body class="loaded">
	<script>
		number_format = function(number, decimals = 0) {
			dec_point = '.';
			thousands_sep = ',';
			number = number.toFixed(decimals);

			var nstr = number.toString();
			nstr += '';
			x = nstr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? dec_point + x[1] : '';
			var rgx = /(\d+)(\d{3})/;

			while (rgx.test(x1))
				x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

			return x1 + x2;
		}
		var api_map, api_input, api_searchBox, api_markers, api_geocoder;
		var xhrPool = [];
		var MenuActive;
		var Menuelm;

		Array.prototype.diff = function(a) {
			return this.filter(function(i) {return a.indexOf(i) < 0;});
		};
	</script>
	<script type="text/javascript" src="<?= base_url("asset/jquery/detect-width.js") ?>"></script>
	<!-- HEADER -->
	<nav class="navbar navbar-expand-md navbar-light ">
		<div class="container-fluid">
			<a class="navbar-brand fw-bold">
				<img src="<?= base_url("asset/image/mgs-erp/logo.png") ?>" width="30" height="30" class="d-inline-block align-top" alt="">
				<span class="fw-bold d-none d-sm-none d-md-inline-block text-header user-select-none">OBI - Enterprice Resource Planning</span>
			</a>
			<span class="fw-bold align-middle d-sm-block d-md-none text-header user-select-none">OBI - ERP</span>
			<div class="d-flex">
				<div class="btn-group hover-gray align-items-center align-middle">
					<a class="btn bg-white dropdown-toggle profile" data-bs-toggle="offcanvas" data-bs-target="#chat-canvas" aria-controls="chat-canvas" style="font-size: 1.2rem;  height: 3rem;  width: 2.5rem;">
						<div class="position-absolute top-50 start-50 translate-middle">
							<i class="fas fa-comments"></i>
						</div>
						<span class="badge text-badge translate-middle border border-light rounded-circle bg-danger" id="badge-chat"></span>
					</a>
				</div>
				<div class="btn-group hover-gray align-items-center align-middle">
					<a class="btn bg-white dropdown-toggle profile" data-bs-toggle="offcanvas" data-bs-target="#notif-canvas" aria-controls="chat-canvas" style="font-size: 1.2rem; height: 3rem;  width: 2.5rem;">
						<div class="position-absolute top-50 start-50 translate-middle">
							<i class="fas fa-bell"></i>
						</div>
						<span class="badge text-badge translate-middle border border-light rounded-circle bg-danger" id="badge-notif"></span>
					</a>
				</div>
				<div class="btn-group  hover-gray">
					<a class="btn bg-white dropdown-toggle profile" id="profile-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
						<img class="rounded-circle" src="<?= $_sessionuser['MsEmpImage'] ?>" width="40" height="40"><span class="fw-bold d-none d-sm-none d-md-inline-block">&nbsp;&nbsp;<?= $_sessionuser['MsEmpName'] ?></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" data-bs-popper="none">
						<li><a class="dropdown-item cursor-pointer" data-bs-toggle="modal" data-bs-target="#modal-reset-password">Ganti Password</a></li>
						<li>
							<div class="dropdown-divider"></div>
						</li>
						<li><a href="<?= site_url("login/logout") ?>" class="dropdown-item">Keluar</a></li>
					</ul>
				</div>

			</div>
		</div>
	</nav>

	<div class="wrapper">
		<!-- Sidebar -->
		<nav id="sidebar" class="sidebar hide">
			<div class="header">
				<i class="fas fa-bars"></i>
				<div class="text-span"><span>Navigation Menu</span></div>
			</div>
			<div class="search-menu">
				<div class="input-group">
					<input type="text" class="form-control form-control-sm searchmenu" id="searchText" placeholder="Cari...">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-flat p-1">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</div>

			<div class="side-menu-content-2 sidebar-menu">
			</div>
		</nav>
		<script>
			$(document).keyup(function(e) {
				if (e.key === "Escape") { // escape key maps to keycode `27`
					$(".sidebar .header").trigger("click");
				}
			});
			$(".sidebar .header").on("click", function() {
				if ($(".sidebar").attr("class") == "sidebar hide") {
					$(".sidebar").removeClass("hide");
				} else {
					$(".sidebar").addClass("hide");
				}
			});
		</script>
		<!-- Content -->
		<div id="content" class="content">
			<div class="page-load m-2">
			</div>
		</div>
	</div>

	<!-- MODAL MENUNGGU PERSETUJUAN -->
	<div class="modal fade" id="waitapprovelogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="waitapproveloginLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content"> 
				<div class="modal-body">
					<div class="d-flex flex-column">
						<h4 class="fw-bold">Anda sedang masuk di browser lain</h6> 
						<p>Menunggu persetujuan dari browser lain atau masuk menggunakan akun lain, jika anda tidak sedang login dibrowser lain silahkan hubungi <span class="fw-bold">IT SUPPORT</span></p>
						<div class="d-block text-center mt-2"><i class="fas fa-spinner fa-spin fa-4x"></i></div>
						<div class="d-block text-center mt-2" style="font-size:0.7rem">harap tunggu...</div>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="button" class="btn btn-primary" onclick='window.location = "<?= base_url("login/logout") ?>"'>keluar dan gunakan akun lain</button>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL MENUNGGU PERSETUJUAN -->
	<div class="modal fade" id="approvelogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approveloginLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content"> 
				<div class="modal-body">
					<div class="d-flex flex-column">
						<h4 class="fw-bold">ada yang login di browser lain</h6> 
						<p>ada yang masuk dibrowser lain menggunakan akun anda, jika benar anda ingin menggunakan browser lain maka pilih setuju tetapi jika tidak maka pilih tetap disini</p> 
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="button" class="btn btn-success" id="">tetap disini</button>
					<button type="button" class="btn btn-danger" id="">Setuju</button>
				</div>
			</div>
		</div>
	</div>

	<!-- CHAT ONLINE -->
	<div class="fixed-bottom d-flex flex-row-reverse bd-highlight mb-2">
		<div class="offcanvas offcanvas-end" tabindex="-1" id="chat-canvas" aria-labelledby="chat-canvas">
			<div class="offcanvas-header">
				<button type="button" class="btn-close ms-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				<h5 class="offcanvas-title"> 
					<small><i class="fas fa-comments fa-2x"></i></small>
					<span>Hello OBI</span>
				</h5>
			</div>
			<div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-top:1px solid #ffefd0">
				<div class="chat-image">
					<img class="mx-auto" src="<?= $_sessionuser['MsEmpImage']; ?>" height="50px" width="50px" alt="Avatar">
				</div>
				<div class="ms-4 me-auto">
					<div class="text-capitalize"><?= $_sessionuser['MsEmpName']; ?></div> 
					<div class="text-success" style="font-size:0.5rem;font-weight:bold;"><i class="fas fa-circle pe-1"></i>ONLINE</div> 
				</div> 
			</div>
			<div class="nav nav-pills nav-fill flex-row" id="nav-tab" role="tablist">
				<button class="nav-link active d-flex flex-column align-items-center" id="nav-chat-tab" data-bs-toggle="tab" data-bs-target="#nav-chat" type="button" role="tab" aria-controls="nav-chat" aria-selected="true"><i class="fas fa-comments"></i><span style="font-size:0.7rem;padding-top:0.5rem">pesan</span></button>
				<button class="nav-link d-flex flex-column align-items-center" id="nav-group-tab" data-bs-toggle="tab" data-bs-target="#nav-group" type="button" role="tab" aria-controls="nav-group" aria-selected="false"><i class="fas fa-users"></i><span style="font-size:0.7rem;padding-top:0.5rem">group</span></button>
				<button class="nav-link d-flex flex-column align-items-center" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-address-book"></i><span style="font-size:0.7rem;padding-top:0.5rem">kontak</span></button>
			</div>

			<div class="tab-content box-chat-list " >
				<div class="tab-pane fade show active" id="nav-chat" role="tabpanel" aria-labelledby="nav-chat-tab">
					<div id="chat-list" class="">
						<div class="position-absolute top-50 start-50 translate-middle text-center text-muted" id="search-chat-not-found">
							<i class="fas fa-comment-slash fa-3x"></i>
							<h6>Tidak ada riwayat percakapan</h6>
							<button class="btn btn-sm btn-orange py-1 mt-2" onclick="get_contact()">Mulai Percakapan</button>
						</div>
						<div class="search-chat p-2">
							<input id="input-chat" autocomplete="off" type="text" class="form-control form-control-sm" placeholder="Cari chat...">
							<div class="search-chat-remove" onclick='removetext(this)'>
								<span class="icon"></span>
							</div>
						</div>  
						<ul class="ms-2 list-group list-group-chat p-1 contact border-li overflow-auto" style="font-size:0.7rem;padding-top:3rem"></ul>
					</div> 
					<div id="chat-display" class="d-none d-flex flex-column"> 
						<div class="chat-profile d-flex align-items-center py-2 border-bottom border-secondary border-opacity-10"> 
							<button onclick="back_chat()" class="btn btn-sm me-2 px-2"><i class="fas fa-angle-left fa-2x "></i></button> 
							<div class="chat-image">
								<img class="mx-auto" src="<?= $_sessionuser['MsEmpImage']; ?>" height="50px" width="50px" alt="Avatar">
							</div>
							<div class="ms-4 me-auto">
								<div class="text-capitalize"><?= $_sessionuser['MsEmpName']; ?></div> 
								<div class="status" style="font-size:0.5rem;font-weight:bold;"><i class="fas fa-circle pe-1 text-success"></i>ONLINE</div> 
							</div> 
						</div> 
						<div class="chat-list flex-fill overflow-auto">
							<ul class="p-2">

							</ul>
						</div>
						<div id="container1"></div>
						<div class="chat-send d-flex align-items-end"> 
							<button class="btn btn-sm" id="emo-chat-person" data-bs-toggle="button" aria-bs-pressed="false"><i class="far fa-smile"></i></button>
							<button class="btn btn-sm" id="file-chat-person"><i class="fas fa-paperclip"></i></button> 
							<textarea class="flex-fill" id="input-chat-person" data-emojiable="true" oninput="auto_grow(this)" ></textarea> 
							<button class="btn btn-sm" id="send-chat-person"><i class="far fa-paper-plane"></i></button> 
							<script> 
								function auto_grow(element) {
									element.style.height = "5px";
									element.style.height = (element.scrollHeight)+"px";
								} 
							</script>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-chat-group">
					<div class="position-absolute top-50 start-50 translate-middle text-center text-muted">
						<i class="fas fa-users fa-3x"></i> 
						<h6>Tidak Ada Group</h6>
					</div>
				</div>
				<div class="d-flex flex-column tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-chat-contact">
					<div class="position-absolute top-50 start-50 translate-middle text-center text-muted" id="seach-not-found">
						<i class="fas fa-search fa-3x"></i>
						<h6>Tidak Ada Yang ditemukan</h6> 
					</div>
					<div class="search-chat p-2">
						<input id="input-contact" autocomplete="off" type="text" class="form-control form-control-sm" placeholder="Cari nama kontak...">
						<div class="search-chat-remove"  onclick='removetext(this)'>
							<span class="icon"></span>
						</div>
					</div>  
					 
					<div class="flex-fill overflow-auto">
						<div class="d-block">
							<a class="fw-bold text-decoration-none collapsed d-inline-block chat-dropdown mx-1" style="--bs-bg-opacity: .1;" data-bs-toggle="collapse" href="#chat-online" role="button" aria-expanded="false" aria-controls="chat-online">
								<div class="text-success" style="font-size:0.7rem;font-weight:bold;">ONLINE<span class="chat-online-count badge text-bg-secondary ms-2" style="--bs-bg-opacity: .6;">0</span></div> 
							</a>
						</div>
						<div class="collapse" id="chat-online">
							<ol class="ms-2 list-group list-group-chat p-1 contact border-li" id="contact-online" style="font-size:0.7rem;padding-top:3rem"></ol>
						</div>

						
						<div class="d-block mt-2">
							<a class="fw-bold text-decoration-none collapsed d-inline-block chat-dropdown mx-1" style="--bs-bg-opacity: .1;" data-bs-toggle="collapse" href="#chat-offline" role="button" aria-expanded="false" aria-controls="chat-offline">
								<div class="text-muted" style="font-size:0.7rem;font-weight:bold;">OFFLINE<span class="chat-offline-count badge text-bg-secondary ms-2" style="--bs-bg-opacity: .6;">0</span></div> 
							</a>
						</div>
						<div class="collapse" id="chat-offline">
							<ol class="ms-2 list-group list-group-chat p-1 contact border-li" id="contact-offline" style="font-size:0.7rem;padding-top:3rem"></ol>
						</div> 
					</div>  
				</div>
			</div>
		</div>
		<div class="offcanvas offcanvas-end" tabindex="-1" id="notif-canvas" aria-labelledby="notif-canvas">
			<div class="offcanvas-header">
				<button type="button" class="btn-close ms-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				<h5 class="offcanvas-title"><small><i class="fas fa-bell"></i></small>
					<span>&nbsp;Notifikasi</span>
				</h5>
			</div>
			<div class="offcanvas-body">
				<a onclick="update_read_notif()" class="cursor-pointer">Tandai semua sudah dibaca</a>
				<ul class="list-group" id="list-notif" style="display: flex;flex-direction: column-reverse;">

					<!--
					<li class=" list-group-item list-group-item-action d-flex flex-column cursor-pointer active">
					<div class="header-list">
						<i class="fas fa-info-circle pe-1 text-primary"></i>
						<span>Info</span>
						<i class="fas fa-circle mx-1" style="font-size: 0.25rem;"></i>
						<span>09.02</span>
					</div>
					<div class="judul-list">
						Transaksi Berhasil dibuat<i class="ps-1 text-success fas fa-check"></i>
					</div>
					<div class="body-list">
						Transaksi baru berhasil dibuat oleh <b>AGUS MAULANA ALI</b>
						dengan No. Invoice <b>ALY/XIII/SL-0001/04/X/2021</b>
						atas nama <b>Ibu Melinda</b>
					</div>
					</li>
					<li class="list-group-item list-group-item-action d-flex flex-column cursor-pointer">
						<div class="header-list">
							<i class="fas fa-info-circle pe-1 text-primary"></i>
							<span>Info</span>
							<i class="fas fa-circle mx-1" style="font-size: 0.25rem;"></i>
							<span>09.02</span>
						</div>
						<div class="judul-list">
							Transaksi Berhasil diedit<i class="ps-1 text-warning fas fa-pencil-alt"></i>
						</div>
						<div class="body-list">
							Transaksi baru berhasil dibuat oleh <b>AGUS MAULANA ALI</b>
							dengan No. Invoice <b>ALY/XIII/SL-0001/04/X/2021</b>
							atas nama <b>Ibu Melinda</b>
						</div>
					</li>
					-->
				</ul>
			</div>
		</div>
	</div>

	<!-- INFO TOAST -->
	<div class="position-fixed bottom-0 end-0" style="z-index: 1061;" id="toast-notif"></div>

	<!-- MODAL PASSWORD -->
	<div class="modal fade" id="modal-reset-password" data-bs-keyboard="false" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered ">
			<form class="modal-content" name="reset-password">
				<div class="modal-header bg-dark">
					<h6 class="modal-title text-white"><i class="fas fa-key text-success" aria-hidden="true"></i> &nbsp;Ganti Password</h5>
						<button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<div class="col-11">
							<div class="row mb-1">
								<label for="tb_search" class="col-sm-3 col-form-label">Password Baru</label>
								<div class="col-sm-9">
									<input id="txt-new-password" name="txt-new-password" type="text" class="form-control form-control-sm" value="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Script Page Menu  -->
	<script>
		$(document).ready(function() {
			if ("vwxyzA" == <?= JSON_ENCODE($this->session->userdata("MsEmpPass")) ?>) {
				const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success mx-1',
						cancelButton: 'btn btn-danger mx-1'
					},
					buttonsStyling: false
				});
				swalWithBootstrapButtons.fire({
					icon: 'warning',
					html: 'password anda masih default, silahkan ganti password untuk keamanan data. <span style="font-size:0.75rem;color:orange;"><br>Pesan ini akan tetap muncul jika anda masih menggunakan password default</span>',
					showConfirmButton: true,
					showCancelButton: true,
					allowOutsideClick: false,
					allowOutsideClick: false,
					allowEscapeKey: false,
					confirmButtonText: "Ganti Sekarang",
					cancelButtonText: "Tidak Sekarang",
				}).then((result) => {
					if (result.isConfirmed) {
						$("#modal-reset-password").modal("show");
					}
				});
			}
			$(function() {
				$("form[name='reset-password']").validate({
					rules: {
						"txt-new-password": "required",
					},
					messages: {
						"txt-new-password": "Masukan Password baru",
					},
					submitHandler: function(form) {
						$.each(xhrPool, function(idx, jqXHR) {
							jqXHR.abort();
						});
						$("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
						$.ajax({
							method: "POST",
							url: "<?= site_url("function/client_data_master/reset_password") ?>",
							data: {
								"MsEmpPass": $("#txt-new-password").val()
							},
							success: function(data) {
								req_status_add = 0;
								$("#btn-submit").html("Simpan");

								if (data) {
									Swal.fire({
										icon: 'success',
										text: 'Ganti password berhasil, Silahkan Login Kembali...!!!',
										showConfirmButton: false,
										allowOutsideClick: false,
										allowEscapeKey: false,
										timer: 1500,
									}).then((result) => {
										if (result.dismiss === Swal.DismissReason.timer) {
											window.location.href = "<?= site_url("login/logout") ?>";
										}
									});
								} else {
									Swal.fire({
										icon: 'error',
										text: 'Ganti password gagal',
										showConfirmButton: false,
										allowOutsideClick: false,
										allowEscapeKey: false,
										timer: 1500
									});
								}
							}
						});
						return false;
					}
				});
			});
			MenuActive = "<?= $_sessionuser['menu_active'] ?>";
			Menuelm = "<?= $_sessionuser['menu_mode'] ?>";
			MenuId = "<?= $_sessionuser['menu_id'] ?>";

			$.ajax({
				url: "<?= site_url("client/get_side_menu") ?>",
				success: function(result) {
					$(".sidebar-menu").html(result);

					var myGroup = $('li');
					myGroup.on('show.bs.collapse', '.collapse', function() {
						$('.header-collapse').attr('aria-expanded', false);
						$('.treeview-menu.collapse.show').removeClass('show');
					});

					menuselect(MenuId,MenuActive, Menuelm);
					$('body').addClass('loaded');
					$('h2').css('color', '#222222');


					$(".sidebar-menu ul li > a").click(function() {
						if ($(".sidebar").attr("class") == "sidebar hide") {
							$(".sidebar").removeClass("hide");
						}
					});
					// $('.sidebar.hide > .sidebar-menu > ul > li').mouseenter(function() {
					// var child = $(this).children().first()
					// if ($(child).hasClass("header-collapse")) {
					// $(child).attr("aria-expanded", true);
					// var id = $(child).attr("href");
					// $(id).collapse('show');
					// }
					// //$(this).click();
					// });
					// $('.sidebar.hide .sidebar-menu > ul > li').mouseleave(function() {
					// var child = $(this).children().first()
					// if ($(child).hasClass("header-collapse")) {
					// $(child).attr("aria-expanded", false);
					// var id = $(child).attr("href");
					// $(id).collapse('hide');
					// }
					// });
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("Status: " + textStatus);
					alert("Error: " + errorThrown);
				}
			});

			menuselect = function(id,menu, elm2) {
				$('.sidebar-menu > ul > li > a').each(function() {
					$(this).parent().removeClass("active");
					$(this).even().removeClass("active");
				});
				$('.treeview-menu > li > a').each(function() {
					$(this).even().removeClass("active");
				});

				var element = document.getElementsByName(menu);
				element[0].classList.add('active');
				$(element[0]).parent().parent().parent().addClass("active");
				if (elm2 != "-") {
					var element2 = document.getElementsByName(elm2);
					element2[0].classList.add('active');
					document.title = $('[name="' + elm2 + '"]').find("span").first().text() + " - " + $(element[0]).find("span").text();

				} else {
					document.title = "OBI - " + $(element[0]).find("span").text();
				}

				$("#menu-navigation-canvas").offcanvas("hide");
				MenuActive = menu;
				set_page_by_menu(id,MenuActive, elm2);
			}

			function set_page_by_menu(id,menu, elm) {
				$.each(xhrPool, function(idx, jqXHR) {
					jqXHR.abort();
				});
				$.ajax({
					url: "<?= site_url("client/get_content/") ?>" + menu + "/" + elm+ "/" + id,
					success: function(result) {
						remove_fixed_header();
						$(".page-load").html(result);
					}
				});
			};

			$('.searchmenu').bind('keyup', function() {

				var searchString = $(this).val();
				if (searchString.length > 0) {

					for (const li of document.querySelectorAll('.sidebar-menu>ul>li>a')) {
						if ($(li).attr("data-bs-toggle") == "collapse") {
							$(li).attr("aria-expanded", true);
						}
					}

					for (const li of document.querySelectorAll('.sidebar-menu>ul>li>ul')) {
						$(li).attr("class", "treeview-menu ps-0 collapse show");
					}

				} else {

					for (const li of document.querySelectorAll('.sidebar-menu>ul>li>a')) {
						if ($(li).attr("data-bs-toggle") == "collapse") {
							$(li).attr("aria-expanded", false);
						}
					}
					for (const li of document.querySelectorAll('.sidebar-menu>ul>li>ul')) {
						$(li).attr("class", "treeview-menu ps-0 collapse");
					}

				}
				$(".sidebar-menu > ul li").each(function(index, value) {
					currentName = $(value).text()
					if (currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
						$(value).show();
					} else {
						$(value).hide();
					}
				});
			});

			var startProductBarPos = -1; 
			function scroolfunction() {
				var bar = document.getElementById('side-content');
				if (startProductBarPos < 0) startProductBarPos = findPosY(bar);
				if (pageYOffset > startProductBarPos) {
					bar.style.position = 'fixed';
					bar.style.top = 0;
				} else {
					bar.style.position = 'relative';
				} 
			};

			function findPosY(obj) {
				var curtop = 0;
				if (typeof(obj.offsetParent) != 'undefined' && obj.offsetParent) {
					while (obj.offsetParent) {
						curtop += obj.offsetTop;
						obj = obj.offsetParent;
					}
					curtop += obj.offsetTop;
				} else if (obj.y)
					curtop += obj.y;
				return curtop;
			}

			set_fixed_header = function() {
				window.addEventListener('scroll', scroolfunction);
			}

			function remove_fixed_header() {
				window.removeEventListener('scroll', scroolfunction);
			}
			window.addEventListener('resize', function(event) {
				if ($(window).width() < 575) {
					$("#content").width("100%");
				} else {
					$("#content").width($(window).width() - $('#sidebar').width());
				}
			}); 
			var drop = $('#profile-dropdown').parent().find('.dropdown-menu');
			var t;
			$('#profile-dropdown').mouseenter(function() {
				clearTimeout(t);
				drop.show();
				$(this).addClass("show");
			})
			$('#profile-dropdown').mouseleave(function() {
				$(this).removeClass("show");
				if (!$(drop).hasClass("show")) {
					t = setTimeout(function() {
						drop.hide();
						console.log("t out");
					}, 200);
				}
			})

			$(drop).mouseenter(function() {
				drop.show();
				drop.addClass("show");
				clearTimeout(t);
			});
			$(drop).mouseleave(function() {
				drop.removeClass("show");
				if (!$('#profile-dropdown').hasClass("show")) {
					t = setTimeout(function() {
						drop.hide();
						console.log("t out");
					}, 200);
				}
			});
		});
	</script>
	<script src="<?= base_url("asset/soundmanager/soundmanager2-jsmin.js")?>"></script>
	<!-- Script Notif dan header web  -->
	
	<script src="<?= base_url("asset/push.min.js")?>"></script>   
	<!-- Script untuk CHATTING dan notif -->
	<!-- <script>  
	
		$(document).ready(function() {
			
			const myOffcanvas = document.getElementById('chat-canvas')
			var chat_mode = "";
			var last_date_person = "";
			var last_date=""; 
			var last_id = 0; 
			shownotif = function() {
				var toastElList = [].slice.call(document.querySelectorAll('.toast'))
				var toastList = toastElList.map(function(toastEl) {
					toastEl.addEventListener('hidden.bs.toast', function() {
						$(toastEl).remove();
					});
					return new bootstrap.Toast(toastEl)
				})
				toastList.forEach(toast => {
					toast.show();
				})
			} 
			update_read_notif = function() {
				$('.list-notif').each(function() {
					$(this).removeClass("active");
					$(this).data("read", "1");
					$.ajax({
						method: "POST",
						url: "<?= site_url("client/update_notification/") ?>" + $(this).data("id"),
						success: function() {
							var count_notif = parseInt($("#badge-notif").text()) - 1;
							$("#badge-notif").text(count_notif);
							if (count_notif > 0) {
								$("#badge-notif").show();
							} else {
								$("#badge-notif").hide();
							}
						}
					});
				});
			}
			get_new_list_notif = async function() {
				await $.ajax({
					dataType: "json",
					method: "POST",
					data: {
						"NotifId": last_id
					},
					url: "<?= site_url("client/get_notification") ?>",
					success: function(data) {
						data["detail"].forEach(element => {
							var datenotif = moment(element["NotifDate"], "YYYY-MM-DD HH:mm:ss").add(7, 'hours');

							var html = '<li class="list-notif list-group-item list-group-item-action d-flex flex-column cursor-pointer ' + (element["NotifRead"] == 0 ? "active" : "") + '" data-id="' + element["NotifId"] + '" data-read="' + element["NotifRead"] + '"  data-date="' + element["NotifRefDate"] + '" data-ref="' + element["NotifRef"] + '" data-store="' + element["MsWorkplaceId"] + '" data-type="' + element["NotifType"] + '">';
							html += '<div class="header-list">';
							html += '	<i class = "fas fa-info-circle pe-1 text-primary"></i><span>Info</span><i class = "fas fa-circle mx-1" style = "font-size: 0.25rem;"></i><span>' + datenotif.format("YYYY-MM-DD HH:mm:ss") + '</span>';
							html += '</div>';
							html += '<div class = "judul-list">' + element["NotifHeader"] + '</div>';
							html += '<div class = "body-list">' + element["NotifDesc"] + '</div></li>';
							if (parseInt(element["NotifId"]) > last_id) last_id = parseInt(element["NotifId"]);
							$("#list-notif").append(html);
						});

						$("#badge-notif").text(data["count"]);
						if (data["count"] > 0) {
							$("#badge-notif").show();
						} else {
							$("#badge-notif").hide();
						}
						$('.list-notif').mouseleave(function() {
							$(this).removeClass("active");
							if ($(this).data("read") == 0) {
								$(this).data("read", "1");
								$.ajax({
									method: "POST",
									url: "<?= site_url("client/update_notification/") ?>" + $(this).data("id"),
									success: function() {
										var count_notif = parseInt($("#badge-notif").text()) - 1;
										$("#badge-notif").text(count_notif);
										if (count_notif > 0) {
											$("#badge-notif").show();
										} else {
											$("#badge-notif").hide();
										}

										console.log("update notif success");
									}
								});
							}
						});

						var myOffcanvas = document.getElementById('notif-canvas')
						var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
						$('.list-notif').click(function() {
							show_from_notif($(this).data("id"), $(this).data("ref"), $(this).data("type"), $(this).data("store"), $(this).data("date"));
							bsOffcanvas.hide();
						});
						return true;
					}
				});
			} 
			get_new_list_notif();
			show_from_notif = function(NotifId, NotifRef, NotifType, storeid, date) {
				switch (NotifType) {
					case "QUOTATION":
						if (MenuActive != "penjualan-quotation") $("[name='penjualan-quotation']").trigger("click");
						setTimeout(() => {
							$("#tb_workplace").parent().find('.custom-option[data-value = "' + storeid + '"]').trigger("click");
							$("#tb_search").val(NotifRef);
							Date_content(moment(date, "YYYY-MM-DD"), moment(date, "YYYY-MM-DD"));
							$("#btn-search").trigger("click");
						}, 1000);
						break;
					case "SALES":
						if (MenuActive != "penjualan-salesorder") $("[name='penjualan-salesorder']").trigger("click");
						setTimeout(() => {
							$("#tb_workplace").parent().find('.custom-option[data-value = "' + storeid + '"]').trigger("click");
							$("#tb_search").val(NotifRef);
							Date_content(moment(date, "YYYY-MM-DD"), moment(date, "YYYY-MM-DD"));
							$("#btn-search").trigger("click");
						}, 1000);
						break;
					case "APPROVE":
						if (MenuActive != "finance-approve") $("[name='finance-approve']").trigger("click");
						setTimeout(() => {
							$("#tb_search").val(NotifRef);
							$("#tb_status").val(storeid).trigger("change");
						}, 1000);
						break;
					case "APPROVE SALES":
						if (MenuActive != "penjualan-salesrequest") $("[name='penjualan-salesrequest']").trigger("click");
						setTimeout(() => {
							$("#tb_search").val(NotifRef);
							$("#tb_status").val(storeid).trigger("change");
						}, 1000);
						break;
					default:
						// code block
				}
			}

			$('.box-chat-list > .tab-pane').css({"max-height":$('.box-chat-list').height() - 10,"height": $('.box-chat-list').height() - 10}); 
			$('.chat-display').css({"max-height":$('.box-chat-list').height() - 10,"height": $('.box-chat-list').height() - 10}); 
			//$('.chat-list').css({"max-height":$('.box-chat-list').height() - 10,"height": $('.box-chat-list').height() - 10}); 

			var soundMessage = soundManager.createSound({
				url: '<?= base_url("asset/sound/message.mp3") ?>',
				debugMode: false,
				defaultOptions: {
					// set global default volume for all sound objects
					volume: 20
				}
			});
			var dataUser = <?= JSON_ENCODE($_users) ?>;
			var countOnline = 0;
			var countOffline = 0;
			const socket = io.connect('https://omahbata.ddns.net:5000' );
			socket.on('connect', function () {   
				socket.emit('login', {"code":"<?= $_sessionuser["MsEmpCode"]?>","name":"<?= $_sessionuser["MsEmpName"]?>","uuid":"<?= $_sessionuser["login_uuid"]?>"});
				
				// PERTAMA DIJALANKAN DAN AKAN MEMBACA SEMUA USER YANG SEDANG AKTIF
				socket.on('listOnline', function(data) {  
					console.log("User Online : ");
					console.log(data); 
					for(var i=0; i < data.length;i++){
						changelist(data[i].MsEmpCode,true);
					}
				}); 
				
				// MENGUPDATE DATA USER YANG BARU AKTIF
				socket.on('isOnline', function(data) {  
					console.log("Is Online : ");
					console.log(data);

					changelist(data,true);
				});
				
				// UNTUK VALIDASI USER YANG SAMA DI BEDA BROWSER (NEW LOGIN)
				socket.on('isReady', function() {  
					$("#waitapprovelogin").modal("show");
				});

				// UNTUK VALIDASI USER YANG SAMA DI BEDA BROWSER (OLD LOGIN)
				socket.on('userLogin', function() {  
					$("#approvelogin").modal("show");
				});
 
				// melihat data users
				socket.on('users', function(data) {  
					console.log("data users : ");
					console.log(data); 
				});

				// pesan realtime dari user
				socket.on('chat_person', function(data) {  
					console.log("chat baru : ");
					console.log(data); 

					load_data_chat(); 
					soundMessage.play();  

					 
					if(chat_mode!=data.code){ //jika tab sedang tidak dibuka maka muncul notifikasi diatas
						var userIndex = dataUser.findIndex(e => e.code.toLowerCase() === data.code.toLowerCase()); 
						Push.Permission.request();
						Push.create('Pesan dari ' + dataUser[userIndex]["nama"], {
							body: data.message ,
							icon: '<?= base_url("asset/image/mgs-erp/logo.png")?>',
							timeout: 8000,               // Timeout before notification closes automatically.
							vibrate: [100, 100, 100],    // An array of vibration pulses for mobile devices.
							onClick: function() {
								var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
								bsOffcanvas.show()

								$("#nav-chat-tab").trigger("click");
								open_chat(dataUser[userIndex]);
							}  
						});
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end', 
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({ 
							html: '<div class="d-flex"><div><img src="<?= base_url()?>/asset/image/mgs-erp/pesan1.webp" height="50" width="60" class="me-2"></div><div><b>Ada pesan baru !!!</b><br><span class="text-muted" style="font-size:0.75rem">' + data.name + " : <br>" + data.message + "</span></div></div>", 
							showConfirmButton: true,
  							confirmButtonText: 'Buka sekarang',
							confirmButtonClass: "custom-swal-btn btn-success",
						}).then((result) => {
							if (result.isConfirmed) {  

								var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
								bsOffcanvas.show()

								$("#nav-chat-tab").trigger("click"); 
								open_chat(dataUser[userIndex]);
							}
						})
					}else{
						load_new_chat({"ChatFrom" : "<?= $_sessionuser["MsEmpCode"] ?>","ChatTo" : data.code,"ChatDate": last_date_person}); 
					}
				});
				
				// MENGUPDATE DATA USER YANG SUDAH TIDAK AKTIF
				socket.on('user_leave', function(data) {  
					console.log("user leave : ");
					console.log(data);

					changelist(data,false);
				});


				
				// melihat data users
				socket.on('notif', function(data) {  
					console.log("notif : ");
					console.log(data); 

					var empid = "<?= $_sessionuser["MsEmpId"] ?>";
					data["employee"].forEach(element => {
						if (empid == element) {
							soundMessage.play();

							Push.Permission.request();
							Push.create('OBI-ERP - ' + data["NotifType"], {
								body: data["NotifDesc"],
								icon: '<?= base_url("asset/image/mgs-erp/logo.png")?>',
								timeout: 8000,               // Timeout before notification closes automatically.
								vibrate: [100, 100, 100],    // An array of vibration pulses for mobile devices.
								onClick: function() {
									show_from_notif(data["NotifId"],data["NotifRef"],data["NotifType"],data["MsWorkplaceId"] , data["NotifRefDate"] );
								}  
							});
							var html = '<div class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">';
							html += '		<div class = "toast-header">';
							html += '			<i class = "fas fa-info-circle pe-1 text-primary"></i>';
							html += '			<span>Info</span><i class = "fas fa-circle mx-1" style = "font-size: 0.25rem;"></i>';
							html += '			<span class = "me-auto" ></span>';
							html += '			<button type = "button" class = "btn-close" data-bs-dismiss = "toast" aria-label = "Close"></button>';
							html += '		</div >';
							html += '		<div class = "toast-body">';
							html += '			<div class = "judul-list">' + data["NotifHeader"] + '</div>';
							html += '			<div class = "body-list">' + data["NotifDesc"] + '<br><a  data-bs-dismiss = "toast" onclick = \'show_from_notif("' + data["NotifId"] + '","' + data["NotifRef"] + '","' + data["NotifType"] + '","' + data["MsWorkplaceId"] + '","' + data["NotifRefDate"] + '")\' class = "cursor-pointer"> Lihat selengkapnya </a></div>';
							html += '		</div>';
							html += '	</div>';
							$("#toast-notif").append(html);
							shownotif();
							get_new_list_notif();
							return true;
						}
					});
				});

			}); 

			// -------- FUNGSI UNTUK CONTACT
			$("#input-contact").keyup(function(){
				if($("#nav-contact .search-chat input").val()==""){
					$("#nav-contact .search-chat-remove").removeClass("remove"); 
				}else{
					$("#nav-contact .search-chat-remove").addClass("remove");  
				}
				load_data_contact();
			}) 
			removetext =function(elm){
				var input = $(elm).parent().find(":input");
				if($(elm).parent().find(".search-chat-remove").hasClass("remove")) $(input).val("");
				$(input).keyup();
			} 
			changelist = function(id,status){
				var userIndex = dataUser.findIndex(e => e.code.toLowerCase() === id.toLowerCase()); 
				if (userIndex !== -1) { dataUser[userIndex].status = status; }
				load_data_contact(); 
			}
			function load_data_contact(){ 
				$("#contact-online").empty();
				$("#contact-offline").empty();
				countOnline = 0;
				countOffline = 0;
				for(var i = 0; i < dataUser.length;i++){
					if(dataUser[i]["nama"].toLowerCase().indexOf($("#nav-contact .search-chat input").val().toLowerCase()) > -1 && dataUser[i]["nama"].toLowerCase() != "<?= strtolower($_sessionuser["MsEmpName"])?>"){
						if(dataUser[i]["status"]){
							countOnline++;
							$("#contact-online").append(`
								<li onclick="start_chat(`+ i +`)" class="list-group-item d-flex justify-content-between align-items-start p-2" id="list-`+ dataUser[i]["code"]+`">
									<div class="chat-image">
										<img class="mx-auto" src="` +dataUser[i]["image"] +`" height="30px" width="30px" alt="Avatar">
									</div>
									<div class="ms-2 me-auto">
										<div class="text-capitalize">` +dataUser[i]["code"] +` - ` +dataUser[i]["nama"].toLowerCase() +`</div> 
										<div class="status text-success" style="font-size:0.5rem;font-weight:bold;"><i class="fas fa-circle pe-1"></i>ONLINE</div> 
									</div>
									<div class="lastlogin"> </div>
								</li>`);
						}else{
							countOffline++;
							$("#contact-offline").append(`
								<li onclick="start_chat(`+ i +`)" class="list-group-item d-flex justify-content-between align-items-start p-2" id="list-`+ dataUser[i]["code"]+`">
									<div class="chat-image">
										<img class="mx-auto" src="` +dataUser[i]["image"] +`" height="30px" width="30px" alt="Avatar">
									</div>
									<div class="ms-2 me-auto">
										<div class="text-capitalize">` +dataUser[i]["code"] +` - ` +dataUser[i]["nama"].toLowerCase() +`</div> 
										<div class="status text-muted" style="font-size:0.5rem;font-weight:bold;"><i class="fas fa-circle pe-1"></i>OFFLINE</div> 
									</div>
									<div class="lastlogin"> </div>
								</li>`);
						}
					}
				}
				$('.chat-online-count').text(countOnline);
				$('.chat-offline-count').text(countOffline);

				(countOnline == 0 && countOffline == 0 ) ? $('#seach-not-found').show() : $('#seach-not-found').hide(); 
			}  
			get_contact = function(){
				$("#nav-contact-tab").trigger("click");
			}

			start_chat = function(index){ 
				open_chat(dataUser[index]);
				$("#nav-chat-tab").trigger("click"); 
			}
			
			// -------- FUNGSI UNTUK CHAT
	
			$("#input-chat").keyup(function(){
				if($("#nav-chat .search-chat input").val()==""){
					$("#nav-chat .search-chat-remove").removeClass("remove"); 
				}else{
					$("#nav-chat .search-chat-remove").addClass("remove");  
				}
			
			});


			load_data_chat = function(){
				$.ajax({
					url: "<?= base_url("function/client_data_chat/get_list_chat")?>",
					type: 'POST',
					data: { 
							"code":"<?= $_sessionuser["MsEmpCode"] ?>",
							"search":$('#input-chat').val()
						},
					dataType: "JSON",
					success:function(data){
						$("#chat-list ul").empty();
						for(var i = 0; i < data.length;i++){
							var index;
							dataUser.some(function (elem, j) {
								return elem.code === data[i]["code"] ? (index = j, true) : false;
							});
							$("#chat-list ul").append(`
								<li onclick="start_chat(`+ index +`)" class="list-group-item d-flex justify-content-between align-items-start p-2" id="chat-`+ data[i]["code"]+`">
									<div class="chat-image">
										<img class="mx-auto" src="` +data[i]["userimage"] +`" height="30px" width="30px" alt="Avatar">
									</div>
									<div class="ms-2 me-auto">
										<div class="text-capitalize fw-bold">` + data[i]["code"] +` - ` +data[i]["nama"].toLowerCase() +`</div> 
										<div class="text-muted">`+ (data[i]["ChatType"]=="FROM" ? '<i class="fas fa-check pe-2"></i>' : "")+``+data[i]["ChatText"]+`</div> 
									</div>
									<div class="lastlogin">`+data[i]["ChatDate"]+`</div>
								</li>`);
						}
						if(data.length > 0){ $('#search-chat-not-found').hide(); }else{$('#search-chat-not-found').show();} 
					}
				});
			}
			load_data_chat();
			open_chat = function(users){  
				chat_mode = users["code"];
				$("#chat-display").removeClass("d-none");
				$("#chat-list").addClass("d-none");
				if(users["status"]){
					var status = '<div class="status text-success" style="font-size:0.5rem;font-weight:bold;"><i class="fas fa-circle pe-1"></i>ONLINE</div>';
				}else{
					var status = '<div class="status text-muted" style="font-size:0.5rem;font-weight:bold;"><i class="fas fa-circle pe-1"></i>OFFLINE</div>';
				}
				$("#chat-display > .chat-profile").html(
				`	<button onclick="back_chat()" class="btn btn-sm me-2 px-2"><i class="fas fa-angle-left fa-2x "></i></button> 
					<div class="chat-image">
						<img class="mx-auto" src="${users["image"]}" height="50px" width="50px" alt="Avatar">
					</div>
					<div class="ms-4 me-auto">
						<div class="text-capitalize">${users["nama"].toLowerCase()}</div> 
						${status} 
					</div> `);
				$("#send-chat-person").data("id", users["code"]); 
				last_date_person = "";
				last_date=""; 
				load_start_chat({"ChatFrom" : "<?= $_sessionuser["MsEmpCode"] ?>","ChatTo" : users["code"]});
			}
			back_chat = function(){
				chat_mode = "";
				$("#chat-display").addClass("d-none");
				$("#chat-list").removeClass("d-none");
				load_data_chat();
			}
			 
			$("#send-chat-person").click(function(){
				var input = $('#input-chat-person').data("emojioneArea").getText().trim();
				if(input.length > 0){ 
					$.ajax({
						url: "<?= base_url("function/client_data_chat/send_chat")?>",
						type: 'POST',
						data: {data : {"ChatFrom" : "<?= $_sessionuser["MsEmpCode"] ?>","ChatTo" : $("#send-chat-person").data("id"),"ChatText":input}},
						success: function(data){
							if(data){  
								load_new_chat({"ChatFrom" : "<?= $_sessionuser["MsEmpCode"] ?>","ChatTo" : $("#send-chat-person").data("id"),"ChatDate": last_date_person}); 
								socket.emit('chat_person',{"code":$("#send-chat-person").data("id"),"message":input});
								$('#input-chat-person').data("emojioneArea").setText('')
							}
						}
					});
				}
			});

			
			var emojiStandAlone = $("#input-chat-person").emojioneArea({   
									autocomplete: false,
									filtersPosition: "bottom" ,
									search: false, 
									events: {
										keyup: function (editor, event) {
											if(event.which == 13){ 
												if(event.shiftKey) {
													// With shift
												}else {
													event.preventDefault(); 
													$("#send-chat-person").trigger("click");
												}
											}
										}, 
										"picker.hide" : function() {
											$("#emo-chat-person").removeClass("active");
											$("#emo-chat-person").attr("aria-pressed","false");
										}
									}
								});
			const emojionearea = emojiStandAlone[0].emojioneArea
			$("#emo-chat-person").click(function(){
				console.log($(this).attr("aria-pressed"))
				if($(this).attr("aria-pressed")==="true"){ 
					setTimeout(function(){
						var data = emojionearea.getText().trim();
						emojionearea.setText(data).setFocus();
						emojionearea.showPicker();
					}, 300);
					
				}else{ 
					emojionearea.hidePicker();
				}
			})
			function load_start_chat(data){ 
				$.ajax({
					url: "<?= base_url("function/client_data_chat/get_chat")?>",
					type: 'POST',
					data: {"data" : data},
					dataType: "JSON",
					success: function(res){ 
						$(".chat-list ul").empty();
						for(var i = 0;i < res.length;i++){
							if(last_date != moment(res[i]["ChatDate"]).add(7, 'hours').format("YYYY-MM-DD")){
								last_date = moment(res[i]["ChatDate"]).add(7, 'hours').format("YYYY-MM-DD");
								$(".chat-list ul").append(
									`<li class="text-center">
										<div class="chat-box date">
											<span class="chat-text">${moment(res[i]["ChatDate"]).add(7, 'hours').format("YYYY-MM-DD")}</span>  
										</div>
									</li>`
								)
							}
							if(res[i]["ChatFrom"]=="<?= $_sessionuser["MsEmpCode"] ?>"){ 
								$(".chat-list ul").append(
									`<li class="text-end">
										<div class="chat-box from" id="${res[i]["ChatId"]}">
											<div class="chat-text text-start">${res[i]["ChatText"].replace(/\n/g, "<br/>")}</div>
											<span class="chat-date">${moment(res[i]["ChatDate"]).add(7, 'hours').format("H:mm")}</span>
											<span class="chat-status"><i class="fas fa-check"></i></span>
										</div>
									</li>`
								)
							}else{	
								$(".chat-list ul").append( 
									`<li class="text-start">
										<div class="chat-box to" id="${res[i]["ChatId"]}">
											<div class="chat-text">${res[i]["ChatText"].replace(/\n/g, "<br/>")}</div>
											<span class="chat-date">${moment(res[i]["ChatDate"]).add(7, 'hours').format("H:mm")}</span>
										</div>
									</li>`
								)
							}
							last_date_person = res[i]["ChatDate"];
						} 
						$('.chat-list').animate({scrollTop:$('.chat-list ul').height()},'slow'); 
					}
				}); 
			}  
			function load_new_chat(data){
				$.ajax({
					url: "<?= base_url("function/client_data_chat/get_new_chat")?>",
					type: 'POST',
					data: {"data" : data},
					dataType: "JSON",
					success: function(res){
						for(var i = 0;i < res.length;i++){
							if(last_date != moment(res[i]["ChatDate"]).add(7, 'hours').format("YYYY-MM-DD")){
								last_date = moment(res[i]["ChatDate"]).add(7, 'hours').format("YYYY-MM-DD");
								$(".chat-list ul").append(
									`<li class="text-center">
										<div class="chat-box date">
											<span class="chat-text">${moment(res[i]["ChatDate"]).add(7, 'hours').format("YYYY-MM-DD")}</span>  
										</div>
									</li>`
								)
							}
							if(res[i]["ChatFrom"]=="<?= $_sessionuser["MsEmpCode"] ?>"){ 
								$(".chat-list ul").append(
									`<li class="text-end">
										<div class="chat-box from" id="${res[i]["ChatId"]}">
											<div class="chat-text text-start">${res[i]["ChatText"].replace(/\n/g, "<br/>")}</div>
											<span class="chat-date">${moment(res[i]["ChatDate"]).add(7, 'hours').format("H:mm")}</span>
											<span class="chat-status"><i class="fas fa-check"></i></span>
										</div>
									</li>`
								)
							}else{	
								$(".chat-list ul").append( 
									`<li class="text-start">
										<div class="chat-box to" id="${res[i]["ChatId"]}">
											<div class="chat-text">${res[i]["ChatText"].replace(/\n/g, "<br/>")}</div>
											<span class="chat-date">${moment(res[i]["ChatDate"]).add(7, 'hours').format("H:mm")}</span>
										</div>
									</li>`
								)
							}
							last_date_person = res[i]["ChatDate"];
							$('.chat-list').animate({scrollTop:$('.chat-list ul').height()},'1000'); 
						}
					}
				}); 
			} 

			myOffcanvas.addEventListener('hidden.bs.offcanvas', event => {
				chat_mode = "";
				$("#chat-display").addClass("d-none");
				$("#chat-list").removeClass("d-none"); 
			})
			myOffcanvas.addEventListener('show.bs.offcanvas', event => { 
				load_data_chat();
			})
		});
	</script>  -->

</body>

</html>
