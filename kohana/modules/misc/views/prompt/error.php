<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>sphinx-admin</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/resource/css/bootstrap.css" />

    <script type="text/javascript" src="/resource/js/plugins/jquery/jquery.js"></script>
</head>
<body>

<br/><br/><br/><br/><br/>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body center">
                    <h3 align="center">error：<?php echo $message; ?></h3>
                    <hr/>
                    <div align="center">
                        <a class="btn btn-danger btn-big" href="#"> 返回>> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    var isInFancybox = self != top;
    if(isInFancybox) {
        $("a").click( function () { parent.$.fancybox.close(); });
        setTimeout(function(){parent.$.fancybox.close();}, 3000);
    } else {
        <?php if($redirect !== NULL) {?>
        $('a').attr('href','<?php echo URL::site($redirect); ?>');
        setTimeout('(function(uri) {location.href = uri;})("<?php echo URL::site($redirect); ?>")', <?php echo isset($delay) ? ($delay * 1000) : 3000; ?>);
        <?php } else {?>
        $('a').attr('href','/');
        setTimeout('(function(uri) {location.href = uri;})("/")', <?php echo isset($delay) ? ($delay * 1000) : 3000; ?>);
        <?php }?>
    }
</script>