<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-normal">{{ __('Invoice Management System') }}</a>
        </div>
        <ul class="nav">
        <li>
        <a href="{{ route('home') }}">
            <i class="tim-icons icon-chart-pie-36"></i>
            <p>{{ __('Dashboard') }}</p>
        </a>
    </li>
    <li>
        <a data-toggle="collapse" href="#laravel-invoices" aria-expanded="true">
            <i class="fab fa-laravel"></i>
            <span class="nav-link-text">{{ __('Invoices') }}</span>
            <b class="caret mt-1"></b>
        </a>
        <div class="collapse show" id="laravel-invoices">
            <ul class="nav pl-4">
                <li>
                    <a href="{{ route('customer.create') }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('Create New Invoice') }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}">
                        <i class="tim-icons icon-bullet-list-67"></i>
                        <p>{{ __('Invoice History') }}</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <a data-toggle="collapse" href="#laravel-quotations" aria-expanded="true">
            <i class="fab fa-laravel"></i>
            <span class="nav-link-text">{{ __('Quotations') }}</span>
            <b class="caret mt-1"></b>
        </a>
        <div class="collapse show" id="laravel-quotations">
            <ul class="nav pl-4">
                <li>
                    <a href="{{ route('quote.create') }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('Create New Quote') }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('quote.index') }}">
                        <i class="tim-icons icon-bullet-list-67"></i>
                        <p>{{ __('Quote History') }}</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <a data-toggle="collapse" href="#laravel-customers" aria-expanded="true">
            <i class="fab fa-laravel"></i>
            <span class="nav-link-text">{{ __('Customers') }}</span>
            <b class="caret mt-1"></b>
        </a>
        <div class="collapse show" id="laravel-customers">
            <ul class="nav pl-4">
                <li>
                    <a href="{{ route('customer.create') }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('Create New Customer') }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}">
                        <i class="tim-icons icon-bullet-list-67"></i>
                        <p>{{ __('Customer History') }}</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <a data-toggle="collapse" href="#laravel-products" aria-expanded="true">
            <i class="fab fa-laravel"></i>
            <span class="nav-link-text">{{ __('Products') }}</span>
            <b class="caret mt-1"></b>
        </a>
        <div class="collapse show" id="laravel-products">
            <ul class="nav pl-4">
                <li>
                    <a href="{{ route('product.create') }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('Create New Product') }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('product.index') }}">
                        <i class="tim-icons icon-bullet-list-67"></i>
                        <p>{{ __('Products List') }}</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>


        </ul>
    </div>
</div>
