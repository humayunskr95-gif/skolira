@extends('layouts.school_admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">
    <section class="relative overflow-hidden rounded-[32px] bg-slate-950 px-6 py-8 text-white shadow-2xl md:px-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.35),_transparent_30%),radial-gradient(circle_at_left,_rgba(129,140,248,0.25),_transparent_30%)]"></div>
        <div class="relative grid gap-8 lg:grid-cols-[1.35fr,0.65fr]">
            <div class="space-y-5">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-sky-200">
                    School Admin Control Center
                </div>
                <div>
                    <p class="text-sm text-slate-300">{{ now()->format('d M Y') }}</p>
                    <h1 class="mt-2 max-w-2xl text-3xl font-bold leading-tight md:text-5xl">
                        {{ $school?->name ?? 'Your School' }} dashboard with live academic and finance insights.
                    </h1>
                    <p class="mt-4 max-w-2xl text-sm text-slate-300 md:text-base">
                        Track people, admissions, content activity, and monthly collections from one premium overview.
                    </p>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Monthly Fees</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-300">Rs {{ number_format($monthlyFees, 2) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Expenses</p>
                        <p class="mt-2 text-2xl font-bold text-amber-300">Rs {{ number_format($monthlyExpenses, 2) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Net Balance</p>
                        <p class="mt-2 text-2xl font-bold {{ $netBalance >= 0 ? 'text-cyan-300' : 'text-rose-300' }}">
                            Rs {{ number_format($netBalance, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-300">Pending Admissions</p>
                            <h2 class="mt-2 text-4xl font-bold">{{ $pendingAdmissions }}</h2>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400/15 text-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l3.414 3.414A1 1 0 0 1 17 7.414V19a2 2 0 0 1-2 2Z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-300">Content Activity</p>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-2xl bg-white/5 p-4">
                            <p class="text-slate-400">Notices</p>
                            <p class="mt-2 text-2xl font-bold">{{ $noticeCount }}</p>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4">
                            <p class="text-slate-400">Gallery</p>
                            <p class="mt-2 text-2xl font-bold">{{ $galleryCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Students</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">{{ $students }}</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.742-.479 3 3 0 0 0-4.682-2.72m.94 3.198v-.001c0-1.126-.312-2.216-.9-3.16M18 18.72a8.966 8.966 0 0 1-5.182 1.53 8.966 8.966 0 0 1-5.182-1.53m10.364 0a9.06 9.06 0 0 0-10.364 0m10.364 0A9.06 9.06 0 0 0 12 15.75a9.06 9.06 0 0 0-5.182 2.97m0 0a9.094 9.094 0 0 1-3.742-.479 3 3 0 0 1 4.682-2.72m-.94 3.198v-.001c0-1.126.312-2.216.9-3.16M15 7.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-5">
                <div class="mb-2 flex items-center justify-between text-xs text-slate-500">
                    <span>Usage</span>
                    <span>{{ $studentLimit ? $students . ' / ' . $studentLimit : 'No limit set' }}</span>
                </div>
                <div class="h-2 rounded-full bg-slate-100">
                    <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $studentUsage }}%"></div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Teachers</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">{{ $teachers }}</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14.25c-2.485 0-4.5-2.239-4.5-5s2.015-5 4.5-5 4.5 2.239 4.5 5-2.015 5-4.5 5Zm0 0c4.556 0 8.25 2.35 8.25 5.25v.75H3.75v-.75c0-2.9 3.694-5.25 8.25-5.25Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-5">
                <div class="mb-2 flex items-center justify-between text-xs text-slate-500">
                    <span>Usage</span>
                    <span>{{ $teacherLimit ? $teachers . ' / ' . $teacherLimit : 'No limit set' }}</span>
                </div>
                <div class="h-2 rounded-full bg-slate-100">
                    <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $teacherUsage }}%"></div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Parents</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">{{ $parents }}</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372c1.035 0 2.03-.166 2.962-.47a3 3 0 0 0-4.17-2.432M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128a9.376 9.376 0 0 1-6 0m6 0A9.376 9.376 0 0 0 9 19.128m0 0v-.003c0-1.113.285-2.16.786-3.07m0 0a3 3 0 1 0-5.572-1.46 9.373 9.373 0 0 0-.292 3.892A9.38 9.38 0 0 0 6.375 19.5c1.035 0 2.03-.166 2.962-.47M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-5 text-sm text-slate-500">Family communication and result access</p>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Support Staff</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">{{ $accountants }}</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15a.75.75 0 0 1 .75.75v16.5H3.75V3.75A.75.75 0 0 1 4.5 3Zm3 4.5h9m-9 4.5h9m-9 4.5h6" />
                    </svg>
                </div>
            </div>
            <p class="mt-5 text-sm text-slate-500">Accounts and admin support snapshot</p>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.2fr,0.8fr]">
        <div class="rounded-[30px] bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">School Community</h2>
                    <p class="text-sm text-slate-500">Pie chart of your active school community composition.</p>
                </div>
                <div class="rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    Live Distribution
                </div>
            </div>
            <div class="mt-6 grid gap-6 lg:grid-cols-[0.95fr,1.05fr]">
                <div class="mx-auto flex w-full max-w-[320px] items-center justify-center">
                    <canvas id="communityChart" height="280"></canvas>
                </div>
                <div class="grid gap-4">
                    <div class="rounded-2xl bg-indigo-50 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-700">Students</p>
                            <p class="text-xl font-bold text-indigo-900">{{ $students }}</p>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-emerald-50 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-emerald-700">Teachers</p>
                            <p class="text-xl font-bold text-emerald-900">{{ $teachers }}</p>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-rose-50 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-rose-700">Parents</p>
                            <p class="text-xl font-bold text-rose-900">{{ $parents }}</p>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-amber-50 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-amber-700">Support Staff</p>
                            <p class="text-xl font-bold text-amber-900">{{ $accountants }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-[30px] bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Monthly Finance Split</h2>
                <p class="text-sm text-slate-500">Collection vs expense with a clean pie chart.</p>
            </div>
            <div class="mt-6 mx-auto flex max-w-[320px] items-center justify-center">
                <canvas id="financeChart" height="280"></canvas>
            </div>
            <div class="mt-6 grid gap-3">
                <div class="flex items-center justify-between rounded-2xl bg-emerald-50 px-4 py-3">
                    <span class="text-sm text-emerald-700">Collection</span>
                    <span class="font-semibold text-emerald-900">Rs {{ number_format($monthlyFees, 2) }}</span>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-amber-50 px-4 py-3">
                    <span class="text-sm text-amber-700">Expense</span>
                    <span class="font-semibold text-amber-900">Rs {{ number_format($monthlyExpenses, 2) }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.95fr,1.05fr]">
        <div class="rounded-[30px] bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Quick Actions</h2>
            <p class="mt-1 text-sm text-slate-500">Jump straight into the work that matters most today.</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <a href="{{ tenant_route('students.create') }}" class="rounded-3xl bg-indigo-50 p-5 transition hover:-translate-y-1 hover:bg-indigo-100">
                    <p class="text-sm font-semibold text-indigo-700">Student Admission</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Add New Student</h3>
                    <p class="mt-2 text-sm text-slate-600">Create student records and assign class details quickly.</p>
                </a>
                <a href="{{ tenant_route('teachers.create') }}" class="rounded-3xl bg-emerald-50 p-5 transition hover:-translate-y-1 hover:bg-emerald-100">
                    <p class="text-sm font-semibold text-emerald-700">Faculty</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Add Teacher</h3>
                    <p class="mt-2 text-sm text-slate-600">Bring new teachers into the school workflow.</p>
                </a>
                <a href="{{ route('school_admin.fees.report') }}" class="rounded-3xl bg-amber-50 p-5 transition hover:-translate-y-1 hover:bg-amber-100">
                    <p class="text-sm font-semibold text-amber-700">Finance</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Review Fees</h3>
                    <p class="mt-2 text-sm text-slate-600">Check class-wise paid, due, and monthly bill status.</p>
                </a>
                <a href="{{ tenant_route('admissions.index') }}" class="rounded-3xl bg-rose-50 p-5 transition hover:-translate-y-1 hover:bg-rose-100">
                    <p class="text-sm font-semibold text-rose-700">Website</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Manage Admissions</h3>
                    <p class="mt-2 text-sm text-slate-600">Approve or review incoming admission requests.</p>
                </a>
            </div>
        </div>

        <div class="rounded-[30px] bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Operational Snapshot</h2>
                <p class="text-sm text-slate-500">A clean summary of content and admissions activity.</p>
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Pending Admissions</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900">{{ $pendingAdmissions }}</p>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Needs Review</span>
                </div>
                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Published Notices</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900">{{ $noticeCount }}</p>
                    </div>
                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">Website Ready</span>
                </div>
                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Gallery Uploads</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900">{{ $galleryCount }}</p>
                    </div>
                    <span class="rounded-full bg-fuchsia-100 px-3 py-1 text-xs font-semibold text-fuchsia-700">Media Active</span>
                </div>
                <div class="rounded-3xl bg-slate-900 p-5 text-white">
                    <p class="text-sm text-slate-300">Dashboard Note</p>
                    <p class="mt-2 text-lg font-semibold">
                        {{ $netBalance >= 0 ? 'Collections are currently ahead of expenses this month.' : 'Expenses are currently higher than collections this month.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
const communityCtx = document.getElementById('communityChart');
if (communityCtx) {
    new Chart(communityCtx, {
        type: 'pie',
        data: {
            labels: ['Students', 'Teachers', 'Parents', 'Support Staff'],
            datasets: [{
                data: [{{ $students }}, {{ $teachers }}, {{ $parents }}, {{ $accountants }}],
                backgroundColor: ['#6366f1', '#10b981', '#f43f5e', '#f59e0b'],
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 12
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10,
                        padding: 18
                    }
                }
            }
        }
    });
}

const financeCtx = document.getElementById('financeChart');
if (financeCtx) {
    new Chart(financeCtx, {
        type: 'pie',
        data: {
            labels: ['Collection', 'Expense'],
            datasets: [{
                data: [{{ $monthlyFees }}, {{ $monthlyExpenses }}],
                backgroundColor: ['#14b8a6', '#fb923c'],
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 12
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10,
                        padding: 18
                    }
                }
            }
        }
    });
}
</script>
@endsection
