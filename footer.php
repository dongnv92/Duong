<?php require_once 'src/core.php';?>
    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2019 <a class="text-bold-800 grey darken-2" href="#">DƯƠNG TRANG </a>, All rights reserved. </span>
    </p>
</footer>
<?php foreach ($js_plus AS $js){?>
<script src="<?php echo $js;?>" type="text/javascript"></script>
<?php } ?>
<!-- BEGIN MODERN JS-->
<script src="assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="assets/js/core/app.js" type="text/javascript"></script>
<!-- END MODERN JS-->
</body>
</html>