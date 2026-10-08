<div class="tienda-wrapper">
    <div class="container tienda-main-container">

        <!-- BARRA DE FILTROS Y BÚSQUEDA -->
        <div class="tienda-filter-card">
            <!-- Row 1: Search and Sort -->
            <div class="filter-row filter-row-primary">
                <!-- Search Box -->
                <div class="tienda-search-box">
                    <i class="fa fa-search search-magnifier"></i>
                    <input type="text" id="store_search" class="search-input" placeholder="Buscar por producto, modelo (ej. SBT-6) o accesorio..." autocomplete="off">
                    <button type="button" id="clear_search" class="search-clear-btn" style="display: none;" title="Limpiar búsqueda">
                        <i class="fa fa-times-circle"></i>
                    </button>
                </div>

                <!-- Sort Dropdown -->
                <div class="tienda-sort-box">
                    <label for="filter_orden" class="sort-title">
                        <i class="fa fa-sort-amount-desc"></i> <span class="d-none d-sm-inline">Ordenar por:</span>
                    </label>
                    <select id="filter_orden" class="tienda-dropdown-select">
                        <option value="destacados" selected>Destacados (Más vendidos)</option>
                        <option value="precio_asc">Precio: menor a mayor</option>
                        <option value="precio_desc">Precio: mayor a menor</option>
                        <option value="nombre_asc">Nombre: A - Z</option>
                        <option value="nombre_desc">Nombre: Z - A</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Category Pills + Model Select + Counter + Reset -->
            <div class="filter-row filter-row-secondary">
                <!-- Category Interactive Pills -->
                <div class="category-pills-bar">
                    <button type="button" class="btn-category-pill active" data-category="">
                        <i class="fa fa-th-large"></i> Todos
                    </button>
                    <button type="button" class="btn-category-pill" data-category="andamio">
                        <i class="fa fa-cubes"></i> Andamios
                    </button>
                    <button type="button" class="btn-category-pill" data-category="accesorio">
                        <i class="fa fa-wrench"></i> Accesorios
                    </button>
                    <!-- Hidden field to hold category -->
                    <input type="hidden" id="filter_categoria" value="">
                </div>

                <!-- Model selector & Reset -->
                <div class="filter-actions-right">
                    <div class="model-select-group">
                        <label for="filter_model" class="model-label">
                            <i class="fa fa-filter"></i> Modelo:
                        </label>
                        <select id="filter_model" class="tienda-dropdown-select model-dropdown">
                            <option value="" selected>Todos los modelos</option>
                            @if (!empty($catModelos) && !$catModelos->isEmpty())
                                @foreach ($catModelos as $item_modulos)
                                    <option value="{{ $item_modulos->nombre }}">{{ $item_modulos->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <button type="button" id="btn_reset_filters" class="btn-reset-filters-pill" style="display: none;" onclick="resetAllFilters()">
                        <i class="fa fa-refresh"></i> Limpiar filtros
                    </button>
                </div>
            </div>

            <!-- Status indicator -->
            <div class="filter-status-bar">
                <div id="products_counter" class="results-counter-pill">
                    <i class="fa fa-cubes"></i> Cargando catálogo...
                </div>
            </div>
        </div>

        <!-- PRODUCTS GRID -->
        <div class="row" id="list-products">
            <!-- Dynamic products loaded via AJAX -->
        </div>
    </div>
</div>
