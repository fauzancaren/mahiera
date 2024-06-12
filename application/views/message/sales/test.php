font-weight: bolder;
height: 20px;
padding-left :16px;
background:#212c30;
}
.sidebar > .sidebar-menu >ul > li > ul > li > a{
display: block;
margin-inline-start: 0px;
margin-inline-end: 0px;
padding: 5px 5px 5px 10px;

box-sizing: border-box;
list-style-type: disc;
text-decoration:none;
font-size: 12px;
background: #293235;
color: #92989a;
}
.sidebar > .sidebar-menu >ul > li > ul > li > a > i{
width: 30px;
text-align: center;
}
.sidebar > .sidebar-menu >ul > li > ul > li > a.active{
color:white;
}
.sidebar > .sidebar-menu >ul > li > ul > li > a:hover{
background: #3d484d;
color:white;
}

@media (max-width: 575.98px) {
.wrapper{
flex-direction: column;
}
.sidebar {
position: fixed;
bottom: 0;
z-index: 950;
display: flex;
flex-direction: column;
max-width: 100%;
outline: 0;
top: 0;
left: 0;
width: 400px;
background: #222d32;
border-right: 1px solid rgba(0,0,0,.2);
transition: all .3s ease-in-out;
}

.sidebar.hide{
z-index: 0;
border-right:none;
position: relative;
height: 40px;
width: 100%;
max-width: 100%;
min-height: 40px;
transition: all .7s ease-in-out;
}

.sidebar span{
display: inline-block;
visibility: visible;
opacity: 1;
transition: opacity 0.5s, visibility 0.5s, display 0.5s;
}
.sidebar.hide span{
display: inline-block;
visibility: visible;
opacity:1;
transition: opacity 0.5s, visibility 0.5s, display 0.5s;
}
.sidebar.hide .search-menu{
display :none;
}
.sidebar.hide .sidebar-menu{
display :none;
}
.sidebar.hide > .header > i{
width: 30px;
text-align: center;
}.sidebar.hide > .header > span{
text-align: center;
}
.sidebar > .sidebar-menu >ul {
margin: 0;
padding: 0;
overflow-x: auto;
overflow-y: scroll;
}
}

/* width */
::-webkit-scrollbar {
width: 3px;
height: 3px;
opacity: .5;
}

/* Track */
::-webkit-scrollbar-track {
border-radius: 5px;
opacity: .5;
}

/* Handle */
::-webkit-scrollbar-thumb {
background: #f08d00;
border-radius: 2px;
opacity: .5;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
background:#babfc329;
opacity: .5;
}


.box-chat{
border: 1px solid rgba(0,0,0,.125);
border-radius: .25rem;
border-top: 2px solid #f0ad4e;
font-size:1rem;
width:250px;
padding:5px;
background: #fff;
}

.box-chat-header[aria-expanded="true"]:after {
font-family: "Font Awesome 5 Free";
font-weight: 900;
content: "\f107";
position: absolute;
right: 10px;
}
.box-chat-header.collapsed[aria-expanded="false"]:after{
font-family: "Font Awesome 5 Free";
font-weight: 900;
content: "\f106";
position: absolute;
right: 10px;
}
.box-chat-list{
height:100%;
min-height:400px;
border:1px solid #eee;
overflow: auto;
}
.box-chat-list > ul {
margin: 0;
padding: 0;
}
.box-chat-list > ul > li{
display: block;
margin-inline-start: 0px;
margin-inline-end: 0px;
padding: 10px 25px 10px 15px;

box-sizing: border-box;
list-style-type: disc;
text-decoration:none;
font-size: 12px;
border: 0.5px solid #eee;
}

#nav-tab > .nav-link{
color: gray;
background:transparent;
width: 33%;
}
#nav-tab > .active{
color: #0d6efd;
background:transparent;
border-bottom: 2px solid #0d6efd;
border-radius: 0px;
}

.list-group-chat{
font-size:14px;
}

.btn-circle.btn-xl {
width: 70px;
height: 70px;
padding: 10px 16px;
border-radius: 35px;
font-size: 24px;
line-height: 1.33;
}

.btn-circle {
background: #454552;
color: white;
width: 3rem;
height: 3rem;
border-radius: 50%;
font-size: 1.5rem;
transform-origin: center center;
backface-visibility: hidden;
text-align: center;
overflow: hidden;
-webkit-font-smoothing: antialiased;
}
.btn-circle:active, .btn-circle:hover{
color: gray;

}

.header-navigation {
padding: .25rem .75rem;
line-height: 3;
margin: 3px;
border: 1px solid #888888!important;
color: #353535!important;
border-radius: .25rem;
background: #f8f9fa!important;
transition: box-shadow .15s ease-in-out;
text-decoration: none;
position: relative;
cursor:pointer;
}
.chat-image > img{

border-radius: 50%;
}
.text-badge{
padding: 0.25em 0.5em;
position: absolute;
font-size: 0.5em;
left: 90% !important;
top: 20% !important;

font-weight: 700;
line-height: 1;
color: #fff;
text-align: center;
white-space: nowrap;
vertical-align: baseline;
}
/*Loader*/
#loader-wrapper {
position: fixed;
top: 0;
left: 0;
background: white;
width: 100%;
height: 100%;
z-index: 1000000;
}

/*Text Loading */
h1{
display: block;
position: relative;
top: 40%;
font-size: 50px;
font-family: Brush Script Std;
text-align: center;
color: blue;
z-index: 1001;
animation: mymove 3s infinite alternate;
}

@keyframes mymove{
0%{
opacity: 100;
}

80%{
opacity: 0;
}
}
@keyframes spin {
0% {
transform: rotate(0deg) ;

}

100% {
transform: rotate(360deg);
}
}
.loaded #loader {
opacity: 0;
transition: all 0.3s ease-out;
}
.loaded h1{
opacity: 0;
transition: all 0.3s ease-out;
}
.loaded #loader-wrapper {
visibility: hidden;
transform: translateY(-100%);
transition: all 0.3s 1s ease-out;
}

