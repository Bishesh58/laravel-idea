<x-layout>
    <section class="mx-auto max-w-3xl rounded-2xl border border-border bg-card p-6 sm:p-8">
        <h1 class="text-2xl font-semibold">Edit Idea</h1>
        <p class="mt-1 text-sm text-muted-foreground">Update progress, details, and references as your idea evolves.</p>

        <form action="{{ route('ideas.update', $idea) }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <x-forms.field>
                <x-forms.label for="title">Title</x-forms.label>
                <x-forms.input id="title" name="title" type="text" value="{{ old('title', $idea->title) }}" required />
                <x-forms.error field="title" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="description">Description</x-forms.label>
                <x-forms.textarea id="description" name="description" value="{{ old('description', $idea->description) }}" />
                <x-forms.error field="description" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="status">Status</x-forms.label>
                <select id="status" name="status" class="input" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $idea->status->value) === $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                <x-forms.error field="status" />
            </x-forms.field>

            <div class="grid gap-4 sm:grid-cols-3">
                <x-forms.field>
                    <x-forms.label for="links_0">Reference link 1</x-forms.label>
                    <x-forms.input id="links_0" name="links[0]" type="url" value="{{ old('links.0', $idea->links[0] ?? '') }}" />
                    <x-forms.error field="links.0" />
                </x-forms.field>
                <x-forms.field>
                    <x-forms.label for="links_1">Reference link 2</x-forms.label>
                    <x-forms.input id="links_1" name="links[1]" type="url" value="{{ old('links.1', $idea->links[1] ?? '') }}" />
                    <x-forms.error field="links.1" />
                </x-forms.field>
                <x-forms.field>
                    <x-forms.label for="links_2">Reference link 3</x-forms.label>
                    <x-forms.input id="links_2" name="links[2]" type="url" value="{{ old('links.2', $idea->links[2] ?? '') }}" />
                    <x-forms.error field="links.2" />
                </x-forms.field>
            </div>

            <x-forms.field>
                <x-forms.label for="image">Replace image (optional)</x-forms.label>
                <x-forms.input id="image" name="image" type="file" accept="image/*" />
                <x-forms.error field="image" />
            </x-forms.field>

            @if ($idea->image_path)
                <div class="space-y-3">
                    <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                        class="h-44 w-full rounded-xl border border-border object-cover sm:w-80">
                    <label for="remove_image" class="inline-flex items-center gap-2 text-sm text-muted-foreground">
                        <input id="remove_image" name="remove_image" type="checkbox" value="1" @checked(old('remove_image'))>
                        <span>Remove current image</span>
                    </label>
                </div>
            @endif

            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit" class="btn">Save Changes</button>
                <a href="{{ route('ideas.show', $idea) }}" class="btn btn-outlined">Cancel</a>
            </div>
        </form>
    </section>
</x-layout>
