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
        <tr class="contact-row position-relative">
            <th scope="row">{{$contact->id}}</th>
            <td>{{$contact->firstName}}</td>
            <td>{{$contact->lastName}}</td>
            <td>@foreach($contact->phoneNumbers as $phone)
                    {{$phone->phoneNumber}}@if (!$loop->last), @endif
                @endforeach</td>
            <td class="action-buttons text-end">
                <a href="{{ route('contact.edit', $contact->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are You sure You want to delete this contact?')">Delete</button>
                </form>
            </td>
        </tr>
        </tbody>
    @endforeach
</table>
{{$contacts -> links()}}


