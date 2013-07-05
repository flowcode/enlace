<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" type="image/png" href="/images/comic_horse.gif" />
        <title>Demo | Wing Framework</title>
        <meta name="description" content="Demo page for Wing" />
        <link rel="stylesheet" href="/css/demo.css" type="text/css" media="screen" />
    </head>

    <body>
        <!--  header -->
        <div id="header">
            <div class="container">
                <div id="siteTitle">
                    <span>Error - Demo</span>
                </div>
                <div id="main-menu">
                    <ul>
                        <li><a href="/" id="home">Home</a></li>
                        <li><a href="/demo" id="home">Demos</a></li>
                        <li><a href="/demo/message" id="home">Message</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content  -->
        <div id="content">
            <?php echo $content ?>
        </div>

        <!-- footer  -->
        <div id="footer" class="footer">
            <div class="container">
                <p>Copyright info. Other stuff.</p>
            </div>
        </div>
    </body>
</html>