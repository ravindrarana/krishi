<?php include 'header.php'; ?>
    <div class="container mt-4 mb-">
          <article>
            <h1 data-bind="title">Loading...</h1>

            <small>
                By <span data-bind="author"></span> | 
                Updated at <span data-bind="updatedAt-formatted"></span> | 
                <span data-bind="views">0</span> Views
            </small>

            <hr>

            <div data-bind="content"></div>

            <hr>
            <div class="text-right">
                <button id="delete" class="btn btn-lg btn-danger">Delete</button> &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="" id="update" class="btn btn-lg btn-primary">Update</a>
            </div>

        </article>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script> -->

    <script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->

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

        /*********************************\
         * Fetch and display the entry *
        \*********************************/

        var entry_id = $_GET('id');

        if (entry_id) {
            var added_views = false;
            var Entry = firebase.database().ref('Entry').child(entry_id);

            Entry.on('value', function(r) {
                var entry = r.val();

                if (entry) {

                    entry['updatedAt-formatted'] = datetimeFormat(entry.updatedAt);

                    $('[data-bind]').each(function() {
                        $(this).html(entry[$(this).data('bind')]);
                    });

                    // update title
                    document.title = 'Firebase - ' + entry.title;

                    // increase views count. once.
                    if (!added_views) {
                        added_views = true;
                        Entry.child('views').transaction(function(views) {
                            return (views || 0) + 1;
                        });
                    }

                } else { // content not found
                    window.location.href = 'index.php';
                }
            });

            // update button
            $('#update').attr('href', 'update.php?id=' + entry_id);

            // delete button
            $('#delete').click(function() {
                if (confirm('This entry will be permanently delete. Are you sure?')) {
                    Entry.remove(); // this will trigger Entry.on('value') immediatly
                }
            });
        } else {
            alert('This entry id does not exist');
            window.location.href = 'index.php';
        }

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

        function pad2Digit(num) {
            return ('0' + num.toString()).slice(-2);
        }

        function datetimeFormat(timestamp) {
            var dateObj = new Date(timestamp);
            var en_month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return dateObj.getDate() + ' ' + en_month[dateObj.getMonth()] + ' ' + pad2Digit(dateObj.getFullYear()) + ' ' + pad2Digit(dateObj.getHours()) + ':' + pad2Digit(dateObj.getMinutes());
        }
    </script>


</body>

</html>