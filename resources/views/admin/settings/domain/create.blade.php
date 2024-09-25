<form action="{{ route('domain-setting.store') }}" method="POST">
        @csrf
        <label for="domain">Domain:</label>
        <input type="text" id="domain" name="domain" required>
      {{--   <br>
        <label for="tenant_id">Tenant:</label>
        <select id="tenant_id" name="tenant_id" required>
            <option value="1">go-meal</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
            @endforeach
        </select>
        <br> --}}
        <button type="submit">Save</button>
    </form>