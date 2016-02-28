<header id="header">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home.index') }}">Schiedam map</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li @if($routeName == "home") class="active" @endif><a href="{{ route('home.index') }}">Home</a></li>
                    <li @if($routeName == "neighborhoods") class="active" @endif><a href="{{ route('neighborhoods.index') }}">Neighborhoods</a></li>
                    <li @if($routeName == "complains") class="active" @endif><a href="{{ route('complains.index') }}">Complains</a></li>
                    <li @if($routeName == "choropleth") class="active" @endif><a href="{{ route('choropleth.index') }}">Choropleth</a></li>
                    <li @if($routeName == "heatmap") class="active" @endif><a href="{{ route('heatmap.index') }}">Heatmap</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>
<div id="header-push"></div>
    