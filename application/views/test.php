<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>
</head>

<body>
   <div id="demo"></div>
   <script>
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
         var x = document.getElementById("demo");
         x.innerHTML += "city : " + response.city + "<br>";
         x.innerHTML += "country: " + response.country + "<br>";
         x.innerHTML += "OS: " + getOS() + "<br>";
         x.innerHTML += "UUID: " + getUUID() + "<br>";
      }, "jsonp");
   </script>
</body>

</html>