<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ $page->getUrl() }}">
    <title>{{ $title ?? $page->title ?? '' }}</title>
    <meta name="description" content="{{ $page->description }}"/>
    <meta name="author" content="Steven Maguire">
    <meta property="og:title" content="{{ $page->title }}"/>
    <meta property="og:description" content="{{ $page->description }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <link rel="icon" href="https://static.stevenmaguire.com/favicon.ico">
    <link rel="shortcut icon" href="https://static.stevenmaguire.com/favicon.ico">
    <link rel="stylesheet" href="{{ mix('css/style.css', 'assets/build') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    @stack('head')
</head>
<body class="frame">
    <div id="menu-main-mobile" class="menu-main-mobile">
        <ul class="menu">
            <li class="menu-item"><a href="/" aria-label="Return Home">Home</a></li>
            <li class="menu-item"><a href="/about/" aria-label="About">About</a></li>
            <li class="menu-item"><a href="/missions/" aria-label="Track Record">Track Record</a></li>
            <li class="menu-item"><a href="/publications/" aria-label="Thoughts & Ideas">Thoughts & Ideas</a></li>
        </ul>
    </div>
    <header>
        <div class="container navigation">
            <div class="author">
                <a href="/"><img width="50" class="author-image" src="https://static.stevenmaguire.com/avatar.png" alt="Steven Maguire" /></a>
                <div class="author-text">
                    <span class="author-name">Hi! I'm Steven.</span>
                    <span class="author-title">Hands-on CTO, Team Builder, Software Architect, and Product Designer.</span>
                </div>
            </div>
            <div class="menu-main">
                <ul>
                    <li @class(['menu-item', 'active' => $page->isPath('/about/')])><a href="/about/" aria-label="About"><span>About</span></a></li>
                    <li @class(['menu-item', 'active' => $page->isPath('/missions/')])><a href="/missions/" aria-label="Track Record"><span>Track Record</span></a></li>
                    <li @class(['menu-item', 'active' => $page->isPath('/publications/')])><a href="/publications/" aria-label="Thoughts & Ideas"><span>Thoughts & Ideas</span></a></li>
                    <li class="menu-item logo"><a href="/" aria-label="Return Home"><figure><span>Steven Maguire</span></figure></a></li>
                </ul>
            </div>
            <div id="toggle-menu-main-mobile" class="hamburger-trigger">
                <button class="hamburger">Menu</button>
            </div>
        </div>
    </header>
    @yield('body')
    <section id="contact">
        <div class="container">
            <hr />
            <h2>Let's Get In Touch!</h2>
            <p>Want to talk shop? Have a food, film, or music recommendation?</p>
            <div class="footer-social">
                <span class="social-icon"><a href="&#109;&#097;&#105;&#108;&#116;&#111;:{{ $page->email }}" title="Steven Maguire on Email" target="_blank" rel="noopener"><i class="bx bx-envelope bx-lg"></i></a></span>
                <span class="social-icon"><a href="https://github.com/stevenmaguire" title="Steven Maguire on Github" target="_blank" rel="noopener"><i class="bx bxl-github bx-lg"></i></a></span>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p class="legal">
                &copy; 2006-{{ $page->build_time->format('Y') }} Steven Maguire
                &bull; Last generated {{ $page->build_time }}
                <br />
                <a href="/colophon/">colophon</a>
                &bull; <a href="/open-source/">open source</a>
                &bull; <a href="/privacy/">privacy</a>
                &bull; <a href="/terms/">terms of use</a>
                &bull; <a href="https://steven.pizza">buy me a pizza</a>
                &bull; <a href="https://footballcroptop.com">buy a football crop top</a>
                <br />
                Human Factors International Certified Usability Analyst # 2010-2533
            </p>
        </div>
    </footer>
    <script defer src="{{ mix('js/scripts.js', 'assets/build') }}"></script>
</body>
</html>