.small-box {
border-radius: .25rem;
box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
display: block;
margin-bottom: 20px;
position: relative;
}
.small-box>.inner {
padding: 10px;
}
.small-box h3, .small-box p {
z-index: 5;
}
.small-box h3 {
font-size: 2.2rem;
font-weight: 700;
margin: 0 0 10px;
padding: 0;
white-space: nowrap;
}
.small-box p {
font-size: 20px;
}
.small-box h3, .small-box p {
z-index: 5;
}
.small-box>.small-box-footer {
background-color: rgba(0,0,0,.1);
color: rgba(255,255,255,.8);
display: block;
padding: 3px 0;
position: relative;
text-align: center;
text-decoration: none;
z-index: 10;
}
.small-box .icon>i.ion {
font-size: 70px;
top: 20px;
}
.small-box .icon>i {
font-size: 90px;
position: absolute;
right: 15px;
top: 15px;
transition: -webkit-transform .3s linear;
transition: transform .3s linear;
transition: transform .3s linear,-webkit-transform .3s linear;
}
.small-box .icon {
color: rgba(0,0,0,.15);
z-index: 0;
}
.small-box>.small-box-footer:hover {
background-color: rgba(0,0,0,.15);
color: #fff;
}
canvas {
-moz-user-select: none;
-webkit-user-select: none;
-ms-user-select: none;
}
.border-li > li{
list-style-position: inside;
border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
.border-li > li:last-child {
border-bottom: none;
}
.border-li > li:hover {
background: rgba(0, 0, 0, 0.125);
cursor: pointer;
}
.grafik-card {
position: relative;
padding: 0.5rem;
min-height: 350px;
overflow:hidden;
}
.grafik-card-body {
position: absolute;
padding: 0rem;
top: 0;
left: 0;
width:100%;
height:100%;
}
.box-loading{
position: relative;
width: 100%;
padding: 0.5rem;
min-height: 350px;

}
.box-loading-wrapper{
transform: scale(2.5);
}
.box-loading-text{

position: absolute;
top: 3rem;
color: gray;
transform: scale(2.5);
}
.loader{
height: 25px;
width: 1px;
position: absolute;
animation: rotate 3.5s linear infinite;
}
.loader .dot{
top: 30px;
height: 7px;
width: 7px;
background: #ff6600;
border-radius: 50%;
position: relative;
}
.text{
position: absolute;
bottom: -85px;
font-size: 25px;
font-weight: 400;
font-family: 'Poppins',sans-serif;
color: #fff;
}
@keyframes rotate {
30%{
transform: rotate(220deg);
}
40%{
transform: rotate(450deg);
opacity: 1;
}
75%{
transform: rotate(720deg);
opacity: 1;
}
76%{
opacity: 0;
}
100%{
opacity: 0;
transform: rotate(0deg);
}
}
.loader:nth-child(1){
animation-delay: 0.15s;
}
.loader:nth-child(2){
animation-delay: 0.3s;
}
.loader:nth-child(3){
animation-delay: 0.45s;
}
.loader:nth-child(4){
animation-delay: 0.6s;
}
.loader:nth-child(5){
animation-delay: 0.75s;
}
.loader:nth-child(6){
animation-delay: 0.9s;
}
.border-top-orange{
border-top: 2px solid #f0ad4e;
}
.card-delivery{
font-size: 0.75rem;
margin-bottom: 5px;
}
.card-delivery.select{
border: 1px solid #f0ad4e;
background-color: #f0ad4e17;
}
.modal-footer > button{
padding-top: .2rem!important;
padding-bottom: .2rem!important;
}
.bg-pinpoint{
display: flex;
-webkit-box-align: center;
align-items: center;
-webkit-box-pack: justify;
justify-content: space-between;
padding: 8px 16px;
border: 1px solid var(--N75,#E5E7E9);
border-radius: 8px;
background: url('<?= base_url("asset/image/mgs-erp/bg-map.png") ?>') center center / cover no-repeat rgb(242, 242, 242);
}
.label-small{
font-family: 'Mukta', sans-serif;
font-size: 0.75rem;
}
.alert-orange {
color: #632f01;
background-color: #ffdcb2;
border-color: #ffbb68;
}
.select::before {
content: "";
position: absolute;
top: 12px;
left: 0px;
width: 6px;
height: 34px;
border-top-right-radius: 8px;
border-bottom-right-radius: 8px;
background-color: #ea8303;
}
.action-label {
color: #ea8303;
text-decoration:none;
cursor:pointer;
}
.action-label:hover {
color: #864400;
}
.action-space {
content: "";
display: block;
width: 2px;
height: 16px;
margin: 0px 6px;
background-color: var(--N75,#E5E7E9);
}
.pagination > li > a
{
background-color: white;
color: #ff8b00;
font-size: 0.75rem;
}
.page-link:focus {
color: #d4582a;
background-color: #fff;
border-color: #fa8100;
outline: 0;
/* box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); */
}
.pagination > li > a:focus,
.pagination > li > a:hover,
.pagination > li > span:focus,
.pagination > li > span:hover
{
outline: none;
color: #d4582a;
background-color: #eee;
border-color: #ddd;
}

.pagination > .active > a
{
color: white;background-color: #d4582a !Important;
border: solid 1px #d4582acc !important;
}
.pagination > .disabled > a
{
background-color: #ededed !Important;
}
.paginate_button > a:focus {
border-color: #fa8100;
-webkit-box-shadow: none;
box-shadow: none;
outline: -webkit-focus-ring-color auto 0px;
box-shadow: none;
}
.pagination > .active > a:hover,
.pagination > .active > a:focus
{
background-color: #d4582a !Important;
border: solid 1px #d4582a;
outline: 0;
box-shadow: 0 0 0 0.1rem rgba(253, 128, 13, 0.25);
}


.btn:focus,.btn:active {
-webkit-box-shadow: none;
box-shadow: none;
outline: -webkit-focus-ring-color auto 0px;
}
.page-item:focus,.page-item:active {
-webkit-box-shadow: none;
box-shadow: none;
outline: -webkit-focus-ring-color auto 0px;
}
.input-group >.input-group-prepend {
flex: 0 0 30%;
}
.input-group .input-group-text {
width: 30%;
}
.col-form-label{
padding-top: 0px;
padding-bottom: 0px;
}
span.pointer {
cursor: pointer;
transition: all 0.3s;
-webkit-transition: all 0.3s;
}
span.pointer:hover {
box-shadow: 0 0 15px rgb(255 86 0 / 75%);
}


.pointer > i{
cursor: pointer;
transition: all 0.3s;
-webkit-transition: all 0.3s;
}

.pointer:hover > i{
text-shadow: 0 0 15px rgb(255 86 0 / 75%);

}
.form-control:focus{
color: #212529;
background-color: #fff;
border-color: #fa8100;
outline: 0;
box-shadow: 0 0 0 0.1rem rgba(253, 128, 13, 0.25);
}


.form-check-input:checked {
background-color: #f29800;
border-color: #ba7c05;
}
.form-check-input:focus {
border-color: #f29800;
-webkit-box-shadow: none;
box-shadow: none;
outline: -webkit-focus-ring-color auto 0px;
box-shadow: none;
}

.form-control[readonly]:focus{
border-color: #dee2e6;
background-color: #e9ecef;
outline: 0;
box-shadow: 0 0 0 0.1rem #dee2e6;
}

.form-select:focus {
border-color: #fa8100;
-webkit-box-shadow: none;
box-shadow: none;
outline: -webkit-focus-ring-color auto 0px;
box-shadow: none;
}
td.dtr-control {
width: 20px;
}
input:-webkit-autofill, input:focus:-webkit-autofill {
-webkit-box-shadow: 0 0 0 100px rgb(255, 255, 255) inset;
}
textarea:-webkit-autofill, textarea:focus:-webkit-autofill {
-webkit-box-shadow: 0 0 0 100px rgb(255, 255, 255) inset;
}
form .error {
color: #ff0000;
font-size: 0.75rem;
}
form input.error, form textarea.error{
color: #212529;
font-size: 0.875rem;
background-color: #fff;
border-color: #e67580 !important;
outline: 0;
box-shadow: 0 0 0 0.1rem rgb(253 128 13 / 25%);
}

.col-form-label,.dataTables_info{
font-size: 0.75rem;
color: #6c757d !important;
}

.btn-sm, .btn-group-sm > .btn {
padding: 0.5rem 0.5rem;
font-size: 0.75rem;
border-radius: 0.25rem;
}

.btn-primary {
color: #fff;
background-color: #0a58ca;
border-color: #5d57d8;
}
.card-header{
background-color:white;
}
.swal2-loader{
border-color: #ff6a2e #ff000045 #ff8400 #d5671882;
}
.img-circular{
width: 150px;
height: 150px;
background-size: cover;
display: block;
border-radius: 75px;
-webkit-border-radius: 75px;
-moz-border-radius: 75px;
}
label.cabinet{
display: flex;
cursor: pointer;
position: relative;
justify-content: center;
align-content: space-between;
}

label.cabinet input.file{
position: absolute;
height: 100%;
width: 150px;
opacity: 0;
-moz-opacity: 0;
filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
cursor: pointer;
}

#upload-demo{
width: 250px;
height: 250px;
padding-bottom:25px;
}

.daterangepicker .ranges li.active {
background-color: #ff6600 !important ;
color: #fff;
}
.daterangepicker td.active, .daterangepicker td.active:hover {
background-color: #ff6600;
border-color: transparent;
color: #fff;
}
.label-border-right {
text-align:left;
width:96%;
border-bottom: 1px solid #dee2e6;
line-height:0.1em;
margin: 10px 10px 5px 15px;
}
.label-border-right .label-dialog {
background:#fff;
padding:0 10px;
font-family: 'Mukta', sans-serif;
font-weight:bold;
}
@media (max-width: 575.98px) {

.label-border-right{
text-align:center;
width: 93%;
}
}
.custom-select,.select2-selection__rendered{
font-size: 0.75rem;
}

.btn-orange {
color: #fff;
background-color: #ff6600;
border-color: #ff6600;
}
.btn-orange:hover {
color: #fff;
background-color: #db5800;
border-color: #db5800;
}
.btn-check:focus+.btn-orange, .btn-orange:focus {
color: #fff;
background-color: #db5800;
border-color: #db5800;
box-shadow: 0 0 0 0.25rem rgb(60 153 110 / 50%);
}

@media (max-width: 575.98px) {

.btn-hide > span {
display: none;
}
.btn-hide:hover > span {
display: none;
}
.paginate_button > a{
//padding : 5px;
}
}
.table th {
border-top: none;
}
.input-group > .select2-container--bootstrap {
width: auto;
flex: 1 1 auto;
border-radius: .25rem;
border: 1px solid #ced4da;
border-top-right-radius: 0;
border-bottom-right-radius: 0;
}

.input-group > .select2-container--bootstrap .select2-selection--single {
height: 100%;
line-height: inherit;
padding: .25rem 0;
font-size: .875rem;
border-top-left-radius: .25rem;
border-bottom-left-radius: .25rem;
border-top-right-radius: 0;
border-bottom-right-radius: 0;
}
.input-group > button {
padding: 0.3rem 0.5rem;
border-top-left-radius: 0;
border-bottom-left-radius: 0;
border-top-right-radius: .25rem;
border-bottom-right-radius: .25rem;
}





#description {
font-family: Roboto;
font-size: 15px;
font-weight: 300;
}

#infowindow-content .title {
font-weight: bold;
}

