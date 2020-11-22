<?php include 'header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="update_entry">
            <div class="mt-4">
                <h2>Title</h2>
                <input type="text" name="title" class="form-control col-md-12" required>

                <h2>Content</h2>
                <textarea name="content" id="content"></textarea>
            </div>
            <div class="text-right mt-2">
                <button class="btn btn-large btn-primary">Update</button>
            </div>
        </form>
        </div>
    </div>
</div>
        

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>

    <script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
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

        /////////////////////////////////////


        /**********************\
         * check login status *
        \**********************/

        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {

                /*********************************\
                 * Fetch the entry from Firebase *
                \*********************************/
                var entry_id = $_GET('id');

                if (entry_id) {

                    var Entry = firebase.database().ref('Entry').child(entry_id);

                    Entry.once('value', function(r) { // once = just this once, no need to actively watch the changes
                        var entry = r.val();

                        $('#update_entry [name="title"]').val(entry.title);
                        $('#update_entry [name="content"]').val(entry.content);

                        CKEDITOR.replace('content');
                    });


                    /**********************\
                     * Save the form data *
                    \**********************/
                    $('#update_entry').submit(function(e) {
                        e.preventDefault();

                        Entry.transaction(function(entry) {

                            entry = entry || {};
                            entry.title = $('#update_entry [name="title"]').val();
                            entry.content = CKEDITOR.instances['content'].getData();
                            entry.updatedAt = new Date().getTime();
                            entry.author = user.email;

                            return entry;

                        }).then(function() {
                            window.location.href = 'entry.php?id=' + entry_id;
                        }).catch(function(error) {
                            alert(error);
                        });

                        return false;
                    });

                } else {
                    window.location.href = 'create.php';
                }


            } else {
                // if not logged in
                alert('Please log-in')
                window.location.href = 'login.php';

            }
        });


        /*************\
         * Utilities *
        \*************/

        function $_GET(key) {
            var queries = window.location.href.split('?').pop().split('&');
            var params = {};
            queries.map(function(query) {
                var set = query.split('=');
                params[set[0]] = set[1];
            });

            if (key) {
                return params[key] || null;
            } else {
                return params;
            }

        }
    </script>


</body>

</html>