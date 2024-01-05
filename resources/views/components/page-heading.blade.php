<div class="flex justify-between items-end">
    <div>
        @if (isset($breadcrumb))
            <div class="mb-2">
                {{ $breadcrumb }}
            </div>
        @endif
        {{ $slot }}
    </div>
    @if (isset($action))
        <div>
            {{ $action }}
        </div>
    @endif
</div>