#infowindow-content {
display: none;
}

#map #infowindow-content {
display: inline;
}

.pac-card {
margin: 10px 10px 0 0;
border-radius: 2px 0 0 2px;
box-sizing: border-box;
-moz-box-sizing: border-box;
outline: none;
box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
background-color: #fff;
font-family: Roboto;
}

#pac-container {
padding-bottom: 12px;
margin-right: 12px;
}
.pac-container{
z-index: 2000;
}
.pac-controls {
display: inline-block;
padding: 5px 11px;
}

.pac-controls label {
font-family: Roboto;
font-size: 13px;
font-weight: 300;
}
.input-in-table{
width:60px;
font-weight: 400;
border: 1px solid #ced4da;
border-radius: .2rem;
padding: .25rem .25rem;
font-size: .75rem;
transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
min-height: calc(1.5em + .5rem + 2px);
color: #212529;
background-color: #fff;
background-clip: padding-box;
}
.input-in-table:focus {
color: #212529;
background-color: #fff;
border-color: #fa8100;
outline: 0;
box-shadow:
}
.input-in-table:read-only {
background-color: #e9ecef;
}
#text-pac-input {
font-family: Roboto;
text-overflow: ellipsis;
width: 100%;
font-weight: 400;
line-height: 2;
color: #212529;
background-color: #fff;
background-clip: padding-box;
border: 1px solid #ced4da;
-webkit-appearance: none;
-moz-appearance: none;
appearance: none;
transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
min-height: calc(1.5em + .5rem + 2px);
padding: .25rem .5rem;
font-size: .875rem;
border-radius: .2rem;
}
#text-pac-input:before {
font-family: "Font Awesome 5 Free";
font-weight: 600;
content: "\f104";
position: relative;
left: -5px;
color:gray;
}

