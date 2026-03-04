<x-layout>
    <section class="relative overflow-hidden rounded-3xl border border-border bg-card px-8 py-16 sm:px-12">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.16),transparent_55%),radial-gradient(circle_at_bottom_left,rgba(16,185,129,0.12),transparent_50%)]"></div>

        <div class="relative max-w-2xl space-y-6">
            <p class="inline-flex rounded-full border border-border bg-background/70 px-3 py-1 text-xs uppercase tracking-[0.2em] text-muted-foreground">
                Productive by design
            </p>
            <h1 class="text-4xl font-semibold leading-tight sm:text-5xl">
                Plan, track, and ship your best ideas.
            </h1>
            <p class="text-base text-muted-foreground sm:text-lg">
                Idea Forge keeps every concept in one place with clear status tracking, structured notes, and fast editing.
            </p>
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="{{ route('register') }}" class="btn">Create account</a>
                <a href="{{ route('login') }}" class="btn btn-outlined">Login</a>
            </div>
        </div>
    </section>
</x-layout>
