<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeIn: "fadeIn 1s ease-in-out",
                    },
                    keyframes: {
                        fadeIn: {
                            "0%": { opacity: "0", transform: "translateY(-20px)" },
                            "100%": { opacity: "1", transform: "translateY(0)" },
                        },
                    },
                },
            },
        };
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen w-full">
    <div class="bg-white shadow-md rounded-lg flex flex-col md:flex-row w-full h-screen overflow-hidden p-6 md:p-0">
        
        <!-- Bagian Form -->
        <div class="md:w-1/2 w-full p-6 md:p-12 flex flex-col justify-center text-center md:text-left animate-fadeIn">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Sign Up</h2>
            <p class="text-lg mb-4">If you already have an account</p>
            <p class="text-lg mb-8">You can <a href="{{ route('login') }}" class="text-blue-500 font-bold">Login here!</a></p>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Email</label>
                    <div class="flex items-center border-b border-gray-300 py-3 transition-all duration-300 focus-within:border-blue-500 hover:shadow-lg">
                        <i class="fas fa-envelope text-gray-500 mr-3"></i>
                        <input type="email" name="email" required class="w-full bg-transparent outline-none" placeholder="Enter your email">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Username</label>
                    <div class="flex items-center border-b border-gray-300 py-3 transition-all duration-300 focus-within:border-blue-500 hover:shadow-lg">
                        <i class="fas fa-user text-gray-500 mr-3"></i>
                        <input type="text" name="username" required class="w-full bg-transparent outline-none" placeholder="Enter your username">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Password</label>
                    <div class="flex items-center border-b border-gray-300 py-3 transition-all duration-300 focus-within:border-blue-500 hover:shadow-lg">
                        <i class="fas fa-lock text-gray-500 mr-3"></i>
                        <input type="password" name="password" required class="w-full bg-transparent outline-none" placeholder="Enter your password">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Confirm Password</label>
                    <div class="flex items-center border-b border-gray-300 py-3 transition-all duration-300 focus-within:border-blue-500 hover:shadow-lg">
                        <i class="fas fa-lock text-gray-500 mr-3"></i>
                        <input type="password" name="password_confirmation" required class="w-full bg-transparent outline-none" placeholder="Confirm your password">
                    </div>
                </div>
                <button class="w-full bg-black text-white py-3 text-lg rounded-full shadow-md hover:bg-gray-800 focus:outline-none transition-all duration-300 transform hover:scale-105">
                    Register
                </button>
            </form>

            <div class="flex justify-center mt-6 text-2xl">
                <a href="#" class="text-blue-500 mx-4 transition duration-300 transform hover:scale-125"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-red-500 mx-4 transition duration-300 transform hover:scale-125"><i class="fab fa-google"></i></a>
            </div>
        </div>

        <!-- Bagian Video -->
        <div class="md:w-1/2 w-full flex items-center justify-center bg-black text-white p-6 md:p-12 relative animate-fadeIn">
            <video autoplay loop muted class="w-full h-full object-cover rounded-lg">
                <source src="{{ asset('assets/register.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute bottom-6 md:bottom-12 left-6 md:left-12 text-white text-center md:text-left animate-fadeIn">
                <h2 class="text-4xl md:text-5xl font-bold">Join Us Today</h2>
                <p class="text-lg md:text-xl mt-2">Start your journey now</p>
            </div>
        </div>

    </div>
</body>
</html>