#text-pac-input:focus {
color: #212529;
background-color: #fff;
border-color: #fa8100;
outline: 0;
box-shadow:
}

#title {
color: #fff;
background-color: #4d90fe;
font-size: 25px;
font-weight: 500;
padding: 6px 12px;
}
#target {
width: 345px;
}
#map {
height: 100%;
}

#map .centerButton{
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
z-index: 1;
margin-top: -65px;

background-color: #ff6600;
border-radius: 0.25rem;
padding: 0.2rem 0.2rem;
color: white;
font-weight: 600;
font-size: 12px;
cursor: pointer;
transition: background-color 0.3s;
}
#map .centerButton:hover{
background-color: #ec6208;
color: #f2d2d2;
transition: background-color 0.3s;
}
#map .centerMarker{
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
width: 28px;
height: 42px;
background-image: url('https://breezeblock.co.id/asset/image/pin-shadow.svg');
background-position: center center;
background-repeat: no-repeat;

}
#map .centerMarker::before{
-webkit-filter: drop-shadow( 0px 6px 2px rgba(0, 0, 0, .5));
filter: drop-shadow( 0px 6px 2px rgba(0, 0, 0, .5));
filter: color(red);
background:url('https://breezeblock.co.id/asset/image/pin.svg') no-repeat center;
content: "";
position: absolute;
bottom: 50%;
left: 0px;
width: 100%;
height: 100%;
transform: translateY(0px);
transition: transform 0.3s ease 0s;
will-change: transform;
}
#map .centerMarker.mousedown::before{
transform: translateY(-13px);
}
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
background-color: #fff6f0;
color: #232121;;
}
.input-filter {
position: relative;
padding-right: 0!important;
padding-left: .5rem!important;
margin-bottom:.5rem!important;
max-height:1.5rem;
}
.input-filter.end-input {
padding-right: .5rem!important;
}
.input-filter > i:nth-child(1) {
position: absolute;
z-index: 1;
top: 0.35rem;
left: 1rem;
font-size: 1rem;
}
.input-filter > button{
position: absolute;
min-height: calc(1.5em + .5rem + 1px);
z-index: 1;
background: #e79726;
color: white;
top: 1px;
border-radius: 0.15rem;
border-bottom-left-radius: 0;
border-top-left-radius: 0;
right: 9px;
font-size: 0.75rem;
padding: 0 0.5rem;
}
.input-filter > button:hover{
background: #ca821d;
color: white;
}
.input-filter > i:nth-child(3)::before {
position: absolute;
z-index: 1;
top: 0.4rem;
right: 8px;
font-size: 1rem;
font-family: "Font Awesome 5 Free";
font-weight: 600;
content: "\f107";
transition: transform 1s;
-webkit-transition: transform 1s,top 1s;
}
.end-input.input-filter > i:nth-child(3)::before{
right: 1rem;
}
.input-filter.open > i:nth-child(3)::before {
top: 0.3rem;
-ms-transform: rotate(-180deg); /* IE 9 */
-webkit-transform: rotate(-180deg);
transform: rotate(-180deg);
transition: transform 1s,top 1s;
}
.input-filter > .select-row{
cursor: pointer;
position: relative;
transition: all 0.5s;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
}
.input-filter.open > .select-row{
border-bottom-left-radius: 0;
border-bottom-right-radius: 0;
transition: all 0.5s;
}
.input-filter > .i-search {
padding: 5px 21px 5px 30px;
font-size: 0.7rem;
background: #fff9f1;
}
.input-filter > .i-search.button {
padding: 5px 3px 5px 5px;
}
.input-filter > .i-search.button:focus {
padding: 5px 3px 5px 5px;
}
.input-filter > .i-search:focus {
padding-left: 30px;
z-index: 0;
}
.input-filter > .s-filter {
font-size: 0.7rem;
}
.custom-options {
position: absolute;
display: block;
top: 1.7rem!important;
left: 0.5rem!important;
right: 0;
border: 1px solid #ced4da;
border-top: 0;
background: #fff;
font-size: 0.85rem;
transition: all 0.5s;
opacity: 0;
visibility: hidden;
z-index: 2;
cursor: pointer;
transition: all 0.5s;
color: #3b3b3b;
line-height: 25px;
font-weight: 300;
}
.input-filter.open .custom-options {
opacity: 1;
visibility: visible;
pointer-events: all;
}

