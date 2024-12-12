@php
use App\Models\User;

if(isset($userids)) {
    $usernames = User::whereIn('id', $userids)->pluck('littlelink_name')->toArray();
}
@endphp

<i class="mb-2 d-block">{{ block_text('These links will only be visible to logged-in members of this instance.') }}</i>
    
<div class="mb-3">
    <label for='group_title' class='form-label'>{{ block_text('Group Title') }}</label>
    <input type='text' name='group_title' value='{{$title}}' class='form-control' />
</div>

<label for='usernames[]' class='form-label'>{{ block_text('Usernames') }}</label>
<div id="name-container" class="">
    @if(isset($usernames) && is_array($usernames))
        @foreach($usernames as $index => $username)
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="exampleuser" name="usernames[]" value="{{ $username }}">
                <span class="input-group-text">
                    <i style="cursor:pointer" class="fa-solid fa-xmark text-danger" onclick="{{ $index === 0 ? 'clearInput(this)' : 'removeInput(this)' }}"></i>
                </span>
            </div>
        @endforeach
    @else
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="exampleuser" name="usernames[]">
            <span class="input-group-text">
                <i style="cursor:pointer" class="fa-solid fa-xmark text-danger" onclick="clearInput(this)"></i>
            </span>
        </div>
    @endif
</div>

<div class="input-group mb-3">
    <span class='small text-muted'>{{ block_text("Enter the usernames of users who should be able to view your links. A username is what appears in the user's page URL. For example, in example.com/@exampleuser, the username is exampleuser (without the @).") }}</span>

</div>


<button type="button" class="btn btn-primary mt-2" id="add-name">Add Another User</button>

<div style="height:3rem"></div>

<div id="form-container">
    @if(isset($link_groups) && is_array($link_groups))
        @foreach($link_groups as $index => $link_group)
            <div class="form-group">
                <div class="card rounded shadow-lg bg-light aos-init aos-animate" data-aos="fade-up" data-aos-delay="800">
                    <div class="flex-wrap card-header d-flex justify-content-between align-items-center bg-light">
                        <div class="header-title">
                            <h6 class="card-title">Link:</h6>         
                        </div>
                    </div>
                    <div class="card-body">
                        <label for='title' class='form-label'>{{ __('messages.Title') }}</label>
                        <input type='text' name='links[{{ $index }}][title]' value='{{ $link_group["title"] }}' class='form-control' />
                
                        <label for='link' class='form-label'>{{ __('messages.URL') }}</label>
                        <input type='url' name='links[{{ $index }}][link]' value='{{ $link_group["link"] }}' class='form-control' required />
                        
                        @if($index > 0)
                            <button type="button" class="btn btn-danger btn-sm remove-form mt-3">Remove</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="form-group">
            <div class="card rounded shadow-lg bg-light aos-init aos-animate" data-aos="fade-up" data-aos-delay="800">
                <div class="flex-wrap card-header d-flex justify-content-between align-items-center bg-light">
                    <div class="header-title">
                        <h6 class="card-title">Link:</h6>         
                    </div>
                </div>
                <div class="card-body">
                    <label for='title' class='form-label'>{{ __('messages.Title') }}</label>
                    <input type='text' name='links[0][title]' value='' class='form-control' />
            
                    <label for='link' class='form-label'>{{ __('messages.URL') }}</label>
                    <input type='url' name='links[0][link]' value='' class='form-control' required />
                </div>
            </div>
        </div>
    @endif
</div>

<button type="button" class="btn btn-primary mt-2" id="add-form">Add Another Link</button>

<script>
    document.getElementById('add-name').addEventListener('click', function() {
        const nameContainer = document.getElementById('name-container');
        const newInputDiv = document.createElement('div');
        newInputDiv.className = 'input-group mb-3';
        newInputDiv.innerHTML = `
            <input type="text" class="form-control" name="usernames[]">
            <span class="input-group-text">
                <i style="cursor:pointer" class="fa-solid fa-xmark text-danger" onclick="removeInput(this)"></i>
            </span>
        `;
        nameContainer.appendChild(newInputDiv);
    });

    function clearInput(element) {
        element.closest('.input-group').querySelector('input').value = '';
    }

    function removeInput(element) {
        element.closest('.input-group').remove();
    }

    document.getElementById('add-form').addEventListener('click', function() {
        var formContainer = document.getElementById('form-container');
        var formCount = formContainer.children.length;
        var newForm = formContainer.firstElementChild.cloneNode(true);
        
        // Clear the input fields in the new form
        newForm.querySelectorAll('input[type="text"], input[type="url"]').forEach(input => input.value = '');
        
        // Update the name attributes to include the correct index
        newForm.querySelectorAll('input').forEach(input => {
            var name = input.name;
            input.name = name.replace(/\d+/, formCount);
        });

        // Add a remove button to the new form
        var removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm remove-form mt-3';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
            newForm.remove();
        });
        newForm.querySelector('.card-body').appendChild(removeButton);

        formContainer.appendChild(newForm);
    });

    // Add event listeners to existing remove buttons
    document.querySelectorAll('.remove-form').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.form-group').remove();
        });
    });
</script>