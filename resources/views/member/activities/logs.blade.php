<x-layouts.member title="Log Kegiatan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('member.activities.index') }}">Kegiatan</a></li>
            <li><a href="{{ route('member.activities.show', $activity) }}">{{ $activity->name ?? $activity->title ?? 'Detail' }}</a></li>
            <li>Log</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Log Kegiatan</h1>
                <p class="text-base-content/60">{{ $activity->name ?? $activity->title ?? 'Kegiatan' }}</p>
            </div>
            <a href="{{ route('member.activities.show', $activity) }}" class="btn btn-outline btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Detail
            </a>
        </div>
    </x-slot:header>

    <div class="card bg-base-100 shadow-md">
        <div class="card-body">
            @if($logs->count() > 0)
                <div class="space-y-4">
                    @foreach($logs as $log)
                        <div class="flex items-start gap-4 p-4 bg-base-200 rounded-lg">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-12 h-12 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium">{{ $log->title ?? 'Log Kegiatan' }}</p>
                                        <p class="text-sm text-base-content/60 mt-1">{{ $log->notes ?? $log->description ?? '-' }}</p>
                                    </div>
                                    <span class="badge badge-ghost">
                                        {{ $log->log_date?->format('d/m/Y') ?? $log->created_at?->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 mt-2 text-xs text-base-content/50">
                                    <span>{{ $log->log_date?->format('H:i') ?? $log->created_at?->format('H:i') }}</span>
                                    @if($log->user)
                                        <span>oleh {{ $log->user->person?->full_name ?? $log->user->email }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-base-content/50">Belum ada log untuk kegiatan ini</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.member>
