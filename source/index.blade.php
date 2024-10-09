@extends('_layouts.main')

@push('head')
<link rel="prefetch" href="https://static.stevenmaguire.com/chart.svg" />
@endpush

@section('body')
<section class="intro chart">
    <div class="chart-content">
        <div class="container">
            <h1>I specialize in digital transformations & profitable turnarounds<span class="dot">.</span></h1>
            <div class="intro-content">
                <p>I'm a seasoned technology leader with over two decades of experience building software. For over ten years, I've been specializing in digital transformations and company turnarounds. My track record includes the profitable turnaround and acquisition of three companies. Two of those companies achieving a staggering <strong>1260%</strong> and <strong>780%</strong> increase in valuation.</p>
                <p><a href="/missions/" class="btn">View Track Record</a></p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <article>
            <h2>How did I get here?</h2>
            <p>
                <strong>It’s simple - I like to help.</strong>
                I help make product development better. I help find and build product teams. I add ideas to important discussions. I work on open source projects. I want to be there and support your cause.
                As it turns out, helping in those ways produces great results.
            </p>
            <p><a href="/about/" class="btn">The Story So Far</a></p>
        </article>
    </div>
</section>
<section class="accent">
    <div class="container">
        <article>
            <h2>You should see my hat rack.</h2>
            <div class="cards">
                <div class="card">
                    <i class="bx bx-code-alt bx-lg"></i>
                    <h3>Code Shipper</h3>
                    <p>I build projects that ship, regularly and often, throughout the stack.</p>
                    <p><a href="/open-source/">Open source work &raquo;</a></p>
                </div>
                <div class="card">
                    <i class="bx bx-book bx-lg"></i>
                    <h3>Author</h3>
                    <p>You can also find my ideas and experiences in video training and live talks.</p>
                    <p><a href="/publications/">Publications &raquo;</a></p>
                </div>
                <div class="card">
                    <i class="bx bx-donate-heart bx-lg"></i>
                    <h3>Volunteer</h3>
                    <p>I've also got the ability and desire to make the people around me better.</p>
                    <p><a href="/volunteering/">Volunteer experience &raquo;</a></p>
                </div>
                <div class="card">
                    <i class="bx bxs-magic-wand bx-lg"></i>
                    <h3>Carpenter</h3>
                    <p>Life for me began as a carpenter, building scenery for theatrical productions.</p>
                    <p><a href="/theatre/">Theatre experience &raquo;</a></p>
                </div>
            </div>
        </article>
    </div>
</section>
<section class="accent text-center">
    <div class="container">
        <article>
            <h2>I &hearts; open source!</h2>
            <p>I maintain <strong class="number">{{ $opensource->count() }}</strong> open source projects with over <strong class="number">{{ number_format(10000 * floor($page->opensource_total_downloads/10000)) }}</strong> downloads; I love giving back.</p>
            <p><a href="/open-source/" class="btn">See Open Source Work</a></p>
        </article>
    </div>
</section>
@endsection