.end-input > .custom-options {
margin-right: .5rem!important;
}
.custom-option {
position: relative;
display: block;
padding: 1px 4px 0 7px;
font-size: 0.7rem;
}
.custom-option:hover {
cursor: pointer;
color: gray;
}
.custom-option.selected {
font-weight:bold;
}
.custom-option.selected:after {
font-family: "Font Awesome 5 Free";
font-weight: 600;
color: green;
content: "\f00c";
position: relative;
float: right;
}
.custom-option-multiple {
position: relative;
display: block;
padding: 1px 4px 0 7px;
font-size: 0.7rem;
}
.custom-option-multiple:hover {
cursor: pointer;
color: gray;
}
.custom-option-multiple.selected {
font-weight:bold;
}
.custom-option-multiple.selected:after {
font-family: "Font Awesome 5 Free";
font-weight: 600;
color: green;
content: "\f00c";
position: relative;
float: right;
}

select:focus > option:checked {
background: #f0ad4e !important;

}
option:hover {
box-shadow: 0 0 10px 100px orange inset;
}
.dropdown-menu{
width: 20rem;
}
.bg-search {
background: #fbfbfb;
border-color: #e6e6e6;
}
.selected .card.card-body {
background-color: #f1f1f1;
box-shadow: 1px 1px 5px #dadada;
}

.tb-sales{
border-style: hidden;
border-collapse: collapse;
}
.tb-sales >.dtr-control {
width: 20px;
border: none;
padding: 0.25rem;
}
.tb-text-top{
vertical-align: top;
}
.datatable-empty{
font-family: 'Mukta', sans-serif;
font-size: 1.5rem;
color: #f79e18;
}
.datatable-empty > i{
padding: 2rem;
}
.datatable-detail > span{
border-radius: 0.2rem;
color: gray;
padding: 0.25rem .5rem;
cursor: pointer;
transition: all .5s;
}
.datatable-detail > span:hover{
color: #ff6a00;
transition: all .5s;
}
.datatable-header{
position: relative;
padding: 0.5rem;
margin: 0;
border: 1px solid #dadada;
background: #FFFFFF;
border-radius: 0.5rem;
box-shadow: 0 0.1rem 0.5rem rgba(0,0,0,.075)!important;
transition: box-shadow .3s;
}
.box-in-table {
border-radius: .2rem!important;
border: 1px solid #d8cbcb!important;
}
.datatable-header:hover{
box-shadow: 0 0.1rem 0.3rem #00000085!important;
transition: box-shadow .3s;
}
.datatable-header > .datatable-action{
display: flex;
height: 0;
opacity: 0;
transition: height .5s;
}
.datatable-header:hover > .datatable-action{
height: 40px;
opacity: 1;
transition: height .5s,opacity 1s;
}
.datatable-header:hover > .datatable-action > button{
z-index: 1;
transition: all .3s;
}
.datatable-header > .image-logo {
max-height: 20px;
position: absolute;
top: 0;
left: 0;
opacity: 0.3;
left: -25px;
-webkit-transform: rotate(314deg);
-moz-transform: rotate(314deg);
-o-transform: rotate(314deg);
writing-mode: lr-tb;
}
.strikethrough {
position: relative;
font-size: 0.6rem;
}
.strikethrough:before {
position: absolute;
content: "";
left: 0;
top: 50%;
right: 0;
border-top: 1px solid;
border-color: #ff000050;

-webkit-transform:rotate(-5deg);
-moz-transform:rotate(-5deg);
-ms-transform:rotate(-5deg);
-o-transform:rotate(-5deg);
transform:rotate(-5deg);
}
.w-16rem{
width:16rem;
}
.dropdown-menu-sm{
font-size:0.7rem;
padding:0.2rem
}
.dropdown-menu-sm > .dropdown-divider{
margin: .2rem 0;
}
.action-table-single{
position: relative;
}
.row-table{

}
.action-table-single > a{
position: absolute;
right: -20px;
bottom: 7px;
opacity: 0;
transition: opacity 0.7s,right 0.5s;
}
.row-table:hover .action-table-single > a{
right: 13px;
opacity: 1;
}


.group-input{
position: relative;
}
.group-input>button{
position: absolute;
right: 12px;
top: 0;
height: 100%;
justify-content: center !important;
align-items: center !important;
padding: 0;
min-width: 30px;
border-top-left-radius: 0;
border-bottom-left-radius: 0;
}

