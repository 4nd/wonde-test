<div>
    @if ($students->count() == 0)
        <p>Select an employee & date.</p>
    @else
        @php
            $headerClass = "border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left";
            $rowClass = "border-b border-slate-100 dark:border-slate-700 p-2 pl-8 text-slate-500 dark:text-slate-400"
        @endphp

        <table class="table-auto">
            <thead>
            <tr>
                <th class="{{ $headerClass }}">Name</th>
                <th class="{{ $headerClass }}">Class</th>
                <th class="{{ $headerClass }}">See at</th>
                <th class="{{ $headerClass }}">Room</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td class="{{ $rowClass }}">{{ $student->getName() }}</td>
                    <td class="{{ $rowClass }}">{{ $student->getClassName() }}</td>
                    <td class="{{ $rowClass }}">{{ $student->getFirstSeenTime() }}</td>
                    <td class="{{ $rowClass }}">{{ $student->getRoom() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
