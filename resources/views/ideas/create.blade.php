<x-layout>
    <section class="mx-auto max-w-3xl rounded-2xl border border-border bg-card p-6 sm:p-8">
        <h1 class="text-2xl font-semibold">Create Idea</h1>
        <p class="mt-1 text-sm text-muted-foreground">Capture what you want to build and track it with a status.</p>

        <form action="{{ route('ideas.store') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf

            <x-forms.field>
                <x-forms.label for="title">Title</x-forms.label>
                <x-forms.input id="title" name="title" type="text" placeholder="e.g. Add export to CSV" required />
                <x-forms.error field="title" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="description">Description</x-forms.label>
                <x-forms.textarea id="description" name="description" placeholder="Describe the idea and expected outcome." />
                <x-forms.error field="description" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="status">Status</x-forms.label>
                <select id="status" name="status" class="input" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(old('status', \App\IdeaStatus::Pending->value) === $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                <x-forms.error field="status" />
            </x-forms.field>

            <div class="grid gap-4 sm:grid-cols-3">
                <x-forms.field>
                    <x-forms.label for="links_0">Reference link 1</x-forms.label>
                    <x-forms.input id="links_0" name="links[0]" type="url" placeholder="https://example.com" value="{{ old('links.0') }}" />
                    <x-forms.error field="links.0" />
                </x-forms.field>
                <x-forms.field>
                    <x-forms.label for="links_1">Reference link 2</x-forms.label>
                    <x-forms.input id="links_1" name="links[1]" type="url" placeholder="https://example.com" value="{{ old('links.1') }}" />
                    <x-forms.error field="links.1" />
                </x-forms.field>
                <x-forms.field>
                    <x-forms.label for="links_2">Reference link 3</x-forms.label>
                    <x-forms.input id="links_2" name="links[2]" type="url" placeholder="https://example.com" value="{{ old('links.2') }}" />
                    <x-forms.error field="links.2" />
                </x-forms.field>
            </div>

            <x-forms.field>
                <x-forms.label for="image">Idea image (optional)</x-forms.label>
                <x-forms.input id="image" name="image" type="file" accept="image/*" />
                <x-forms.error field="image" />
            </x-forms.field>

            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit" class="btn">Create Idea</button>
                <a href="{{ route('ideas.index') }}" class="btn btn-outlined">Cancel</a>
            </div>
        </form>
    </section>
</x-layout>
