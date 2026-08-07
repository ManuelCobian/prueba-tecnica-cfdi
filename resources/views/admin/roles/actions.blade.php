<div class="flex items-center space-x-2">

    <x-wire-button href="{{ route('admin.roles.edit', $role) }}" blue xs>
        <i class="fa fa-pencil"></i>
    </x-wire-button>

    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        
        <x-wire-button type="submit" red xs>
            <i class="fa fa-trash"></i>
        </x-wire-button>

    </form>
</div>
