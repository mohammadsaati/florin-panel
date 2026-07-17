<div class="my-3 flex flex-wrap items-center justify-center md:justify-between gap-4 w-full">
    @if($hasPagination)
        <div class="flex items-center gap-2 order-1 md:order-2">
            <span class="text-2sm text-gray-500">
                نمایش
            </span>

            <x-table.select-option
                name="per_page"
                :options="$perPageOptions"
                :value="$perPage"
                :wire-model="$perPageWireModel"
                :wire-model-live="true"
                size="sm"
                classes="w-20"
            />

            <span class="text-2sm text-gray-500">
                در هر صفحه
            </span>
        </div>


        <div class="flex flex-wrap items-center gap-4 order-2 md:order-1">
            {!! $paginator->links() !!}
        </div>
    @endif
</div>
