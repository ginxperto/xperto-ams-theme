<form role="search" method="get" id="search-form" action="<?php echo esc_url(home_url('/')); ?>" class="input-group mb-3">
    <div class="input-group">
        <input type="search" class="form-control w-full px-4 py-3 bg-xperto-neutral-light-2" placeholder="Search" aria-label="search nico" name="s" id="search-input" value="<?php echo esc_attr(get_search_query()); ?>">
        <div class="input-group-append">
            <span class="input-group-append p-0">
                <i class="fas fa-search text-muted"></i>
            </span>
        </div>
    </div>
</form>