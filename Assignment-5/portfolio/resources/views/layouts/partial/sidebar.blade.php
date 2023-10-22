<aside id="colorlib-aside" role="complementary" class="js-fullheight">
    <nav id="colorlib-main-menu" role="navigation">
        <ul>
            <li class="{{ request()->is('/') ? 'colorlib-active' : '' }}">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="{{ request()->is('experience*') ? 'colorlib-active' : '' }}">
                <a href="{{ route('experience') }}">Experience</a>
            </li>
            <li class="{{ request()->is('project*') ? 'colorlib-active' : '' }}">
                <a href="{{ route('project') }}">Project</a>
            </li>
        </ul>
    </nav>
</aside>
