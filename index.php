<?php include  'header.php'; ?>

<!-- Main Page -->
<div class="container-fluid" style="background-color: #2f6d3de8;">
    <div class="row">
        <div class="col-md-6 p-4">
            <img src="https://krishialert.herokuapp.com/img/mobile.png" alt="" height="350px" width="350px">
            <h3 class="text-white">Download Krishi Suchana App</h3>
        </div>
        <div class="col-md-6 p-4">
            <div class="intro text-white">
                <h3>About Project & Our Team</h3>
                <div class="border p-2 mt-4">
                    <p>Krishi Alert System : get notify about Agro Crises and disease. We deliver notices and alert according to your interest, it may be Poultry Farm, Cow Farm or Any Farming Business.</p>
                </div>
                <div class="border p-2 mt-4">
                    <p>We are student of NAST and developing notice alert system on agro. We have Team of Aishwarya, Amrita, Dipa and Nidhi</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Page -->

<!-- Farm -->
    <div class="container-fluid">
        <div class="row p-4">
        <!-- Organic Agriculture -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 text-center p-4" style="background-color: #397a4ee0;">
                    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                    <i class="fas fa-seedling fa-4x" style="color: #8bc34a;"></i>
                    <div class="card-body text-white">
                        <h4 class="card-title">Organic Agriculture</h4>
                    </div>
                </div>
            </div>
        <!-- End Organic Agriculture -->

        <!-- Poultry Information -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 text-center p-4" style="background-color: #397a4ee0;">
                    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                    <i class="fab fa-the-red-yeti fa-4x" style="color: #8bc34a;"></i>
                    <div class="card-body text-white">
                        <h4 class="card-title">Poultry Information</h4>
                    </div>
                </div>
            </div>
        <!-- End Poultry Information -->
        <!-- Pig Farm Information -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 text-center p-4" style="background-color: #397a4ee0;">
                    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                    <i class="fas fa-piggy-bank fa-4x" style="color: #8bc34a;"></i>
                    <div class="card-body text-white">
                        <h4 class="card-title">Pig Farm </h4>
                    </div>
                </div>
            </div>
        <!-- End Pig Farm Information -->

        <!-- Smart Irrigation -->
            <div class="col-md-3 mb-4">
                <a href="https://engineerjagat.com" class="text-decoration-none">
                    <div class="card border-0 text-center p-4" style="background-color: #397a4ee0;">
                        <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                        <i class="fas fa-shower fa-4x" style="color: #8bc34a;"></i>
                        <div class="card-body text-white">
                            <h4 class="card-title">Smart Irrigation</h4>
                        </div>
                    </div>
                </a>
            </div>
        <!-- End Smart Irrigation -->

        </div>
    </div>
<!-- End Farm -->
<!-- All Notices -->
 <div class="container-fluid">
        <h2 class="p-4 border-bottom text-success" id="noti">All Notices</h2>
        <div id="entries" class="row p-4"></div>
 </div>
<!-- End All Notices -->

<!-- test -->

<!-- end test -->
<!-- Code for Display  -->
<script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script> -->

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-analytics.js"></script> -->

    <script>
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        var firebaseConfig = {
            apiKey: "AIzaSyAarIDkZeLWPJlwg2jxG2cCaxhoCVe2n3U",
            authDomain: "krishi-68160.firebaseapp.com",
            databaseURL: "https://krishi-68160.firebaseio.com",
            projectId: "krishi-68160",
            storageBucket: "krishi-68160.appspot.com",
            messagingSenderId: "310774367517",
            appId: "1:310774367517:web:7b059079f2e8fc007b4df4",
            measurementId: "G-M140TR6XM0"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        // firebase.analytics();

        /////////////////////////////////////

        var Blog = firebase.database().ref('Entry').orderByChild('updatedAt');

        Blog.on('value', function(r) {

            $('#entries').html('Loading...');
            var html = '';
            r.forEach(function(item) {
                entry = item.val()
                html = '<div class="col-md-12 mb-4">' +
                    '<a href="entry.php?id=' + item.getKey() + '" style="text-decoration:none!important;">' +
                    '<div class="card card-color text-white p-2">' +
                    '<div class="card-header">' +
                    '<h3 class="card-title">' + excerpt(entry.title, 140) + '</h3>' +
                    '</div>' +
                    '<div class="card-body">' +
                    // '<small>By ' + entry.author + ' | ' + datetimeFormat(entry.updatedAt) + ' | ' + entry.views + ' views</small>' +
                    '<p class="card-text">' + excerpt(entry.content, 250) + '</p>' +
                    '</div>' +
                    '</div>' +
                    '</a>' +
                    '</div>' + html; // prepend the entry because we need to display it in reverse order
            });

            $('#entries').html(html);
        });

        /*************\
         * Utilities *
        \*************/

        function strip(html) {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        function excerpt(text, length) {
            text = strip(text);
            text = $.trim(text); //trim whitespace
            if (text.length > length) {
                text = text.substring(0, length - 3) + '...';
            }
            return text;
        }

        function pad2Digit(num) {
            return ('0' + num.toString()).slice(-2);
        }

        // function datetimeFormat(timestamp) {
        //     var dateObj = new Date(timestamp);
        //     var en_month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        //     return dateObj.getDate() + ' ' + en_month[dateObj.getMonth()] + ' ' + pad2Digit(dateObj.getFullYear()) + ' ' + pad2Digit(dateObj.getHours()) + ':' + pad2Digit(dateObj.getMinutes());
        // }
    </script>


</body>

</html>

<?php include "footer.php" ?>