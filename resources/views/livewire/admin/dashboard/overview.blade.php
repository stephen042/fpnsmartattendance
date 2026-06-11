<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">

        <div class="p-6 rounded-xl shadow bg-white dark:bg-neutral-900 border border-gray-100 dark:border-neutral-800">
            <p class="text-sm font-medium opacity-70">Total Enrolled Students</p>
            <p class="text-4xl font-bold mt-1">{{ $totalStudents }}</p>
            <div class="flex gap-4 mt-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                <div>
                    <span class="text-xs uppercase tracking-wider opacity-50 block">Male</span>
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $maleStudents }}</span>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider opacity-50 block">Female</span>
                    <span class="text-sm font-semibold text-pink-600 dark:text-pink-400">{{ $femaleStudents }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 rounded-xl shadow bg-white dark:bg-neutral-900 border border-gray-100 dark:border-neutral-800">
            <p class="text-sm font-medium opacity-70">Total Lecturers</p>
            <p class="text-4xl font-bold mt-1">{{ $totalLecturers }}</p>
            <div class="flex gap-4 mt-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                <div>
                    <span class="text-xs uppercase tracking-wider opacity-50 block">Male</span>
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $maleLecturers }}</span>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider opacity-50 block">Female</span>
                    <span class="text-sm font-semibold text-pink-600 dark:text-pink-400">{{ $femaleLecturers }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 rounded-xl shadow bg-white dark:bg-neutral-900 border border-gray-100 dark:border-neutral-800">
            <p class="text-sm font-medium opacity-70">Total Courses</p>
            <p class="text-4xl font-bold mt-1">{{ $totalCourses }}</p>
            <div class="flex gap-4 mt-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                <div>
                    <span class="text-xs uppercase tracking-wider opacity-50 block">OnGoing</span>
                    <span class="text-sm font-semibold text-green-600">{{ $ongoingCourses }}</span>
                </div>
                {{-- <div>
                        <span class="text-xs uppercase tracking-wider opacity-50 block">Pending</span>
                        <span class="text-sm font-semibold text-yellow-600">317</span>
                    </div> --}}
            </div>
        </div>
    </div>
</div>
