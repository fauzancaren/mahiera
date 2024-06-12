<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url("asset/image/mgs-erp/logo.png") ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/721c0283d3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Home Page <?= $_qrcode->QrCodeName ?></title>
</head>

<body class="md:bg-[url('<?= base_url("asset/image/qrcode/") . $_qrcode->QrCodeImage ?>.png')] bg-no-repeat bg-cover backdrop-blur-[20px] md:bg-center">
    <div class="grid grid-flow-row sm:mx-[5%] sm:my-[10%] md:mx-[13%] md:my-[7%] lg:mx-[20%] xl:mx-[28%] xl:my-[4%] sm:shadow-lg sm:shadow-slate-400 bg-white">
        <div class="grid bg-slate-500 h-[350px] overflow-hidden">
            <img class=" grid w-full h-[350px]" src="<?= base_url("asset/image/qrcode/") . $_qrcode->QrCodeImage ?>.png" alt="">
        </div>

        <div class="grid grid-row-2 sm:px-16 bg-[<?= $_qrcode->QrCodeHeadColor ?>] text-slate-200 h-[170px] place-content-center">
            <h3 class="px-9 py-2 text-2xl font-semibold"><?= $_qrcode->QrCodeHeadLine ?></h3>
            <small class="px-9 text-lg text-gray-300"><?= $_qrcode->QrCodeAboutUs ?></small>
        </div>

        <div class="grid grid-flow-row p-4">
            <?php
            foreach ($_sosialmedia as $row) {
                echo '
                <div data-url="' . $row->QrSosialMediaUrl . '" data-type="' . $row->MsSosialMediaName . '" class="cursor-pointer" onclick="direct(this)">
                    <div class="flex border-b-2 gap-x-4  py-2 sm:px-8 px-0">
                        <div class="flex-none w-4 sm:w-1"></div> 
                        <div class="grow content-center"> 
                            <div class="grid grid-cols-6 gap-4 py-2">
                                <div class="col-span-1 justify-self-center place-self-center fa-2x">' . $row->MsSosialMediaIcon . '</div>
                                <div class="col-span-5 justify-self-start">
                                    <h4 class="font-semibold text-lg">' . $row->MsSosialMediaName . '</h4>
                                    <small>' . $row->QrSosialMediaText . '</small>
                                </div>
                            </div>  
                        </div> 
                        <div class="flex-none w-4 sm:w-1"> </div> 
                    </div> 
                </div>';
            }
            ?>
        </div>

        <div class="hidden sm:grid sm:place-content-stretch sm:px-24 sm:p-6">
        </div>
    </div>

    <script>
        direct = function(elm) {
            switch ($(elm).data("type")) {
                case "Instagram":
                    window.open("https://www.instagram.com/" + $(elm).data("url"), '_blank');
                    break;
                case "Whatsapp":
                    window.open("https://wa.me/" + $(elm).data("url"), '_blank');
                    break;
                case "Twitter":
                    window.open("https://twitter.com/" + $(elm).data("url"), '_blank');
                    break;
                default:
                    window.open($(elm).data("url"), '_blank');
                    break;
            }
        }

        function generateUUID() { // Public Domain/MIT
            var d = new Date().getTime(); //Timestamp
            var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now() * 1000)) || 0; //Time in microseconds since page-load or 0 if unsupported
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16; //random number between 0 and 16
                if (d > 0) { //Use timestamp until depleted
                    r = (d + r) % 16 | 0;
                    d = Math.floor(d / 16);
                } else { //Use microseconds since page-load if supported
                    r = (d2 + r) % 16 | 0;
                    d2 = Math.floor(d2 / 16);
                }
                return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
        }

        function setCookie(cname, cvalue) {
            const d = new Date();
            var exdate = new Date().getTime() + (1000 * 60 * 60 * 24 * 7 * 52);
            var date_cookie = new Date(exdate).toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + date_cookie + ";path=/";
        }

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function getUUID() {
            let user = getCookie("uuid-device");
            if (user != "") {} else {
                user = generateUUID();
                if (user != "" && user != null) {
                    setCookie("uuid-device", user);
                }

            }
            return user;

            // let user = getCookie("username");
            // if (user != "") {
            //    alert("Welcome again " + user);
            // } else {
            //    user = prompt("Please enter your name:", "");
            //    if (user != "" && user != null) {
            //       setCookie("username", user, 30);
            //    }
            // }


        }

        function getOS() {
            var uA = navigator.userAgent || navigator.vendor || window.opera;
            if ((/iPad|iPhone|iPod/.test(uA) && !window.MSStream) || (uA.includes('Mac') && 'ontouchend' in document)) return 'iOS';

            var i, os = ['Windows', 'Android', 'Unix', 'Mac', 'Linux', 'BlackBerry'];
            for (i = 0; i < os.length; i++)
                if (new RegExp(os[i], 'i').test(uA)) return os[i];
        }

        $.get("http://ipinfo.io?token=70f0e4f1fb19f4", function(response) {
            var data_scan = {
                "QrScanCity": response.city,
                "QrScanCountry": response.country,
                "QrScanOS": getOS(),
                "QrScanUUID": getUUID(),
                "QrScanRef": <?= $_qrcode->QrCodeId ?>,
            }
            console.log(data_scan);
            $.post("<?= site_url("function/client_data_tools/qr_scan") ?>", data_scan);
        }, "jsonp");
    </script>
</body>

</html>