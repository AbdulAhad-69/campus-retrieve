<?php include __DIR__ . '/../layouts/header.php'; ?>

<style type="text/tailwindcss">
    @layer components {
        /* Layout Containers */
        .login-wrapper {
            @apply min-h-screen flex items-center justify-center p-4 bg-gray-50;
        }
        .login-card {
            @apply max-w-4xl w-full bg-white rounded-2xl shadow-xl overflow-hidden flex;
        }
        
        /* Left Side (Brand) */
        .brand-section {
            @apply w-1/2 bg-blue-600 p-12 text-white hidden md:flex flex-col justify-between relative;
        }
        .brand-overlay {
            @apply absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')];
        }

        /* Right Side (Form) */
        .form-section {
            @apply w-full md:w-1/2 p-12;
        }
        
        /* Form Elements */
        .form-group {
            @apply mb-5; /* Spacing between inputs */
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }
        .form-input {
            @apply w-full px-4 py-3 rounded-lg border border-gray-300 
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                   outline-none transition ease-in-out duration-200;
        }
        .btn-primary {
            @apply w-full bg-blue-600 hover:bg-blue-700 text-white font-bold 
                   py-3 rounded-lg transition duration-200 shadow-md transform active:scale-95;
        }
        
        /* Links & Text */
        .link-blue {
            @apply text-blue-600 hover:text-blue-500 font-medium transition;
        }
        .text-helper {
            @apply text-sm text-gray-500;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        <div class="brand-section">
            <div class="z-10">
                <h1 class="text-3xl font-bold tracking-tight">Campus Retrieve</h1>
                <p class="mt-2 text-blue-100">The official Lost & Found platform.</p>
            </div>
            <div class="z-10">
                <blockquote class="text-blue-100 italic">
                    "Integrity is doing the right thing, even when no one is watching."
                </blockquote>
            </div>
            <div class="brand-overlay"></div>
        </div>

        <div class="form-section">
            <div class="text-center md:text-left mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
                <p class="text-helper">Please enter your student credentials.</p>

                <?php if (isset($error) && $error): ?>
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
            </div>

            <form action="/campus-retrieve/public/login" method="POST">

                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_id" class="form-input" placeholder="e.g. 18101139" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between text-sm mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="link-blue">Forgot password?</a>
                </div>

                <button type="submit" class="btn-primary">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center text-helper">
                Don't have an account?
                <a href="/campus-retrieve/public/register" class="link-blue">Create Account</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>