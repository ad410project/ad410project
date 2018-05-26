<div id="main_container" <div class="jumbotron jumbotron-fluid">
    <div id="body" class="container">
        <p>Stuff about how great the application is.</p>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol>

            <!-- The slideshow -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./views/images/kids_swing.png" alt="Los Angeles">
                    <div class="carousel-caption">
                        <h3>Los Angeles</h3>
                        <p>We had such a great time in LA!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./views/images/kids_kites.png" alt="Chicago">
                    <div class="carousel-caption">
                        <h3>Chicago</h3>
                        <p>We had such great pizza in CHI!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./views/images/kids_playing.png" alt="New York">
                    <div class="carousel-caption">
                        <h3>New York</h3>
                        <p>It is too crowded!</p>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#myCarousel" role=button data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role=button data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    <a href="?controller=static&action=searchEvents" id="searchEvents">Search Events</a>
</div>