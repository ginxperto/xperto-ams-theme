<form role="search" method="get" id="search-form" action="<?php echo esc_url(home_url('/')); ?>" class="body-search input-group">
    <label for="simple-search" class="sr-only">Search</label>
    <div class="relative w-full group">
        <input type="search" class="form-control w-full px-4 py-3 bg-xperto-neutral-light-2 text-xperto-neutral-mid-2 text-sm rounded-lg p-2.5 focus:bg-white focus:ring-xperto-orange-focus focus-visible:outline-xperto-orange-focus" placeholder="Search" aria-label="search" name="s" id="search-input" value="<?php echo esc_attr(get_search_query()); ?>" required>
        <div id="search-icon-right" class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none group-focus-within:hidden group-focus:hidden">
            <svg aria-hidden="true" class="w-5 h-5 text-xperto-orange" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
        </div>
    </div>
</form>