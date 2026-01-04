<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Deisa - Login</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Theme Configuration -->
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec80",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a3326",
                        "text-main": "#0d1b14",
                        "text-muted": "#4c9a73",
                    },
                    fontFamily: {
                        "display": ["Manrope", "Noto Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;family=Noto+Sans:wght@300..800&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        /* Custom scrollbar for cleaner look if needed */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased selection:bg-primary selection:text-text-main">
<div class="flex min-h-screen w-full flex-row overflow-hidden">
<!-- Left Side: Hero/Image Section (Hidden on mobile, visible on lg screens) -->
<div class="hidden lg:flex lg:w-1/2 relative bg-surface-dark items-center justify-center overflow-hidden">
<!-- Background Image -->
<div class="absolute inset-0 z-0">
<div class="w-full h-full bg-cover bg-center opacity-80 mix-blend-overlay" data-alt="Students studying outdoors in a peaceful green campus environment" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAM1InwB68-F8Wj0tIHpv8UtU7PxEfjE6yUQawBU57mleT9e16Y0s52W9UTuNsch3H8X-mRzntrX9W3sSFKKP6F9Ie6epBu4vwLxEI4xfFcHg13uLAQVVYSTA3AcOYbHxMk9t48W_-8Gh1_BoqtMUONp9TNvG4q-U20KlWLabqlOxmRs5e2R72CE4RTQN1NKpzYX6k_pzL5JUXtpakcw-RU1b2WghvUd-HGlfMKo5dK1HPYmohDGWNjECLy8uPnKjAsMEMcAtlAMdWe");'>
</div>
<div class="absolute inset-0 bg-gradient-to-t from-background-dark/90 via-background-dark/40 to-transparent"></div>
</div>
<!-- Content Overlay -->
<div class="relative z-10 flex flex-col items-start justify-end h-full w-full p-16 pb-24">
<div class="mb-8 p-4 rounded-xl bg-primary/20 backdrop-blur-sm border border-primary/10 inline-flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-4xl">spa</span>
</div>
<h1 class="text-white text-5xl font-bold leading-tight tracking-tight max-w-lg mb-6">
                    Welcome Back, Santri!
                </h1>
<p class="text-gray-200 text-lg font-medium leading-relaxed max-w-md">
                    Continue your wellness journey with Deisa. Track your health, access resources, and stay balanced.
                </p>
</div>
</div>
<!-- Right Side: Login Form -->
<div class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-background-light dark:bg-background-dark overflow-y-auto">
<div class="w-full max-w-md flex flex-col gap-8">
<!-- Mobile Header (Logo + Title) -->
<div class="flex flex-col gap-2">
<div class="flex items-center gap-3 text-text-main dark:text-white mb-2">
<div class="size-8 text-primary">
<svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-2xl font-bold tracking-tight">Deisa</h2>
</div>
<h1 class="text-3xl font-bold text-text-main dark:text-white tracking-tight">Log in to your account</h1>
<p class="text-text-muted dark:text-gray-400 text-base">Welcome back! Please enter your details.</p>
</div>
<!-- Form -->
<form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
@csrf
<!-- Email Field -->
<div class="flex flex-col gap-2">
<label class="text-text-main dark:text-gray-200 text-sm font-semibold leading-normal" for="email">Email Address</label>
<input class="form-input flex w-full rounded-lg border @error('email') border-red-500 @else border-[#cfe7db] dark:border-gray-700 @enderror bg-surface-light dark:bg-surface-dark px-4 py-3 text-base text-text-main dark:text-white placeholder:text-text-muted dark:placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-primary transition-colors h-12" id="email" name="email" placeholder="admin@pesantren.com" type="email" value="{{ old('email') }}" required autofocus/>
@error('email')
    <span class="text-red-500 text-xs font-medium">{{ $message }}</span>
@enderror
</div>
<!-- Password Field -->
<div class="flex flex-col gap-2">
<label class="text-text-main dark:text-gray-200 text-sm font-semibold leading-normal" for="password">Password</label>
<div class="relative flex items-center">
<input class="form-input flex w-full rounded-lg border @error('password') border-red-500 @else border-[#cfe7db] dark:border-gray-700 @enderror bg-surface-light dark:bg-surface-dark px-4 py-3 pr-12 text-base text-text-main dark:text-white placeholder:text-text-muted dark:placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-primary transition-colors h-12" id="password" name="password" placeholder="Enter your password" type="password" required/>
<button class="absolute right-4 text-text-muted dark:text-gray-500 hover:text-primary transition-colors flex items-center justify-center" type="button" onclick="togglePassword()">
<span class="material-symbols-outlined" id="eyeIcon" style="font-size: 20px;">visibility_off</span>
</button>
</div>
@error('password')
    <span class="text-red-500 text-xs font-medium">{{ $message }}</span>
@enderror
</div>
<!-- Remember Me & Forgot Password -->
<div class="flex justify-between items-center">
<label class="flex items-center gap-2 cursor-pointer">
<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 cursor-pointer"/>
<span class="text-text-muted dark:text-gray-400 text-sm font-medium">Remember me</span>
</label>
</div>
<!-- Submit Button -->
<button class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary hover:bg-green-600 text-text-main text-base font-bold h-12 px-6 transition-all active:scale-[0.98]" type="submit">
Log In
</button>
</form>
<!-- Footer -->
<div class="text-center">
<p class="text-text-main dark:text-gray-300 text-sm">
                        Don't have an account? 
                        <a class="font-bold text-primary hover:text-green-400 hover:underline transition-colors" href="#">Sign up</a>
</p>
</div>
</div>
</div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = 'visibility';
    } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = 'visibility_off';
    }
}
</script>
</body></html>