<span class="relative flex items-center h-20">
    <span>
        📃
    </span>

    <div class="absolute text-xs left-7 bottom-5">
        ✋
    </div>

    <span class="text-gray-600 dark:text-gray-400" style="font-size: 0.7rem;">
        {{ __('process paused') }}
    </span>

    @if (isset($step) && isset($record))
        @if ($step['step'] === 1 && $record->stock_write_off_number)
            <span class="absolute top-4 left-12 text-gray-600 dark:text-gray-200 text-xs truncate">
                {{ $record->stock_write_off_number }}
            </span>
        @endif

        @if ($step['step'] === 2 && $record->material_document)
            <span class="absolute top-4 left-12 text-gray-600 dark:text-gray-200 text-xs truncate">
                {{ $record->material_document }}
            </span>
        @endif
    @endif
</span>
