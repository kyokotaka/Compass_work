<x-sidebar>
    <div class="p-4">
        <div class="calendar-header">
            <div class="flex items-center space-x-4">
                <button class="calendar-header-btn" onclick="changeView('month')">月間</button>
                <button class="calendar-header-btn" onclick="changeView('week')">週間</button>
            </div>
            <!-- <div class="date-selector">
                <button onclick="prevMonth()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button> -->
                <span id="currentDate" class="text-lg font-semibold">2025年6月</span>
                <button onclick="nextMonth()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            <!-- </div> -->
        </div>

        <!-- カレンダー表示エリア -->
        <div class="overflow-x-auto mt-4">
    <div class="grid grid-cols-8 border-b font-semibold">
        <div class="p-2 border">時間</div>
        <div class="p-2 border">月</div>
        <div class="p-2 border">火</div>
        <div class="p-2 border">水</div>
        <div class="p-2 border">木</div>
        <div class="p-2 border">金</div>
        <div class="p-2 border">土</div>
        <div class="p-2 border">日</div>
    </div>

    @foreach ($shifts as $shift)
    <div class="border p-2 mb-2">
        <strong>{{ $shift->school_category }}</strong><br>
        場所: {{ $shift->location }}<br>
        開始: {{ \Carbon\Carbon::parse($shift->start_time)->format('Y-m-d H:i') }}<br>
        終了: {{ \Carbon\Carbon::parse($shift->end_time)->format('Y-m-d H:i') }}<br>
        登録者: {{ $shift->user ? $shift->user->over_name : '不明' }}
    </div>
@endforeach
</div>
</x-sidebar>

<!-- JavaScript -->
<script>
    const shifts = @json($shifts);

document.addEventListener("DOMContentLoaded", function () {
    shifts.forEach(shift => {
        const start = new Date(shift.start_time);

        const dayOfWeek = start.getDay();
        let displayDay = dayOfWeek === 0 ? 7 : dayOfWeek;

        const hour = start.getHours();

        const selector = `.day-cell[data-day='${displayDay}'][data-hour='${hour}']`;
        const cell = document.querySelector(selector);

        if (cell) {
            const shiftDiv = document.createElement('div');
            shiftDiv.className = 'absolute inset-1 bg-blue-300 text-xs rounded p-1 overflow-hidden';
            shiftDiv.innerHTML = `
                <strong>${shift.school_category}</strong><br>
                ${shift.location}<br>
                ${start.getHours()}:${String(start.getMinutes()).padStart(2, '0')}〜<br>
                <span class="block text-gray-700 mt-1">by ${shift.user.name}</span>
            `;
            cell.appendChild(shiftDiv);
        }
    });
});
</script>