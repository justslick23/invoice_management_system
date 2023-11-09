<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" style="font-size: 0.8rem;" class="simple-text logo-normal text-sm">{{ __('Invoice Management System') }}</a>
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p class="menu-text">{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-invoices" aria-expanded="false">
                    <i class="tim-icons icon-coins"></i>
                    <p class="menu-text">{{ __('Invoices') }}</p>
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="laravel-invoices">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('invoice.create') }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p class="menu-text">{{ __('Create New Invoice') }}</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoice.index') }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p class="menu-text">{{ __('Invoice History') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-quotations" aria-expanded="false">
                    <i class="tim-icons icon-paper"></i>
                    <p class="menu-text">{{ __('Quotations') }}</p>
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="laravel-quotations">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('quote.create') }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p class="menu-text">{{ __('Create New Quotation') }}</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('quote.index') }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p class="menu-text">{{ __('Quotation History') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-customers" aria-expanded="false">
                    <i class="tim-icons icon-single-02"></i>
                    <p class="menu-text">{{ __('Customers') }}</p>
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="laravel-customers">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('customer.create') }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p class="menu-text">{{ __('Create New Customer') }}</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.index') }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p class="menu-text">{{ __('Customer History') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-products" aria-expanded="false">
                    <i class="tim-icons icon-tag"></i>
                    <p class="menu-text">{{ __('Products') }}</p>
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="laravel-products">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('product.create') }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p class="menu-text">{{ __('Create New Product') }}</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('product.index') }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p class="menu-text">{{ __('Products List') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Add more menu items as needed -->
        </ul>
    </div>
</div>
