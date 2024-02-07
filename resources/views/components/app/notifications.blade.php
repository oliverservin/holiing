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
    aria-live="assertive"
    class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-end sm:p-6"
>
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
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
                class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white/75 backdrop-blur-xl dark:bg-zinc-800/75 shadow-lg ring-1 ring-zinc-950/10 dark:ring-inset dark:ring-white/10"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div x-show="notification.type === 'error'" class="flex-shrink-0 mr-3">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="w-0 flex-1">
                            <p x-text="notification.content" class="text-base/6 text-zinc-950 sm:text-sm/6 dark:text-white font-medium"></p>
                        </div>
                        <div class="ml-4 flex flex-shrink-0">
                            <x-button @click="transitionOut()" type="button" plain>
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-5 w-5" data-slot="icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<div
    x-data="{{ json_encode(['type' => $type, 'content' => $content]) }}"
    x-init="
        $nextTick(() => {
            if (content) $dispatch('notify', { content, type });
        });
    "
></div>
