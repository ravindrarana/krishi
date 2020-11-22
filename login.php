<?php include 'header.php'; ?>

        <h1>Firebase - Login</h1>

        <div id="firebaseui-auth-container"></div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script> -->

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-analytics.js"></script> -->

    <!-- member plugins -->
    <script src="https://www.gstatic.com/firebasejs/ui/live/0.4/firebase-ui-auth.js"></script>
    <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/live/0.4/firebase-ui-auth.css" />
    <!-- End - member plugins -->



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


        /**********************\
         * Check login status *
        \**********************/

        firebase.auth().onAuthStateChanged(function(user) {
            if (user) { // if already logged in
                window.location.href = 'profile.php';
            }
        });

        /*******************\
         * init Login UI *
        \*******************/

        // FirebaseUI config.
        var uiConfig = {
            'signInSuccessUrl': false,
            'signInOptions': [
                // comment unused sign-in method
                firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                firebase.auth.FacebookAuthProvider.PROVIDER_ID,
                //firebase.auth.TwitterAuthProvider.PROVIDER_ID,
                //firebase.auth.GithubAuthProvider.PROVIDER_ID,
                firebase.auth.EmailAuthProvider.PROVIDER_ID
            ],
            // Terms of service url.
            'tosUrl': false,
        };

        // Initialize the FirebaseUI Widget using Firebase.
        var ui = new firebaseui.auth.AuthUI(firebase.auth());
        // The start method will wait until the DOM is loaded.
        ui.start('#firebaseui-auth-container', uiConfig);

        ////////////////////////////////////////
    </script>


</body>

</html>