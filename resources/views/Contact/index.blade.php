@if (!$ajax)
    @extends('Layouts.app')

    @section('content')
    <form class="row g-3" id="add-contact-form" action="{{route('contact.store')}}" method="post">
        @csrf
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">First </label>
            <input type="text" name="firstName" class="form-control" id="validationDefault01" placeholder="Enter Your First Name"  required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">Last name</label>
            <input type="text" name="lastName" class="form-control" id="validationDefault02" placeholder="Enter Your Last Name"  required>
        </div>
        <div class="col-12">
            <label class="form-label">Phone Numbers</label>
            <div class="row g-2 mb-2" id="phones">
                <div class="col-md-4">
                    <input type="text" name="phoneNumbers[]" class="form-control" placeholder="+380..." required>
                    <div class="invalid-feedback">
                        Please enter a valid international phone number (e.g. +1234567890).
                    </div>
                </div>
                <div class="col-auto">
                <button type="button" class="btn btn-primary" id="add-phone">+</button>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </form>

    <div id="success-message" class="alert" style="display: none;"></div>
    <div class="content-table">
        @include('Partials.contact-table')
    </div>
    @endsection

@else
    @include('Partials.contact-table')
@endif

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('submit', '#add-contact-form', function (e) {

                let formData = $(this).serialize();
                if (validateForm(this) === true) {
                    $.ajax({
                        url: "{{ route('contact.store') }}",
                        method: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.result === 'success') {
                                $('#success-message').text('Contact created successfully!')
                                    .addClass('alert-success')
                                    .show() // Show a success message
                                    .delay(5000).fadeOut(
                                    'slow'
                                ); // hide a success message after 5 seconds


                                $('#add-contact-form')[0].reset(); // Clear form inputs
                                $('.content-table').html(response.html) // Fill up the table
                            }
                        },
                        error: function () {
                            $('#success-message').text('Error while saving contact!')
                                .addClass('alert-error')
                                .show()// Show an error message
                                .delay(5000).fadeOut(
                                'slow'
                            ); // hide an error message after 5 seconds
                        }
                    });
                }
                return false;
            });

            document.querySelector('#add-phone').addEventListener('click', function () {
                const phoneField = document.createElement('div');
                phoneField.classList.add('row', 'g-2', 'mb-2', 'phone-group');
                phoneField.innerHTML = `
                        <div class="col-md-4">
                            <input name="phoneNumbers[]" class="form-control phone" placeholder="Add another number" required>
                        </div>
                        <div class="col-auto">
                        <button type="button" class="btn btn-danger remove-phone">-</button>
                        </div>`;
                document.getElementById('phones').appendChild(phoneField);
            });

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-phone')) {
                    e.target.closest('.phone-group').remove();
                }
            });

            function validateForm(form) {
                let res = true;
                form.querySelectorAll('[required]').forEach(function (field) {
                    if (!field.value || (field.name.includes('phoneNumbers') && !/^\+\d{7,15}$/.test(field.value))) {
                        field.classList.add('is-invalid');
                        res = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                return res;
            }
        });
    </script>
@endpush
