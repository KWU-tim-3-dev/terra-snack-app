<div>
    <div class="max-w-content mx-auto px-mobile-gutter min-h-screen">
        @if ($user)
            <h3>Active User : </h3>
            <p>id : {{ $user->id }}</p>
            <p>name : {{ $user->name }}</p>
            <p>phone : {{ $user->phone }}</p>
            <p>email : {{ $user->email }}</p>
            <p>email_verified_at : {{ $user->email_verified_at }}</p>
            <p>role : {{ $user->role }}</p>
            <p>created_at : {{ $user->created_at }}</p>
            <p>updated_at : {{ $user->updated_at }}</p>
        @else
            <p>No Active User</p>
        @endif
    </div>
</div>
