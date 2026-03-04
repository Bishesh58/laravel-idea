<nav class="border-b border-border/80 bg-card/70 px-6 backdrop-blur-sm">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between">
        <a href="{{ auth()->check() ? route('ideas.index') : '/' }}" class="text-lg font-semibold tracking-tight">Idea Forge</a>

        <div class="flex items-center gap-3 text-sm">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outlined">Login</a>
                <a href="{{ route('register') }}" class="btn">Register</a>
            @endguest

            @auth
                <a href="{{ route('ideas.index') }}" class="btn btn-outlined">My Ideas</a>
                <a href="{{ route('ideas.create') }}" class="btn">New Idea</a>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
