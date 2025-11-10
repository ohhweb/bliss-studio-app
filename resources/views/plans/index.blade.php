<x-app-layout>
    <div class="py-12 bg-primary text-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-8">Choose Your Plan</h2>
            <div class="bg-secondary rounded-lg p-8">
                <h3 class="text-2xl font-bold text-accent">Free Plan</h3>
                <p class="text-gray-400 mt-2">Currently, our app is in a development stage, so all content is available for free. Enjoy!</p>
                <div class="mt-6">
                    <form method="POST" action="{{ route('plans.store') }}">
                        @csrf
                        <button type="submit" class="w-full bg-accent hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg">
                            Select Free Plan
                        </button>
                    </form>
                </div>
            </div>
            {{--
            
            GUIDE FOR FUTURE PLANS:
            To add more plans, you would just copy the `div` above and change the details.
            You would also update your `store` method in the controller to handle different plan values.
            
            <div class="bg-secondary rounded-lg p-8 mt-4">
                <h3 class="text-2xl font-bold text-accent">Premium Plan</h3>
                ...
            </div>
            
            --}}
        </div>
    </div>
</x-app-layout>