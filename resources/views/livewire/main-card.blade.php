<div
    class="w-full max-w-screen-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    <form class="space-y-6" action="#">
        <div class=" flex flex-row">
            <select wire:model="employeeId"
                    class="text-xl py-3 px-4 pr-9 mr-3 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
            >
                <option value="">Select an Employee</option>
                @foreach($employees as $employee)
                    <option
                        value="{{ $employee->id }}">{{ $employee->title }} {{ $employee->forename }} {{ $employee->surname }}</option>
                @endforeach
            </select>

            <select wire:model="selectedDate"
                    class="text-xl py-3 px-4 pr-9 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                    @if (empty($dates))
                        hidden="hidden"
                    @endif
            >
                <option value="">Select a Date</option>
                @foreach($dates as $date)
                    <option value="{{ $date->format('Y-m-d') }}">{{ $date->format('D jS M Y') }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

    <livewire:student-list/>
</div>

