@extends('Layouts.app')
@section('content')
<form class="row g-3">
    @csrf
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">First </label>
        <input type="text" name="firstName" class="form-control" id="validationDefault01" placeholder="Enter Your First Name" value="" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Last name</label>
        <input type="text" name="lastName" class="form-control" id="validationDefault02" placeholder="Enter Your Last Name" value="" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefaultUsername" class="form-label">Phone Number</label>
        <div class="input-group">
            <button class="input-group-text" id="add-phone">+</button>
            <input type="text" name="number" class="form-control" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
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
        <td>{{$contact->phone}}</td>
    </tr>
    </tbody>
    @endforeach
</table>
</div>
@endsection

@push('scripts')
    <script>
        document.querySelector('#add-phone').addEventListener('click', function () {
            const phoneField = document.createElement('div');
            phoneField.classList.add('row', 'g-2', 'mb-2', 'phone-group');
            phoneField.innerHTML = `
        <div class="col-md-4">
            <input name="number" class="form-control phone" placeholder="+380..." required>
        </div>
        <div class="col-auto"><button type="button" class="btn btn-danger remove-phone">-</button></div>`;
            document.getElementById('phones').appendChild(phoneField);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-phone')) {
                e.target.closest('.phone-group').remove();
            }
        });
    </script>
@endpush
