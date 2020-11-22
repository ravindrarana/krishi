<?php include 'header.php'; ?>

        <div class="m-4 border-bottom">
            <button id="logout" class="btn btn-lg btn-warning float-right">Logout</button>    
            <h1>Dashboard</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form id="new_entry">
            <h2>Title</h2>
            <br>
            <input type="text" name="title" class="form-control col-md-12" required>

            <br>
            <br>

            <h2>Content</h2>
            <br>
            <textarea name="content" id="content"></textarea>

            <br>
            <br>

            <div class="text-right">
                <button class="btn btn-large btn-primary">Create new entry</button>
            </div>
        </form>
                </div>
            </div>
        </div>
        <!-- <pre id="profile"></pre> -->

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>

    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script> -->

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

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

        /////////////////////////////////////


        /**********************\
         * Check login status *
        \**********************/

        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {

                console.log(user);
                // document.getElementById('profile').innerHTML = JSON.stringify(user, null, 2);
                document.getElementById('logout').onclick = function() {
                    if (confirm('Logout?')) {
                        firebase.auth().signOut(); // This will trigger onAuthStateChanged again, immediately.
                    }
                };
                // Add notice code
                   // init CKEditor
                CKEDITOR.replace('content');

                /***************************************************\
                 * Process form data and save to Firebase database *
                \***************************************************/

                $('#new_entry').submit(function(e) {
                    e.preventDefault();

                    var entry = {};
                    entry.title = $(this).find('[name="title"]').val();
                    entry.content = CKEDITOR.instances['content'].getData();
                    entry.createdAt = new Date().getTime();
                    entry.updatedAt = entry.createdAt;
                    entry.views = 0;
                    entry.author = user.email;

                    var Entry = firebase.database().ref('Entry');

                    Entry.push(entry).then(function(data) {
                        window.location.href = 'entry.php?id=' + data.getKey()
                    }).catch(function(error) {
                        alert(error);
                        console.error(error);
                    })

                    return false;
                });
                // End Notice
            } else {
                // if not logged in yet
                alert('Please login first')
                window.location.href = 'index.php';

            }
        });
    </script>


</body>

</html>