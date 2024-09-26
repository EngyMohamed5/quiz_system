<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    
    <!-- Hero Section with Background Image and Gradient Overlay -->
    <section class="hero-section position-relative text-white text-center py-5" style="background-image: url('https://source.unsplash.com/1600x900/?quiz,education'); background-size: cover; background-position: center;">
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.6);"></div>
        <div class="container position-relative z-1">
            <h1 class="display-3 fw-bold">Welcome to the Online Quiz System</h1>
            <p class="lead mb-4">Enhance your skills and knowledge with exciting quizzes on various topics!</p>
            <a href="#" class="btn btn-lg btn-outline-light px-4 py-3">Start a Quiz Now</a>
        </div>
    </section>

    <!-- Features Section with Icons and Shadows -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="icon mb-3">
                                <i class="fas fa-chart-line fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title fw-bold">Track Your Progress</h5>
                            <p class="card-text">Monitor your quiz history and see your improvement over time with detailed stats.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="icon mb-3">
                                <i class="fas fa-book-open fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title fw-bold">Various Topics</h5>
                            <p class="card-text">Pick from a wide variety of topics and sharpen your skills with expert-designed quizzes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="icon mb-3">
                                <i class="fas fa-stopwatch fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title fw-bold">Time-Limited Quizzes</h5>
                            <p class="card-text">Challenge yourself with time-limited quizzes that push your limits!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section with Gradient Background -->
    <section class="cta-section text-center py-5 text-white" style="background: linear-gradient(135deg, #007bff 0%, #6c63ff 100%);">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">Ready to Test Your Knowledge?</h2>
            <p class="lead">Sign up or log in to take a quiz and track your progress!</p>
            <a href="#" class="btn btn-lg btn-light px-4 py-3 mt-3">Get Started</a>
        </div>
    </section>

    <!-- Footer with Social Media Icons -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p>&copy; 2024 Online Quiz System. All rights reserved.</p>
            <p>
                <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

   
</x-app-layout>
