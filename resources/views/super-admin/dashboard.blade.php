@extends('layouts.super-admin-app')

@section('content')
<div class="main chat-main-screen">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout">
            @include('super-admin.side_nav_bar')



            <main class="order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title">Customers</h1>
                    </div>

                    <!-- start Setting section -->
                    <section class="custom-section">
                        <div class="customize-tab setting-tab ">




                            <form id="itemForm" method="GET" action="{{-- {{ route('items.index') }} --}}" class="mb-4">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search keyword..." class="form-control" aria-label="Search keyword">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>

                                <div class="mt-2">
                                    <label for="order">Limit:</label>
                                    <select name="limit" class="form-control" aria-label="Limit" onchange="submitForm()">
                                        <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </div>

                             {{--    <div class="mt-2">
                                    <label for="order">Order:</label>
                                    <select name="order" id="order" class="form-control" onchange="submitForm()">
                                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>ASC</option>
                                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>DES</option>
                                    </select>
                                </div> --}}
                            </form>

                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Restaurant</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($customers[0]))
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->user_name }}</td>
                                        <td>{{ $customer->user_email }}</td>
                                        <td>{{ $customer->restaurant_name }}</td>
                                        <td>{{ $customer->created_at }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">No items found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>

                            @if(!empty($customers[0]))
                            <div class="d-flex justify-content-center">
                                {{ $customers->appends(request()->query())->links() }}
                            </div>
                            @endif

                            <script>
                                function submitForm() {
                                    document.getElementById('itemForm').submit();
                                }

                            </script>








                        </div>
                    </section>
                    <!-- end Setting section -->
                </div>
            </main>






        </div>
    </div>
    <!-- start footer -->
    @include('layouts.admin.footer_design')
    <!-- end footer -->
</div>
@endsection


