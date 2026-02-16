<?php include __DIR__ . '/../layouts/header.php'; ?>

<style type="text/tailwindcss">
    @layer components {
        .login-wrapper { @apply min-h-screen flex items-center justify-center p-4 bg-gray-50; }
        .login-card { @apply max-w-4xl w-full bg-white rounded-2xl shadow-xl overflow-hidden flex; }
        .brand-section { @apply w-1/2 bg-blue-600 p-12 text-white hidden md:flex flex-col justify-between relative; }
        .brand-overlay { @apply absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]; }
        .form-section { @apply w-full md:w-1/2 p-12; }
        .form-group { @apply mb-4; } /* Slightly tighter spacing for more fields */
        .form-label { @apply block text-sm font-medium text-gray-700 mb-1; }
        .form-input { @apply w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition ease-in-out duration-200; }
        .btn-primary { @apply w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200 shadow-md transform active:scale-95; }
        .link-blue { @apply text-blue-600 hover:text-blue-500 font-medium transition; }
        .text-helper { @apply text-sm text-gray-500; }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        <div class="brand-section">
            <div class="z-10">
                <h1 class="text-3xl font-bold tracking-tight">Join Campus Retrieve</h1>
                <p class="mt-2 text-blue-100">Help us build a trustworthy community.</p>
            </div>
            <div class="z-10">
                <ul class="space-y-4 text-blue-100">
                    <li class="flex items-center"><span class="mr-2">✓</span> Verify lost items easily</li>
                    <li class="flex items-center"><span class="mr-2">✓</span> Secure campus network</li>
                    <li class="flex items-center"><span class="mr-2">✓</span> Instant notifications</li>
                </ul>
            </div>
            <div class="brand-overlay"></div>
        </div>

        <div class="form-section">
            <div class="text-center md:text-left mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
                <p class="text-helper">Use your university ID and email.</p>

                <?php if (isset($error) && $error): ?>
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
            </div>

            <form action="/campus-retrieve/public/register" method="POST">

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-input" placeholder="John Doe" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Student ID</label>
                        <input type="text" name="student_id" class="form-input" placeholder="1810..." required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-input" placeholder="017..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Uni Email</label>
                    <input type="email" name="email" class="form-input" placeholder="student@uni.edu" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-primary mt-2">
                    Register
                </button>
            </form>

            <div class="mt-6 text-center text-helper">
                Already have an account?
                <a href="/campus-retrieve/public/login" class="link-blue">Sign In</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>