<x-layout>
    <section class="space-y-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="space-y-3">
                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-medium {{ $idea->status->badgeClasses() }}">
                    {{ $idea->status->label() }}
                </span>
                <h1 class="text-3xl font-semibold tracking-tight">{{ $idea->title }}</h1>
                <p class="text-sm text-muted-foreground">Created {{ $idea->created_at->diffForHumans() }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('ideas.edit', $idea) }}" class="btn">Edit</a>
                <form action="{{ route('ideas.destroy', $idea) }}" method="post" onsubmit="return confirm('Delete this idea?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outlined">Delete</button>
                </form>
            </div>
        </div>

        <article class="rounded-2xl border border-border bg-card p-6 sm:p-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-sm uppercase tracking-wider text-muted-foreground">Description</h2>
                    <p class="mt-3 whitespace-pre-line text-base leading-7 text-foreground/90">
                        {{ $idea->description ?: 'No description has been added for this idea yet.' }}
                    </p>
                </div>

                @if ($idea->image_path)
                    <div>
                        <h2 class="text-sm uppercase tracking-wider text-muted-foreground">Image</h2>
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                            class="mt-3 max-h-[24rem] w-full rounded-xl border border-border object-cover">
                    </div>
                @endif

                <div>
                    <h2 class="text-sm uppercase tracking-wider text-muted-foreground">Reference links</h2>

                    @if (count($idea->links ?? []) === 0)
                        <p class="mt-3 text-sm text-muted-foreground">No reference links added.</p>
                    @else
                        <ul class="mt-3 space-y-2">
                            @foreach ($idea->links as $link)
                                <li>
                                    <a href="{{ $link }}" target="_blank" rel="noreferrer noopener"
                                        class="text-sm text-sky-300 underline decoration-sky-300/50 underline-offset-2 hover:text-sky-200">
                                        {{ $link }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </article>

        <a href="{{ route('ideas.index') }}" class="btn btn-ghost">Back to ideas</a>
    </section>
</x-layout>
