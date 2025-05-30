@extends('Layouts.app')

@section('content')
    <h2>Edit Contact</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="row g-3" id="edit-contact-form" action="{{ route('contact.update', $contact->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="col-md-4">
            <label class="form-label">First Name</label>
            <input type="text" name="firstName" class="form-control" value="{{ old('firstName', $contact->firstName) }}" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Last Name</label>
            <input type="text" name="lastName" class="form-control" value="{{ old('lastName', $contact->lastName) }}" required>
        </div>

        <div class="col-12">
            <label class="form-label">Phone Numbers</label>
            <div id="phones">
                @foreach($contact->phoneNumbers as $index => $phone)
                    <div class="row g-2 mb-2 phone-group">
                        <div class="col-md-4">
                            <input type="text" name="phoneNumbers[]" class="form-control phone"
                                   value="{{ old("phoneNumbers.$index", $phone->phoneNumber) }}"
                                   required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-phone">-</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary mt-2" id="add-phone">+ Add Phone</button>
        </div>

        <div class="col-12">
            <button class="btn btn-success" type="submit">Save</button>
            <a href="{{ route('contact.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('add-phone').addEventListener('click', function () {
            const phoneField = document.createElement('div');
            phoneField.classList.add('row', 'g-2', 'mb-2', 'phone-group');
            phoneField.innerHTML = `
            <div class="col-md-4">
                <input name="phoneNumbers[]" class="form-control phone" placeholder="+380..." required>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-phone">-</button>
            </div>
        `;
            document.getElementById('phones').appendChild(phoneField);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-phone')) {
                e.target.closest('.phone-group').remove();
            }
        });
    </script>
@endpush
