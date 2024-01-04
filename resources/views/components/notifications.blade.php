@props(['type' => session('flash.notificationStyle', 'success'), 'content' => session('flash.notification')])

<div
    x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: e.timeStamp,
                type: e.detail.type,
                content: e.detail.content,
            })
        },
        remove(notification) {
            this.notifications = this.notifications.filter(i => i.id !== notification.id)
        },
    }"
    @notify.window="add($event)"
    class="fixed bottom-0 right-0 flex w-full max-w-xs md:max-w-[420px] flex-col space-y-4 pr-4 pb-4 sm:justify-start"
    role="status"
    aria-live="polite"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-data="{
                show: false,
                init() {
                    this.$nextTick(() => this.show = true)
                    setTimeout(() => this.transitionOut(), 6000)
                },
                transitionOut() {
                    this.show = false
                    setTimeout(() => this.remove(this.notification), 500) },
                }"
            x-show="show"
            x-transition.duration.500ms
            class="pointer-events-auto relative w-full max-w-sm rounded-md border border-zinc-200 bg-white py-4 pl-6 pr-4 shadow-lg"
        >
            <div class="flex items-start">
                <div x-show="notification.type === 'error'" class="inline-flex mt-1 mr-3 flex-shrink-0">
                    <span aria-hidden="true" class="inline-flex h-4 w-4 items-center justify-center rounded-full border-2 border-red-600 text-xs font-bold text-red-600">&times;</span>
                    <span class="sr-only">Error:</span>
                </div>
                <div class="w-0 flex-1 pt-0.5">
                    <p x-text="notification.content" class="text-sm font-medium leading-5 text-zinc-900"></p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button @click="transitionOut()" type="button" class="inline-flex text-zinc-400">
                        <svg aria-hidden class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close notification</span>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<div
    x-data="{{ json_encode(['type' => $type, 'content' => $content]) }}"
    x-init="
        $nextTick(() => {
            if (content) $dispatch('notify', { content, type });
        });
    "
></div>
