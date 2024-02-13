<html>
        <head>
            <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
        </head>
        <style>
            body {
                text-align: center;
                padding: 40px 0;
                background: #6666FF;
            }
            h1 {
                color: #6666FF; /* Updated color */
                font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
                font-weight: 900;
                font-size: 40px;
                margin-bottom: 10px;
            }
            p {
                color: #6666FF; /* Updated color */
                font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
                font-size:20px;
                margin: 0;
            }
            i {
                color: #6666FF;
                font-size: 100px;
                line-height: 200px;
                margin-left:-15px;
            }
            .card {
                background: white;
                padding: 60px;
                border-radius: 4px;
                box-shadow: 0 2px 3px #C8D0D8;
                display: inline-block;
                margin: 0 auto;
                animation: fadeOut 5s ease-in-out;
            }
            .btn-custom {
                background-color: #6666FF; /* Updated color to #6666FF */
                color: white;
                border: none;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin-top: 20px;
                cursor: pointer;
                border-radius: 4px;
            }
            .btn-custom:hover {
                background-color: #5555CC; /* Darker color on hover */
            }
            @keyframes fadeOut {
                0% {opacity: 1;}
                100% {opacity: 0;}
            }
        </style>
        <body>
            <div class="card">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="checkmark">✓</i>
                </div>
                <h1>Success</h1> 
                <p>We received your data;<br/> thank you!</p>
                <button class="btn-custom" onclick="redirectToDashboard()">OK</button>
            </div>
            <script>
                function redirectToDashboard() {
                    window.location.href = "user_dashboard.php";
                }
            </script>
        </body>
    </html>