@extends('Layouts.app')
@section('content')
<form class="row g-3" id="add-contact-form" action="{{route('contact.store')}}" method="post">
    @csrf
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">First </label>
        <input type="text" name="firstName" pattern="[A-Za-z0-9]+" class="form-control" id="validationDefault01" placeholder="Enter Your First Name"  required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Last name</label>
        <input type="text" name="lastName" pattern="[A-Za-z0-9]+" class="form-control" id="validationDefault02" placeholder="Enter Your Last Name"  required>
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
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
    </div>


</form>
<div class="content-table">
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Phone Numbers</th>
    </tr>
    </thead>
    @foreach($contacts as $contact)
    <tbody>
    <tr>
        <th scope="row">{{$contact->id}}</th>
        <td>{{$contact->firstName}}</td>
        <td>{{$contact->lastName}}</td>
        <td>@foreach($contact->phoneNumbers as $phone)
                {{$phone->phoneNumber}}@if (!$loop->last), @endif
        @endforeach</td>
    </tr>
    </tbody>
    @endforeach
</table>
        {{$contacts -> links()}}
</div>
@endsection

@push('scripts')
    <script>
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

        document.getElementById('add-contact-form').addEventListener('submit', function (event) {
            event.preventDefault();

            if (validateForm(this) === true) {
                this.submit();
            }
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
    </script>
@endpush
