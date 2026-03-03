<x-layout>
    <div class="mx-auto mt-10 w-full max-w-md rounded-2xl border border-border bg-card p-6 shadow-sm">
        <h1 class="mb-1 text-2xl font-semibold">Welcome back</h1>
        <p class="mb-6 text-sm text-muted-foreground">Sign in to continue to your account.</p>

        <form action="/login" method="post" class="space-y-4">
            @csrf

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
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                />
                <x-forms.error field="password" />
            </x-forms.field>

            <x-forms.field class="space-y-0">
                <label for="remember" class="inline-flex items-center gap-2 text-sm text-muted-foreground">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        value="1"
                        @checked(old('remember'))
                    >
                    <span>Remember me</span>
                </label>
                <x-forms.error field="remember" />
            </x-forms.field>

            <button type="submit" class="btn h-10 w-full text-center leading-10">Login</button>
        </form>
    </div>
</x-layout>
