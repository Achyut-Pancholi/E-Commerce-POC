<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight" style="font-family: 'Outfit', sans-serif;">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            padding: 2rem;
            transition: transform 0.3s ease;
        }
        .glass-panel:hover {
            transform: translateY(-5px);
        }
        .dashboard-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: calc(100vh - 65px);
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
        .welcome-text {
            background: linear-gradient(to right, #4f46e5, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #c7d2fe, #fbcfe8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #4f46e5;
        }
        .stat-info h4 {
            margin: 0;
            font-size: 0.9rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .stat-info p {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }
    </style>

    <div class="dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel">
                <h3 class="welcome-text">Welcome back, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600 text-lg mb-8">Manage your orders, profile, and discover new products.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('orders.index') }}" class="block">
                        <div class="stat-card hover:shadow-lg transition-shadow cursor-pointer h-full">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); color: #4f46e5;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="stat-info">
                                <h4>My Orders</h4>
                                <p>View History</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="block">
                        <div class="stat-card hover:shadow-lg transition-shadow cursor-pointer h-full">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #fce7f3, #fbcfe8); color: #db2777;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="stat-info">
                                <h4>Profile</h4>
                                <p>Edit Details</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('home') }}" class="block">
                        <div class="stat-card hover:shadow-lg transition-shadow cursor-pointer h-full">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0d9488;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div class="stat-info">
                                <h4>Shop</h4>
                                <p>Browse Products</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
