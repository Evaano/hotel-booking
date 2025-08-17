@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-12">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-muted-900">Contact Us</h1>
            <p class="text-xl text-muted-600 max-w-3xl mx-auto">
                Have questions or need assistance? We're here to help make your
                island adventure perfect!
            </p>
        </div>

        <!-- Contact Information & Form -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div class="space-y-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold text-muted-900">
                            Get in Touch
                        </h2>
                    </div>
                    <div class="card-body space-y-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-primary-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    Phone Support
                                </h3>
                                <p class="text-muted-600">+1 (555) 123-4567</p>
                                <p class="text-sm text-muted-500">
                                    Available 24/7 for urgent matters
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-primary-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    Email Support
                                </h3>
                                <p class="text-muted-600">
                                    info@picnicisland.com
                                </p>
                                <p class="text-sm text-muted-500">
                                    We respond within 2 hours
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-primary-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    Island Location
                                </h3>
                                <p class="text-muted-600">
                                    Picnic Island, Paradise Bay
                                </p>
                                <p class="text-sm text-muted-500">
                                    Coordinates: 12.3456° N, 78.9012° W
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-primary-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    Business Hours
                                </h3>
                                <p class="text-muted-600">
                                    Monday - Sunday: 6:00 AM - 10:00 PM
                                </p>
                                <p class="text-sm text-muted-500">
                                    Island time (GMT-5)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="card border-l-4 border-error-500">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            Emergency Contact
                        </h3>
                        <p class="text-muted-600 mb-3">
                            For medical emergencies or urgent safety concerns:
                        </p>
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5 text-error-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                />
                            </svg>
                            <span class="font-semibold text-error-600">
                                Emergency: +1 (555) 911-0000
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-2xl font-bold text-muted-900">
                        Send us a Message
                    </h2>
                </div>
                <div class="card-body">
                    @if (session("success"))
                        <x-alert variant="success">
                            {{ session("success") }}
                        </x-alert>
                    @endif

                    <form
                        action="{{ route("contact.send") }}"
                        method="POST"
                        class="space-y-6"
                    >
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="name" value="Full Name *" />
                                <x-text-input
                                    type="text"
                                    name="name"
                                    id="name"
                                    required
                                    placeholder="Enter your full name"
                                />
                                @error("name")
                                    <p class="form-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <x-input-label
                                    for="email"
                                    value="Email Address *"
                                />
                                <x-text-input
                                    type="email"
                                    name="email"
                                    id="email"
                                    required
                                    placeholder="Enter your email"
                                />
                                @error("email")
                                    <p class="form-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-input-label
                                for="subject"
                                :value="__('Subject *')"
                            />
                            <select
                                id="subject"
                                name="subject"
                                class="form-input"
                                required
                            >
                                <option value="">Select a subject</option>
                                <option
                                    value="General Inquiry"
                                    {{ old("subject") == "General Inquiry" ? "selected" : "" }}
                                >
                                    General Inquiry
                                </option>
                                <option
                                    value="Hotel Booking"
                                    {{ old("subject") == "Hotel Booking" ? "selected" : "" }}
                                >
                                    Hotel Booking
                                </option>
                                <option
                                    value="Ferry Schedule"
                                    {{ old("subject") == "Ferry Schedule" ? "selected" : "" }}
                                >
                                    Ferry Schedule
                                </option>
                                <option
                                    value="Theme Park"
                                    {{ old("subject") == "Theme Park" ? "selected" : "" }}
                                >
                                    Theme Park
                                </option>
                                <option
                                    value="Beach Events"
                                    {{ old("subject") == "Beach Events" ? "selected" : "" }}
                                >
                                    Beach Events
                                </option>
                                <option
                                    value="Technical Support"
                                    {{ old("subject") == "Technical Support" ? "selected" : "" }}
                                >
                                    Technical Support
                                </option>
                                <option
                                    value="Feedback"
                                    {{ old("subject") == "Feedback" ? "selected" : "" }}
                                >
                                    Feedback
                                </option>
                                <option
                                    value="Other"
                                    {{ old("subject") == "Other" ? "selected" : "" }}
                                >
                                    Other
                                </option>
                            </select>
                            <x-input-error
                                :messages="$errors->get('subject')"
                                class="mt-2"
                            />
                            @error("subject")
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="message" value="Message *" />
                            <textarea
                                name="message"
                                id="message"
                                rows="5"
                                required
                                class="form-input"
                                placeholder="Tell us how we can help you..."
                            ></textarea>
                            @error("message")
                                <p class="form-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="newsletter"
                                id="newsletter"
                                class="form-input"
                            />
                            <label
                                for="newsletter"
                                class="text-sm text-muted-600"
                            >
                                Subscribe to our newsletter for updates and
                                special offers
                            </label>
                        </div>

                        <x-primary-button type="submit" class="w-full">
                            {{ __("Send Message") }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="space-y-6">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-muted-900 mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-muted-600">
                    Find quick answers to common questions about our island
                    paradise.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            How do I book a hotel room?
                        </h3>
                        <p class="text-muted-600 text-sm">
                            You can book hotels directly through our website.
                            Simply browse available hotels, select your dates,
                            and complete the booking process. You'll receive a
                            confirmation email with all the details.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            Do I need a hotel booking for ferry tickets?
                        </h3>
                        <p class="text-muted-600 text-sm">
                            Yes, hotel booking is required before purchasing
                            ferry tickets. This ensures all visitors have
                            accommodation and helps us manage island capacity
                            effectively.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            What's included in theme park tickets?
                        </h3>
                        <p class="text-muted-600 text-sm">
                            Theme park tickets include general admission to the
                            park. Individual activities and experiences may have
                            additional costs. Check the activity details for
                            specific pricing information.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            Are beach events suitable for children?
                        </h3>
                        <p class="text-muted-600 text-sm">
                            Most beach events are family-friendly, but some may
                            have age restrictions. Check the event details for
                            specific requirements and recommendations.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            What should I bring to the island?
                        </h3>
                        <p class="text-muted-600 text-sm">
                            Essential items include sunscreen, swimwear,
                            comfortable walking shoes, and any personal
                            medications. Most amenities are available on the
                            island, but it's good to bring your essentials.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            Is there Wi-Fi available on the island?
                        </h3>
                        <p class="text-muted-600 text-sm">
                            Yes, complimentary Wi-Fi is available in all hotels,
                            restaurants, and public areas. The connection is
                            reliable and fast for all your communication needs.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Support -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-muted-900 mb-2">
                        Need More Help?
                    </h3>
                    <p class="text-muted-600 mb-4">
                        Our support team is available 24/7 to assist you with
                        any questions or concerns.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a href="tel:+15551234567" class="btn-primary">
                            Call Now
                        </a>
                        <a
                            href="mailto:info@picnicisland.com"
                            class="btn-secondary"
                        >
                            Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
