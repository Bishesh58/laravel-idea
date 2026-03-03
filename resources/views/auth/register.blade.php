<x-layout>
    <div class="mx-auto mt-10 w-full max-w-md rounded-2xl border border-border bg-card p-6 shadow-sm">
        <h1 class="mb-1 text-2xl font-semibold">Create your account</h1>
        <p class="mb-6 text-sm text-muted-foreground">Fill in your details to register.</p>

        <form action="/register" method="post" class="space-y-4">
            @csrf

            <x-forms.field>
                <x-forms.label for="name">Name</x-forms.label>
                <x-forms.input
                    id="name"
                    name="name"
                    type="text"
                    placeholder="Enter your full name"
                    required
                    autocomplete="name"
                />
                <x-forms.error field="name" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="email">Email</x-forms.label>
                <x-forms.input
                    id="email"
                    name="email"
                    type="email"
                    placeholder="Enter your email address"
                    required
                    autocomplete="email"
                />
                <x-forms.error field="email" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="password">Password</x-forms.label>
                <x-forms.input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Create a password"
                    required
                    autocomplete="new-password"
                />
                <x-forms.error field="password" />
            </x-forms.field>

            <x-forms.field>
                <x-forms.label for="password_confirmation">Confirm Password</x-forms.label>
                <x-forms.input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="Re-enter your password"
                    required
                    autocomplete="new-password"
                />
                <x-forms.error field="password_confirmation" />
            </x-forms.field>

            <button type="submit" class="btn h-10 w-full text-center leading-10">Register</button>
        </form>
    </div>
</x-layout>