.fa-stack.tool-info{
font-size:0.5rem;
}
.tooltip-inner{
text-align:left;
}
.tool-desc{
font-size: 0.7rem;
}
</style>
<!-- JS SOCKET IO -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.min.js" integrity="sha512-eVL5Lb9al9FzgR63gDs1MxcDS2wFu3loYAgjIH0+Hg38tCS8Ag62dwKyH+wzDb+QauDpEZjXbMn11blw8cbTJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="loaded">
      <table id="tb_data" class="table align-middle responsive dataTable no-footer dtr-inline" style="font-family: Sans-serif, Helvetica; font-size: 80%; width: 100%;" role="grid" aria-describedby="tb_data_info">
            <thead class="thead-dark" style="display:none">
                  <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="tb_data" rowspan="1" colspan="1" style="width: 0px;" aria-label="nama: activate to sort column ascending">nama</th>
                  </tr>
            </thead>
            <tbody>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">01 June 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0001/05/VI/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Ibu Irin</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">087774559986</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Grand Bintaro</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">01 June 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">247,500</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">247,500</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse show" id="detail-5691">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0024 - MTY Star </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 165,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">AYD</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">22.5 x 5.5 x 2cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">2 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 247,500</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5691" id="span-5691" aria-expanded="true">Sembunyikan <i class="fas fa-angle-up"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5691").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">31 May 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0042/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Bagus</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">085811609111</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Pamulang Elok Blok O2 No.1.Pondok Petir </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">31 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">600,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">600,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5683">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0032 - Rustic Wave </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 150,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">TFK</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">23 x 5.5 x 2cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">2 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 300,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">CTG0003 - COATING GLOSS </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 60,000</span>
                                                            <span style="color: gray;">/KLG</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 Liter</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">5 KLG</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 300,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5683" id="span-5683" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5683").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0041/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Arief Tunjui</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081283068323 / 081299417338</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Perum Panorama Bali Residence Blok E2 No.10 Ciseeng</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">31 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">150,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">150,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5680">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0011 - GPS Jumbo </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 150,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">PSL</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">23.5 x 6 x 2cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 150,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5680" id="span-5680" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5680").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0039/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Ibu Susi</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081363411877</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">jL Garuda B23 No.18 Komplek Sarua Permai</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">31 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,330,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,330,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5676">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RWT0030 - White Horizon B </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 19,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">70 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,330,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5676" id="span-5676" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5676").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0040/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Ibu Dwi Lembana</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081229911323</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">The Avani Cluster Lavanya Ammarila D9 No.3 Sampora Cisauk</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">31 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">3,258,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">58,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">3,200,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5679">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0078 - Nako Minimalis Rata </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">72 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,008,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0021 - KC </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 150,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">TFK</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">23 x 6 x 2cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">15 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 2,250,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5679" id="span-5679" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5679").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0043/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Ibu Hany Arief</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">0818885177 / 081995885177</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Terrace Garden No.B4, Jl. Suka Bakti 3A no.2, Serua Indah-Ciputat, Tangsel 15414</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">31 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">855,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">855,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5690">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RWT0030 - White Horizon B </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 19,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">45 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 855,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5690" id="span-5690" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5690").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">29 May 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0038/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Haryanto Rohai</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081222293882</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Perumahan Villa Dago tol
                                                            Blok C3 No.7
                                                            Pamulang</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">29 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Lunas</span><br>
                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah DP</span><br>
                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah Lunas</span><br>
                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Dijadwalkan</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Pengiriman</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Selesai</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>

                              <span class='fa-stack text-info tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum PO</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Proses Vendor</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Ready</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">120,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">120,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5674">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">CTG0003 - COATING GLOSS </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 60,000</span>
                                                            <span style="color: gray;">/KLG</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 Liter</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">2 KLG</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 120,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5674" id="span-5674" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5674").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0037/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Ibu Yoan Agnes</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081280572928 / 081283205149</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Serpong Lagoon Cluster Lotus Garden Blok E6/1A Tangsel</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">29 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Lunas</span><br>
                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah DP</span><br>
                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah Lunas</span><br>
                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Dijadwalkan</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Pengiriman</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Selesai</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>

                              <span class='fa-stack text-info tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum PO</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Proses Vendor</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Ready</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">319,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">19,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">300,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5670">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0033 - HDS Block </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 14,500</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">22 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 319,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5670" id="span-5670" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5670").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0034/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Agus </span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081113201563</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">jL Cipondoh Puri permata</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">29 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Lunas</span><br>
                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah DP</span><br>
                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah Lunas</span><br>
                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Dijadwalkan</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Pengiriman</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Selesai</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>

                              <span class='fa-stack text-info tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum PO</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Proses Vendor</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Ready</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">770,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">770,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5662">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0065 - Roster L </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 9cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">55 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 770,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5662" id="span-5662" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5662").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0035/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Masjid Raya BPA Ittihadul Ulum</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">085814199549</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Bumi Puspiptek Asri Sektor 1 Ds.Pagedangan Kec.Pagedangan Kab.Tangerang</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">29 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Lunas</span><br>
                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah DP</span><br>
                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah Lunas</span><br>
                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Dijadwalkan</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Pengiriman</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Selesai</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>

                              <span class='fa-stack text-info tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum PO</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Proses Vendor</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Ready</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">2,520,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">2,520,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5667">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0010 - Bintang KJR </span><br>
                                                            <span class="strikethrough">
                                                                  <span class="fw-bold" style="color: gray;">Rp. 13,000</span>
                                                                  <span style="color: gray;">/PCS</span>
                                                            </span>&nbsp;
                                                            <span class="fw-bold" style="color: gray;">Rp. 10,000</span>
                                                            <span style="color: gray;">/PCS</span>
                                                            <br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">PSL</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 8cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">252 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="strikethrough">
                                                                  <span class="fw-bold" style="color: gray;">Rp. 3,276,000</span>
                                                            </span><br>
                                                            <span class="fw-bold text-orange">Rp. 2,520,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5667" id="span-5667" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5667").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0036/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Dwi Susanto</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081318267952</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Giri Loka 1 Blok E No.19 BSD</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">29 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Lunas</span><br>
                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah DP</span><br>
                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah Lunas</span><br>
                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Dijadwalkan</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Pengiriman</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Selesai</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>

                              <span class='fa-stack text-info tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum PO</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Proses Vendor</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Ready</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,197,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,197,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5669">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RED0008 - RED CP </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 19,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">PSL</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">63 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,197,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5669" id="span-5669" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5669").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">28 May 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0032/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Acin</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">0811890929</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Project Muara Karang barat
                                                            Jakarta</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">28 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Lunas</span><br>
                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah DP</span><br>
                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Sudah Lunas</span><br>
                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-dollar-sign fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum Dijadwalkan</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Pengiriman</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Selesai</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>

                              <span class='fa-stack text-info tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-truck fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                              <span class='fa-stack text-secondary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Belum PO</span><br>

                              <span class='fa-stack text-primary tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Proses Vendor</span><br>

                              <span class='fa-stack text-success tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Ready</span><br>

                              <span class='fa-stack text-danger tool-info'>
                                    <i class='far fa-circle fa-stack-2x'></i>
                                    <i class='fas fa-cubes fa-stack-1x'></i>
                              </span>
                              <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,275,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">150,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,425,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5657">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0201 - Square Block </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 17,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">75 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,275,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5657" id="span-5657" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5657").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0031/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Agung Muharam</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081315698757</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Duta Niaga Raya TM 9/20
                                                            Pondok Pinang</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">28 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">5,200,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">100,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">5,100,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5655">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RWT0029 - Kawung White </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 13,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">19.5 x 19.5 x 7 cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">400 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 5,200,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">Bpk Dani / Firman </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">08181563370 </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">Jl. Ciputat Raya No.123, RT.10/RW.1, Pd. Pinang, Kec. Kby. Lama, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12310, Indonesia </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5655" id="span-5655" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5655").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0033/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Masjid Nurul Iman</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">0811855287 / 08192150455</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;"> Jl. Taman Pejambon No.6 Senen, RT 9 / RW 5 Jakart Pusat 10110</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">28 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">3,850,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">3,850,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5658">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0149 - Nako Minimalis Runcing </span><br>
                                                            <span class="strikethrough">
                                                                  <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                                  <span style="color: gray;">/PCS</span>
                                                            </span>&nbsp;
                                                            <span class="fw-bold" style="color: gray;">Rp. 11,000</span>
                                                            <span style="color: gray;">/PCS</span>
                                                            <br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">350 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="strikethrough">
                                                                  <span class="fw-bold" style="color: gray;">Rp. 4,900,000</span>
                                                            </span><br>
                                                            <span class="fw-bold text-orange">Rp. 3,850,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5658" id="span-5658" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5658").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">26 May 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0029/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Pepen Saefudin (PT TOTAL BANGUN PERSADA)</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081213646610 / 083841241522</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">PT Total Bangun Persada Proyek Thamrin Nine Phase II jln baturaja 38-39 kebon melati tanah abang (dibelakang gedung UOB)</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">29,000,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">29,000,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5640">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">JSP0013 - Frame Kolom/ Tiang </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 175,000</span>
                                                            <span style="color: gray;">/Meter</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 m</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">40 Meter</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 7,000,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">JSP0015 - Jasa Pemasangan Roster </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 250,000</span>
                                                            <span style="color: gray;">/m2</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">m2</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">40 m2</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 10,000,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0021 - Bunga Bali </span><br>
                                                            <span class="strikethrough">
                                                                  <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                                  <span style="color: gray;">/PCS</span>
                                                            </span>&nbsp;
                                                            <span class="fw-bold" style="color: gray;">Rp. 12,000</span>
                                                            <span style="color: gray;">/PCS</span>
                                                            <br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 9cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1,000 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="strikethrough">
                                                                  <span class="fw-bold" style="color: gray;">Rp. 14,000,000</span>
                                                            </span><br>
                                                            <span class="fw-bold text-orange">Rp. 12,000,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5640" id="span-5640" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5640").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0030/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Pepen Saefudin (PT TOTAL BANGUN PERSADA)</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081213646610 / 083841241522</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">PT Total Bangun Persada Proyek Thamrin Nine Phase II jln baturaja 38-39 kebon melati tanah abang (dibelakang gedung UOB)</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,200,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,200,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5641">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">CTG0001 - COATING DOFF </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 60,000</span>
                                                            <span style="color: gray;">/KLG</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 Liter</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 KLG</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,200,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5641" id="span-5641" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5641").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0024/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Andi</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">087822012030 / 0895333233878</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Villa rizki ilhami B4 no.31 kelapa dua tangerang</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">5,700,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">5,700,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5630">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RWT0048 - Hole Star LB 5 White </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 19,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20x20x10cm </span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">300 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 5,700,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5630" id="span-5630" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5630").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0025/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Zezen Zaenal Mutaqien</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081210410104</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">jL Garuda 1 Villa Pamulang Blok DG 9 No.19 RT 04/011.Pondok Petir</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">700,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">700,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5632">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0149 - Nako Minimalis Runcing </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">50 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 700,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">GO-BOX </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5632" id="span-5632" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5632").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0026/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Rahadian</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">0811935935</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Serpong Lagoon Cluster Pelican Blok C3 No.7 Tangerang Selatan</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,680,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">80,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,600,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5635">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0174 - Roster YZ </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">120 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,680,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5635" id="span-5635" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5635").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0027/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk Benny</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081281268857</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Bumi Serpong Residence Blok K No.14 jL Gunung Krakatau 3.Pamulang 2</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,625,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">1,625,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5636">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0151 - Flying </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 13,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 8cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">125 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,625,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5636" id="span-5636" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5636").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0028/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Ibu Anin</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">08567803213</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">jL Cendrawasih 5</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">26 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">960,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">960,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5637">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0030 - P 20 </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 140,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">AYD</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 5 x 2cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">6 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 840,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">CTG0003 - COATING GLOSS </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 60,000</span>
                                                            <span style="color: gray;">/KLG</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 Liter</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">2 KLG</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 120,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5637" id="span-5637" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5637").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">25 May 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0021/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Bpk zendri</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081393321133 / 081395008331</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">golden vienna 2, blok c2, no. 15</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">25 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">3,300,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">3,300,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5616">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0011 - GPS Jumbo </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 150,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">TFK</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">23.5 x 6 x 2cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 3,000,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">CTG0001 - COATING DOFF </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 60,000</span>
                                                            <span style="color: gray;">/KLG</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">1 Liter</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">5 KLG</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 300,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5616" id="span-5616" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5616").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0022/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Muhammad Uqbah</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">085211133044</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Cipulir</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">25 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">600,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">600,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5619">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0160 - Single Horizon A </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 15,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 10cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">40 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 600,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5619" id="span-5619" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5619").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales even">
                        <td class="dtr-control">
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0023/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Pak Chandra</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081511319589</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Green cove BSD city Blok A5 no.17</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">25 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">2,284,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">2,284,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5624">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RED0019 - RED L </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 19,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">PSL</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 9 cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">36 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 684,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">BTL0027 - OBM STAR </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 160,000</span>
                                                            <span style="color: gray;">/METER</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">AYD</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 8 x 2 cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">10 METER</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 1,600,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5624" id="span-5624" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5624").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
                  <tr class="tb-sales odd">
                        <td class="dtr-control">
                              <div class="flex bg-light my-2">
                                    <span class="fw-bold">24 May 2021</span>
                              </div>
                              <div class="row datatable-header">
                                    <div class="col-md-6 col-sm-12 p-1 g-1 ">
                                          <div class="row align-items-center">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="https://breezeblock.co.id/asset/image/logo/logo-3-200.png" class="rounded" width="40">
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">ALY/XIII/03/SL-0018/05/V/2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">Pak Yudi</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">081317664678 / 082114038333</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">Perdatam 1 no.8 Ulujami Cipulir (Belakang Pasar Cipulir)</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1">
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">24 May 2021</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">RYAN FEBRIANSYAH</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">

                                                      <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Lunas</span><br>
                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah DP</span><br>
                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Sudah Lunas</span><br>
                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-dollar-sign fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-dollar-sign fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum Dijadwalkan</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Pengiriman</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Selesai</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>

                        <span class='fa-stack text-info tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-truck fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Tidak Ada Pengiriman</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                                                      </span>
                                                      <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="" data-bs-original-title="
                        <span class='fa-stack text-secondary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Belum PO</span><br>

                        <span class='fa-stack text-primary tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Proses Vendor</span><br>

                        <span class='fa-stack text-success tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Ready</span><br>

                        <span class='fa-stack text-danger tool-info'>
                              <i class='far fa-circle fa-stack-2x'></i>
                              <i class='fas fa-cubes fa-stack-1x'></i>
                        </span>
                        <span class='tool-desc'>Dibatalkan</span><br>">
                                                            <i class="far fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-cubes fa-stack-1x"></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 g-1">
                                          <div class="box-in-table p-1 ">
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">2,520,000</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">0</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                      </div>
                                                      <div class="col-auto px-0" style="min-width:30px;">
                                                            <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                      </div>
                                                      <div class="col text-end pe-3">
                                                            <span class="fw-bold text-dark" style="font-size:12px;">2,520,000</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-12 py-2">
                                          <div class="collapse " id="detail-5609">
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Item</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-4 col-12 ps-md-4">
                                                            <span class="fw-bold" style="font-size:0.7rem;">RSM0065 - Roster L </span><br>
                                                            <span class="fw-bold" style="color: gray;">Rp. 14,000</span>
                                                            <span style="color: gray;">/PCS</span><br>
                                                      </div>
                                                      <div class="col-md-5 col-8 px-md-2 mt-0 mt-md-1">
                                                            <div class="row g-1 mt-0 mt-md-1">
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Status</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">INDENT</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Vendor</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">WHO</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-6 mt-0 mt-md-1">
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0" style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Ukuran</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">20 x 20 x 9cm</span>
                                                                              </div>
                                                                        </div>
                                                                        <div class="row">
                                                                              <div class="col-auto pe-0 " style="min-width:70px;">
                                                                                    <span class="fw-bold text-secondary">Qty</span>
                                                                              </div>
                                                                              <div class="col pe-0">
                                                                                    <span class="text-dark fw-bold">180 PCS</span>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                                            <span style="color: gray;">Total Transaksi</span><br>
                                                            <span class="fw-bold text-orange">Rp. 2,520,000</span>
                                                            <br>
                                                      </div>
                                                </div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Detail Optional</span>
                                                <hr class="my-0 py-0">
                                                <div class="text-center">Tidak Ada Data</div>
                                                <br>
                                                <span class="fw-bolder" style="font-size:0.8rem">Pengiriman</span>
                                                <hr class="my-0 py-0">
                                                <div class="row py-1 g-2">
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Service</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">OMAHBATA </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Penerima</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-4">
                                                            <span style="color: gray;">Telp</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;">- </span>
                                                      </div>
                                                      <div class="col-md-2 col-12">
                                                            <span style="color: gray;">Alamat</span><br>
                                                            <span class="fw-bold" style="font-size:0.7rem;"> </span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="datatable-action">
                                          <div class="dropdown">
                                          </div>

                                          <div class="datatable-detail py-2 text-center ms-auto">
                                                <span class="fw-bolder" style="font-size:.78rem" data-bs-toggle="collapse" href="#detail-5609" id="span-5609" aria-expanded="false">Lihat Detail <i class="fas fa-angle-down"></i></span>
                                          </div>
                                    </div>
                                    <script>
                                          $("[data-bs-toggle='tooltip']").tooltip()
                                          $("#span-5609").click(function() {
                                                if ($(this).attr("aria-expanded") == "true") {
                                                      $(this).html("Sembunyikan <i class='fas fa-angle-up'></i>");
                                                } else {
                                                      $(this).html("Lihat Detail <i class='fas fa-angle-down'></i>");
                                                }
                                          });
                                    </script>
                              </div>
                        </td>
                  </tr>
            </tbody>
      </table>
</body>

</html>