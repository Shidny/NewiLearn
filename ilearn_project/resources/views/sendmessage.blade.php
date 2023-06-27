<html>

<body style="color: #333;font-family: " Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857;background-color: #D6D6D5;">
    <div style="width:600px;margin:0 auto;background:#fff;">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                </div>
            </div>
        </div>
    </div>
    <div style="padding:30px 20px 50px;">

        Dear  {{ $data['full_name'] }},<br/><br/>

You have been granted access to RFC's iLearn Portal. This system houses the online version of the Company's policies and practices.<br/><br/>

To view, click this link https://policy.rfc.com.ph, and enter your default credentials as follows:<br/><br/>

Username: {{ $data['username'] }}<br/>
Password: {{ $data['password'] }}<br/><br/>


Cheers and keep learning!<br/><br/>

QMD
    </div>
    <footer style="background:rgb(30,30,30);padding:20px;color:#fff;text-align:center;">
        <p class="copyright">Copyright &copy; <a href="https://rfc.com.ph" style="color:rgb(254, 209, 54);text-decoration:none;">
                Radiowealth Finance Company</a></p>
    </footer>
    </div>
</body>

</html>