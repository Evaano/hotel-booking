@extends("layouts.app")

@section("content")
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-muted-900 mb-4">
                    Enhanced UI Components
                </h1>
                <p class="text-xl text-muted-600 max-w-3xl mx-auto">
                    Modern, sleek design system with enhanced colors, shadows,
                    and rounded corners. All functionality preserved with
                    improved visual appeal.
                </p>
            </div>

            <!-- Buttons Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Buttons
                </h2>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-muted-700">
                            Primary Buttons
                        </h3>
                        <div class="space-y-3">
                            <x-primary-button>Primary Button</x-primary-button>
                            <x-primary-button disabled>
                                Disabled Primary
                            </x-primary-button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-muted-700">
                            Secondary Buttons
                        </h3>
                        <div class="space-y-3">
                            <x-secondary-button>
                                Secondary Button
                            </x-secondary-button>
                            <x-secondary-button disabled>
                                Disabled Secondary
                            </x-secondary-button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-muted-700">
                            Action Buttons
                        </h3>
                        <div class="space-y-3">
                            <x-success-button>Success Button</x-success-button>
                            <x-warning-button>Warning Button</x-warning-button>
                            <x-danger-button>Danger Button</x-danger-button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Components Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Form Components
                </h2>
                <div class="max-w-2xl">
                    <x-form-group label="Full Name" name="name" required>
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Enter your full name"
                        />
                    </x-form-group>

                    <x-form-group label="Email Address" name="email" required>
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            placeholder="Enter your email"
                        />
                    </x-form-group>

                    <x-form-group label="Message" name="message">
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            class="form-input"
                            placeholder="Enter your message"
                        ></textarea>
                    </x-form-group>

                    <x-form-group label="Category" name="category">
                        <select
                            id="category"
                            name="category"
                            class="form-input"
                        >
                            <option value="">Select a category</option>
                            <option value="general">General</option>
                            <option value="support">Support</option>
                            <option value="feedback">Feedback</option>
                        </select>
                    </x-form-group>

                    <div class="flex items-center gap-6 mt-6">
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="newsletter"
                                class="form-input"
                            />
                            <span class="text-muted-700">
                                Subscribe to newsletter
                            </span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input
                                type="radio"
                                name="contact_method"
                                value="email"
                                class="form-input"
                            />
                            <span class="text-muted-700">Email</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input
                                type="radio"
                                name="contact_method"
                                value="phone"
                                class="form-input"
                            />
                            <span class="text-muted-700">Phone</span>
                        </label>
                    </div>

                    <div class="mt-8">
                        <x-primary-button>Submit Form</x-primary-button>
                        <x-secondary-button class="ml-3">
                            Reset
                        </x-secondary-button>
                    </div>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Cards
                </h2>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <x-card header="Card Header" footer="Card Footer">
                        <p class="text-muted-600">
                            This is a beautiful card with enhanced styling,
                            featuring rounded corners, subtle shadows, and
                            backdrop blur effects.
                        </p>
                    </x-card>

                    <x-card>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-8 h-8 text-primary-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"
                                    ></path>
                                </svg>
                            </div>
                            <h3
                                class="text-lg font-semibold text-muted-900 mb-2"
                            >
                                Feature Title
                            </h3>
                            <p class="text-muted-600">
                                Feature description with enhanced visual appeal.
                            </p>
                        </div>
                    </x-card>

                    <x-card header="Interactive Card">
                        <p class="text-muted-600 mb-4">
                            This card demonstrates hover effects and modern
                            styling.
                        </p>
                        <div class="flex gap-2">
                            <x-primary-button>Action</x-primary-button>
                            <x-secondary-button>Cancel</x-secondary-button>
                        </div>
                    </x-card>
                </div>
            </div>

            <!-- Badges Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Badges
                </h2>
                <div class="flex flex-wrap gap-4">
                    <x-badge>Default Badge</x-badge>
                    <x-badge variant="primary">Primary Badge</x-badge>
                    <x-badge variant="success">Success Badge</x-badge>
                    <x-badge variant="warning">Warning Badge</x-badge>
                    <x-badge variant="error">Error Badge</x-badge>
                    <x-badge variant="muted">Muted Badge</x-badge>
                </div>
            </div>

            <!-- Alerts Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Alerts
                </h2>
                <div class="space-y-4 max-w-2xl">
                    <x-alert variant="info">
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5 text-primary-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <span>
                                This is an informational alert with enhanced
                                styling.
                            </span>
                        </div>
                    </x-alert>

                    <x-alert variant="success">
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5 text-success-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <span>
                                Success! Your action was completed successfully.
                            </span>
                        </div>
                    </x-alert>

                    <x-alert variant="warning">
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5 text-warning-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"
                                ></path>
                            </svg>
                            <span>
                                Warning: Please review your input before
                                proceeding.
                            </span>
                        </div>
                    </x-alert>

                    <x-alert variant="error">
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5 text-error-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <span>
                                Error: Something went wrong. Please try again.
                            </span>
                        </div>
                    </x-alert>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Tables
                </h2>
                <div class="overflow-hidden rounded-2xl shadow-soft">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>
                                    <x-badge variant="success">Active</x-badge>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <x-secondary-button
                                            class="!px-3 !py-1.5 text-xs"
                                        >
                                            Edit
                                        </x-secondary-button>
                                        <x-danger-button
                                            class="!px-3 !py-1.5 text-xs"
                                        >
                                            Delete
                                        </x-danger-button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>
                                    <x-badge variant="warning">Pending</x-badge>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <x-secondary-button
                                            class="!px-3 !py-1.5 text-xs"
                                        >
                                            Edit
                                        </x-secondary-button>
                                        <x-danger-button
                                            class="!px-3 !py-1.5 text-xs"
                                        >
                                            Delete
                                        </x-danger-button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Bob Johnson</td>
                                <td>bob@example.com</td>
                                <td>
                                    <x-badge variant="error">Inactive</x-badge>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <x-secondary-button
                                            class="!px-3 !py-1.5 text-xs"
                                        >
                                            Edit
                                        </x-secondary-button>
                                        <x-danger-button
                                            class="!px-3 !py-1.5 text-xs"
                                        >
                                            Delete
                                        </x-danger-button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Navigation Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Navigation
                </h2>
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-soft"
                >
                    <nav class="flex flex-wrap gap-2">
                        <x-nav-link href="#" class="nav-link-active">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link href="#">Users</x-nav-link>
                        <x-nav-link href="#">Settings</x-nav-link>
                        <x-nav-link href="#">Reports</x-nav-link>
                        <x-nav-link href="#">Help</x-nav-link>
                    </nav>
                </div>
            </div>

            <!-- Pagination Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Pagination
                </h2>
                <div class="flex justify-center">
                    <div class="pagination">
                        <a href="#" class="pagination-item">Previous</a>
                        <a href="#" class="pagination-item">1</a>
                        <a
                            href="#"
                            class="pagination-item pagination-item-active"
                        >
                            2
                        </a>
                        <a href="#" class="pagination-item">3</a>
                        <a href="#" class="pagination-item">4</a>
                        <a href="#" class="pagination-item">5</a>
                        <a href="#" class="pagination-item">Next</a>
                    </div>
                </div>
            </div>

            <!-- Color Palette Section -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-muted-900 mb-8">
                    Enhanced Color Palette
                </h2>
                <div
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4"
                >
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-primary-500 rounded-xl mx-auto mb-2 shadow-medium"
                        ></div>
                        <p class="text-sm font-medium text-muted-700">
                            Primary
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-accent-500 rounded-xl mx-auto mb-2 shadow-medium"
                        ></div>
                        <p class="text-sm font-medium text-muted-700">Accent</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-success-500 rounded-xl mx-auto mb-2 shadow-medium"
                        ></div>
                        <p class="text-sm font-medium text-muted-700">
                            Success
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-warning-500 rounded-xl mx-auto mb-2 shadow-medium"
                        ></div>
                        <p class="text-sm font-medium text-muted-700">
                            Warning
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-error-500 rounded-xl mx-auto mb-2 shadow-medium"
                        ></div>
                        <p class="text-sm font-medium text-muted-700">Error</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-muted-500 rounded-xl mx-auto mb-2 shadow-medium"
                        ></div>
                        <p class="text-sm font-medium text-muted-700">Muted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
