<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Firebase - Create</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">
        <br>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Firebase</a>
                </div>
                <div class="collapse navbar-collapse" id="nav">
                    <ul class="nav navbar-nav">
                        <li><a href="login.html">Member</a></li>
                        <li class="active"><a href="create.html">New Entry</a></li>
                    </ul>
                </div>
            </div>
        </nav>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <!-- <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script> -->


    <script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>

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
         * login status check *
        \**********************/

        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {

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
                        window.location.href = 'entry.html?id=' + data.getKey()
                    }).catch(function(error) {
                        alert(error);
                        console.error(error);
                    })

                    return false;
                });


            } else {
                // if not logged in
                alert('Please login first')
                window.location.href = 'login.html';

            }
        });
    </script>


</body>

</html>