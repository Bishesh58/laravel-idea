<x-layout>
    <section class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight">My Ideas</h1>
                <p class="mt-1 text-sm text-muted-foreground">Track progress and focus on what matters next.</p>
            </div>
            <a href="{{ route('ideas.create') }}" class="btn">Create idea</a>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('ideas.index') }}"
                class="rounded-2xl border px-4 py-4 transition {{ $statusFilter === null ? 'border-primary bg-primary/15' : 'border-border bg-card hover:border-primary/40' }}">
                <p class="text-sm text-muted-foreground">All</p>
                <p class="mt-1 text-2xl font-semibold">{{ $totalIdeasCount }}</p>
            </a>

            @foreach ($statuses as $status)
                <a href="{{ route('ideas.index', ['status' => $status->value]) }}"
                    class="rounded-2xl border px-4 py-4 transition {{ $statusFilter === $status->value ? 'border-primary bg-primary/15' : 'border-border bg-card hover:border-primary/40' }}">
                    <p class="text-sm text-muted-foreground">{{ $status->label() }}</p>
                    <p class="mt-1 text-2xl font-semibold">{{ (int) ($statusCounts[$status->value] ?? 0) }}</p>
                </a>
            @endforeach
        </div>

        @if ($ideas->isEmpty())
            <div class="rounded-2xl border border-dashed border-border bg-card p-10 text-center">
                <h2 class="text-xl font-medium">No ideas found</h2>
                <p class="mt-2 text-sm text-muted-foreground">Start by adding your first idea or change the filter.</p>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($ideas as $idea)
                    <article class="group flex h-full flex-col rounded-2xl border border-border bg-card p-5 transition hover:-translate-y-0.5 hover:border-primary/40">
                        <div class="mb-4 flex items-start justify-between gap-3">
                            <h2 class="line-clamp-2 text-lg font-semibold">
                                <a href="{{ route('ideas.show', $idea) }}" class="hover:underline">{{ $idea->title }}</a>
                            </h2>
                            <span class="rounded-full border px-2.5 py-1 text-xs font-medium {{ $idea->status->badgeClasses() }}">
                                {{ $idea->status->label() }}
                            </span>
                        </div>

                        <p class="mb-4 line-clamp-4 text-sm text-muted-foreground">{{ $idea->description ?: 'No description added yet.' }}</p>

                        <div class="mb-5 text-xs text-muted-foreground">
                            {{ count($idea->links ?? []) }} reference {{ count($idea->links ?? []) === 1 ? 'link' : 'links' }}
                        </div>

                        <div class="mt-auto flex flex-wrap items-center gap-2">
                            <a href="{{ route('ideas.show', $idea) }}" class="btn btn-outlined">View</a>
                            <a href="{{ route('ideas.edit', $idea) }}" class="btn btn-ghost">Edit</a>
                            <form action="{{ route('ideas.destroy', $idea) }}" method="post" onsubmit="return confirm('Delete this idea?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost">Delete</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div>
                {{ $ideas->links() }}
            </div>
        @endif
    </section>
</x-layout>
